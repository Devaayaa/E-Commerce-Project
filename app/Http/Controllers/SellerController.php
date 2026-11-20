<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SellerController extends Controller
{
    public function dashboard()
    {
        $seller = $this->seller();

        $stats = [
            'revenue' => (float) $seller->orders()->where('status', Order::STATUS_DELIVERED)->sum('total'),
            'new_orders' => $seller->orders()->where('status', Order::STATUS_PENDING)->count(),
            'in_process' => $seller->orders()->whereIn('status', [Order::STATUS_CONFIRMED, Order::STATUS_SHIPPED])->count(),
            'products' => $seller->products()->count(),
        ];

        $products = $seller->products()->latest()->get();
        $orders = $seller->orders()->with(['items', 'courier.user'])->latest()->take(30)->get();

        return view('layouts.seller.dashboard', compact('seller', 'stats', 'products', 'orders'));
    }

    public function storeProduct(Request $request)
    {
        $seller = $this->seller();
        $data = $this->validateProduct($request);

        $seller->products()->create($data);

        return back()->with('success', 'Produk berhasil ditambahkan.');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'required', 'integer', 'min:0'],
        ]);

        $product->update($data);

        return back()->with('success', 'Produk diperbarui.');
    }

    public function destroyProduct(Product $product)
    {
        $this->authorizeProduct($product);
        $product->delete(); // order_items.product_id otomatis NULL, riwayat tetap aman

        return back()->with('success', 'Produk dihapus.');
    }

    /** Konfirmasi / batalkan pesanan masuk. Saat dikonfirmasi, kurir ditugaskan otomatis. */
    public function updateOrder(Request $request, Order $order)
    {
        $seller = $this->seller();
        abort_unless($order->seller_id === $seller->id, 403);

        $action = $request->validate(['action' => ['required', Rule::in(['confirm', 'cancel'])]])['action'];

        if ($action === 'confirm') {
            if ($order->status !== Order::STATUS_PENDING) {
                return back()->with('error', 'Hanya pesanan berstatus menunggu yang bisa dikonfirmasi.');
            }

            $courier = Courier::findBestFor($seller->latitude, $seller->longitude);
            $order->update([
                'status' => Order::STATUS_CONFIRMED,
                'courier_id' => $courier?->id,
            ]);

            return back()->with('success', $courier
                ? "Pesanan {$order->order_number} dikonfirmasi dan ditugaskan ke kurir."
                : "Pesanan {$order->order_number} dikonfirmasi. Belum ada kurir tersedia — admin akan menugaskan kurir.");
        }

        if (! $order->cancelAndRestock()) {
            return back()->with('error', 'Pesanan ini sudah tidak bisa dibatalkan.');
        }

        return back()->with('success', "Pesanan {$order->order_number} dibatalkan dan stok dikembalikan.");
    }

    private function seller(): Seller
    {
        $seller = auth()->user()->seller;
        abort_unless($seller, 403, 'Akun Anda belum memiliki toko. Hubungi admin.');
        abort_if($seller->status === 'suspended', 403, 'Toko Anda sedang ditangguhkan.');

        return $seller;
    }

    private function authorizeProduct(Product $product): void
    {
        abort_unless($product->seller_id === $this->seller()->id, 403);
    }

    private function validateProduct(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'category' => ['required', Rule::in(Product::CATEGORIES)],
            'emoji' => ['nullable', 'string', 'max:16'],
            'price' => ['required', 'numeric', 'min:0'],
            'original_price' => ['nullable', 'numeric', 'min:0'],
            'discount' => ['nullable', 'integer', 'between:0,90'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);
    }
}
