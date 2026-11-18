<?php

namespace App\Http\Controllers;

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
        $id = $request->product_id;
        
        $itemData = [
            "name" => $request->name,
            "quantity" => 1,
            "price" => (int) $request->price,
            "emoji" => $request->emoji 
        ];

        // JIKA KLIK TOMBOL "BUY NOW" (Beli)
        if ($request->has('buy_now')) {
            // Simpan HANYA barang ini ke session khusus
            session()->put('buy_now_item', [$id => $itemData]);
            return redirect()->route('checkout');
        }

        // JIKA KLIK TOMBOL "QUICK CART" (Ikon Keranjang)
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = $itemData;
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }
}