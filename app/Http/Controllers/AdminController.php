<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'customers' => User::where('role', User::ROLE_CUSTOMER)->count(),
            'sellers' => Seller::count(),
            'couriers' => Courier::count(),
            'products' => Product::count(),
            'orders' => Order::count(),
            'revenue' => (float) Order::where('status', Order::STATUS_DELIVERED)->sum('total'),
        ];

        $orders = Order::with(['customer.user', 'seller', 'courier.user'])->latest()->take(30)->get();
        $couriers = Courier::with('user')->get();
        $users = User::orderBy('role')->orderBy('name')->get();

        return view('layouts.admin.dashboard', compact('stats', 'orders', 'couriers', 'users'));
    }

    /** Ubah role user; profil seller/kurir dibuat otomatis bila belum ada. */
    public function updateRole(Request $request, User $user)
    {
        $role = $request->validate(['role' => ['required', Rule::in(User::ROLES)]])['role'];

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa mengubah role akun Anda sendiri.');
        }

        $user->update(['role' => $role]);

        switch ($role) {
            case User::ROLE_SELLER:
                Seller::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'store_name' => "Toko {$user->name}",
                        'store_slug' => $this->uniqueSlug($user->name),
                        'status' => 'active',
                    ]
                );
                break;

            case User::ROLE_COURIER:
                Courier::firstOrCreate(
                    ['user_id' => $user->id],
                    ['phone' => $user->customer?->phone ?? '-', 'status' => 'offline']
                );
                break;

            case User::ROLE_CUSTOMER:
                $user->ensureCustomerProfile();
                break;
        }

        return back()->with('success', "Role {$user->name} diubah menjadi {$role}.");
    }

    /** Tugaskan / ganti kurir untuk pesanan yang sudah dikonfirmasi penjual. */
    public function assignCourier(Request $request, Order $order)
    {
        $data = $request->validate(['courier_id' => ['required', 'exists:couriers,id']]);

        if ($order->status !== Order::STATUS_CONFIRMED) {
            return back()->with('error', 'Kurir hanya bisa ditugaskan untuk pesanan berstatus dikonfirmasi.');
        }

        $order->update(['courier_id' => $data['courier_id']]);

        return back()->with('success', "Kurir ditugaskan untuk pesanan {$order->order_number}.");
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'toko';
        $slug = $base;
        $i = 1;

        while (Seller::where('store_slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
