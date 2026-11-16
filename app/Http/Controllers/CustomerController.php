<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function home()
    {
        // Nanti di sini kamu bisa menambahkan logika mengambil data produk dari database
        // $products = Product::latest()->take(4)->get();
        // return view('customer.home', compact('products'));

        return view('customer.home');
    }

    public function tracking($order_id)
    {
        // Nanti kamu bisa mencari data pesanan berdasarkan ID
        // $order = Order::where('order_number', $order_id)->firstOrFail();
        // return view('customer.tracking', compact('order'));

        return view('customer.tracking', compact('order_id'));
    }

      public function products()
    {
        // Memanggil file resources/views/customer/products.blade.php
        return view('customer.products');
    }
}
