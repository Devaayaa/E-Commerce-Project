<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function home()
    {
        // Mengambil 4 produk terbaru untuk di Beranda
        $products = Product::take(4)->get(); 
        return view('customer.home', compact('products'));
    }

    // 1. NAMA METHOD DIUBAH DARI 'products' MENJADI 'shop'
    public function shop(Request $request)
    {
        $query = Product::query();

        // Logika Pencarian (Search)
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Logika Filter Kategori
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category', $request->category); 
        }

        $products = $query->get();

        // 2. NAMA VIEW DIUBAH DARI 'customer.products' MENJADI 'customer.shop'
        return view('customer.shop', compact('products'));
    }

        public function categories(){
        return view('customer.categories');
    }

        public function about(){
        return view('customer.about');
    }

        public function contact(){
        return view('customer.contact');
    }

    public function tracking($order_id = null)
    {
        // Logika pencarian pesanan berdasarkan order_id
        return view('customer.tracking', compact('order_id'));
    }
}