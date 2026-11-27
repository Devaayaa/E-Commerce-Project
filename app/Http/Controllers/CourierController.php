<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\CourierLocation;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CourierController extends Controller
{
    public function dashboard()
    {
        $courier = $this->courier();

        $orders = $courier->orders()
            ->whereIn('status', [Order::STATUS_CONFIRMED, Order::STATUS_SHIPPED])
            ->with(['items', 'seller', 'customer.user'])
            ->orderByRaw("CASE status WHEN 'shipped' THEN 0 ELSE 1 END")
            ->latest()
            ->get();

        $deliveredToday = $courier->orders()
            ->where('status', Order::STATUS_DELIVERED)
            ->whereDate('updated_at', today())
            ->count();

        return view('layouts.courier.dashboard', compact('courier', 'orders', 'deliveredToday'));
    }

    /** Kurir mengatur dirinya online (available) / offline. */
    public function setStatus(Request $request)
    {
        $courier = $this->courier();
        $status = $request->validate(['status' => ['required', Rule::in(['available', 'offline'])]])['status'];

        if ($status === 'offline' && $courier->status === 'on_delivery') {
            $msg = 'Please complete your ongoing delivery before going offline.';
            return $request->wantsJson() ? response()->json(['error' => $msg], 400) : back()->with('error', $msg);
        }

        $courier->update(['status' => $status]);
        $msg = $status === 'available' ? 'You are now online.' : 'You are now offline.';

        if ($request->wantsJson()) {
            return response()->json(['success' => $msg, 'status' => $status]);
        }

        return back()->with('success', $msg);
    }

    /** Kurir mengambil paket dari toko → status order "shipped". */
    public function pickup(Order $order)
    {
        $courier = $this->courier();
        abort_unless($order->courier_id === $courier->id, 403);

        if ($order->status !== Order::STATUS_CONFIRMED) {
            return back()->with('error', 'Pesanan ini tidak bisa diambil.');
        }

        DB::transaction(function () use ($order, $courier) {
            $order->update(['status' => Order::STATUS_SHIPPED]);
            $courier->update(['status' => 'on_delivery']);
        });

        return back()->with('success', "Pesanan {$order->order_number} sedang diantar. Aktifkan GPS agar pelanggan bisa melacak.");
    }

    /** Kurir menyelesaikan pengantaran → status order "delivered". */
    public function deliver(Order $order)
    {
        $courier = $this->courier();
        abort_unless($order->courier_id === $courier->id, 403);

        if ($order->status !== Order::STATUS_SHIPPED) {
            return back()->with('error', 'Pesanan ini belum dalam pengantaran.');
        }

        DB::transaction(function () use ($order, $courier) {
            $order->update(['status' => Order::STATUS_DELIVERED]);

            foreach ($order->items()->get() as $item) {
                if ($item->product_id) {
                    Product::whereKey($item->product_id)->increment('sold', $item->quantity);
                }
            }

            $stillDelivering = $courier->orders()->where('status', Order::STATUS_SHIPPED)->exists();
            $courier->update(['status' => $stillDelivering ? 'on_delivery' : 'available']);
        });

        return back()->with('success', "Pesanan {$order->order_number} berhasil diantar. Terima kasih!");
    }

    /** Dipanggil berkala oleh browser kurir (Geolocation API) untuk mengirim posisi terkini. */
    public function updateLocation(Request $request)
    {
        $courier = $this->courier();

        $data = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $courier->update([
            'current_latitude' => $data['latitude'],
            'current_longitude' => $data['longitude'],
            'last_location_update' => now(),
        ]);

        $courier->orders()->where('status', Order::STATUS_SHIPPED)->pluck('id')->each(
            fn($orderId) => CourierLocation::create([
                'courier_id' => $courier->id,
                'order_id' => $orderId,
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ])
        );

        return response()->json(['ok' => true, 'updated_at' => now()->toIso8601String()]);
    }

    /** Helper untuk mendapatkan data kurir yang sedang login. */
    private function courier(): Courier
    {
        $courier = Auth::user()->courier;

        abort_unless($courier, 403, 'Akun Anda belum terdaftar sebagai kurir. Hubungi admin.');

        return $courier;
    }

    /** Proses penarikan saldo (Withdraw) */
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50000',
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_name' => 'required|string',
        ]);

        $courier = Auth::user()->courier;

        if (! $courier) {
            return response()->json(['error' => 'Courier profile not found.'], 404);
        }

        try {
            DB::transaction(function () use ($request, $courier) {
                // Kunci baris kurir agar dua request bersamaan tidak bisa menarik saldo ganda
                $locked = Courier::whereKey($courier->id)->lockForUpdate()->first();

                if ($request->amount > $locked->balance) {
                    throw new \RuntimeException('Insufficient balance.');
                }

                $locked->decrement('balance', $request->amount);

                Withdrawal::create([
                    'courier_id' => $locked->id,
                    'amount' => $request->amount,
                    'bank_name' => $request->bank_name,
                    'account_number' => $request->account_number,
                    'account_name' => $request->account_name,
                    'status' => 'pending',
                ]);
            });
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json(['success' => 'Withdrawal requested successfully! Waiting for Admin approval.']);
    }

    /** Update Profil Kurir */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'vehicle_type' => 'required|string',
            'vehicle_plate' => 'required|string',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->update([
            'name' => $request->name
        ]);

        $courier = $user->courier;

        if ($courier) {
            $courier->update([
                'phone' => $request->phone,
                'vehicle_type' => $request->vehicle_type,
                'vehicle_plate' => $request->vehicle_plate,
            ]);
        }

        return response()->json([
            'success' => 'Profile updated successfully!'
        ]);
    }
}
