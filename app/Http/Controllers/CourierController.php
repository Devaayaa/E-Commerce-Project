<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\CourierLocation;
use App\Models\Order;
use App\Models\Product;
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
            return back()->with('error', 'Selesaikan pengantaran yang sedang berjalan sebelum offline.');
        }

        $courier->update(['status' => $status]);

        return back()->with('success', $status === 'available' ? 'Anda sekarang online.' : 'Anda sekarang offline.');
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

        // Simpan jejak perjalanan untuk setiap order yang sedang diantar.
        $courier->orders()->where('status', Order::STATUS_SHIPPED)->pluck('id')->each(
            fn ($orderId) => CourierLocation::create([
                'courier_id' => $courier->id,
                'order_id' => $orderId,
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ])
        );

        return response()->json(['ok' => true, 'updated_at' => now()->toIso8601String()]);
    }

    private function courier(): Courier
    {
        $courier = auth()->user()->courier;
        abort_unless($courier, 403, 'Akun Anda belum terdaftar sebagai kurir. Hubungi admin.');

        return $courier;
    }
}
