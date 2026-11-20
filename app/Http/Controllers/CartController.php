<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Hapus session 'buy_now_item' jika user membuka halaman keranjang biasa
        session()->forget('buy_now_item');

        $cart = session()->get('cart', []);

        return view('customer.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        // Data nama/harga selalu diambil dari database, bukan dari input form (anti manipulasi harga).
        $product = Product::findOrFail($data['product_id']);
        $qty = (int) ($data['quantity'] ?? 1);

        if ($product->stock < 1) {
            return back()->with('error', "Stok {$product->name} sedang habis.");
        }

        $id = $product->id;
        $itemData = [
            'name' => $product->name,
            'quantity' => min($qty, $product->stock),
            'price' => $product->price,
            'emoji' => $product->emoji ?? '📦',
        ];

        // JIKA KLIK TOMBOL "BUY NOW" (Beli)
        if ($request->has('buy_now')) {
            // Simpan HANYA barang ini ke session khusus
            session()->put('buy_now_item', [$id => $itemData]);

            return redirect()->route('checkout');
        }

        // JIKA KLIK TOMBOL "QUICK CART" (Ikon Keranjang)
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = min($cart[$id]['quantity'] + $qty, $product->stock);
            $cart[$id]['price'] = $product->price; // sinkronkan bila harga berubah
        } else {
            $cart[$id] = $itemData;
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = session()->get('cart', []);
        if (! isset($cart[$id])) {
            return back()->with('error', 'Produk tidak ada di keranjang.');
        }

        $product = Product::find($id);
        if (! $product) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            return back()->with('error', 'Produk sudah tidak tersedia dan dihapus dari keranjang.');
        }

        $qty = min((int) $data['quantity'], $product->stock);
        if ($qty < 1) {
            return back()->with('error', "Stok {$product->name} sedang habis.");
        }

        $cart[$id]['quantity'] = $qty;
        session()->put('cart', $cart);

        $message = $qty < (int) $data['quantity']
            ? "Jumlah disesuaikan dengan stok tersedia ({$product->stock})."
            : 'Keranjang diperbarui.';

        return back()->with('success', $message);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
