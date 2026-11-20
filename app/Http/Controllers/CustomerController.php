<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /** Slug lama (Indonesia) dipetakan ke slug standar yang tersimpan di database. */
    private const CATEGORY_ALIASES = [
        'elektronik' => 'electronics',
        'kecantikan' => 'beauty',
        'rumah' => 'home',
    ];

    public function home()
    {
        // Mengambil 4 produk terbaru untuk di Beranda
        $products = Product::where('stock', '>', 0)->latest()->take(4)->get();

        return view('customer.home', compact('products'));
    }

    public function shop(Request $request)
    {
        $query = Product::query();

        // Logika Pencarian (Search)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Logika Filter Kategori
        if ($request->filled('category') && $request->category !== 'all') {
            $category = strtolower($request->category);
            $category = self::CATEGORY_ALIASES[$category] ?? $category;
            $query->where('category', $category);
        }

        $products = $query->latest()->get();

        return view('customer.shop', compact('products'));
    }

    public function categories()
    {
        return view('customer.categories');
    }

    public function about()
    {
        return view('customer.about');
    }

    public function contact()
    {
        return view('customer.contact');
    }

    /**
     * /lacak            -> daftar pesanan milik user yang login
     * /lacak/{nomor}    -> detail + peta pelacakan satu pesanan
     */
    public function tracking($order_id = null)
    {
        $user = auth()->user();

        if (! $order_id) {
            $orders = Order::visibleTo($user)
                ->with(['items', 'courier.user'])
                ->latest()
                ->take(50)
                ->get();

            return view('customer.tracking', ['order' => null, 'order_id' => null, 'orders' => $orders]);
        }

        $order = Order::with(['items', 'seller', 'courier.user'])
            ->where('order_number', $order_id)
            ->firstOrFail();

        abort_unless($order->isVisibleTo($user), 403, 'Pesanan ini bukan milik Anda.');

        return view('customer.tracking', ['order' => $order, 'order_id' => $order_id, 'orders' => null]);
    }

    /** Endpoint JSON yang di-polling halaman tracking untuk posisi kurir real-time. */
    public function trackingLocation($order_id)
    {
        $order = Order::with(['seller', 'courier.user'])
            ->where('order_number', $order_id)
            ->firstOrFail();

        abort_unless($order->isVisibleTo(auth()->user()), 403);

        $courier = $order->courier;

        return response()->json([
            'status' => $order->status,
            'status_label' => $order->statusLabel(),
            'progress' => $order->progressPercent(),
            'eta_minutes' => $order->etaMinutes(),
            'destination' => [
                'lat' => $order->shipping_latitude,
                'lng' => $order->shipping_longitude,
            ],
            'origin' => [
                'lat' => $order->seller?->latitude,
                'lng' => $order->seller?->longitude,
            ],
            'courier' => $courier ? [
                'name' => $courier->user?->name,
                'phone' => $courier->phone,
                'vehicle' => trim($courier->vehicle_type . ' ' . $courier->vehicle_plate),
                'lat' => $courier->current_latitude,
                'lng' => $courier->current_longitude,
                'updated_at' => $courier->last_location_update?->diffForHumans(),
            ] : null,
        ]);
    }
}
