<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        // Cek apakah user masuk ke sini lewat tombol "Beli" atau lewat halaman "Keranjang"
        if (session()->has('buy_now_item')) {
            // Jika dari tombol Beli, ambil barang itu saja
            $cart = session()->get('buy_now_item');
        } else {
            // Jika dari halaman keranjang, ambil seluruh isi keranjang
            $cart = session()->get('cart', []);
        }
        
        if(count($cart) == 0) {
            return redirect()->route('products')->with('error', 'Keranjang Anda kosong!');
        }

        return view('customer.checkout', compact('cart'));
    }
}