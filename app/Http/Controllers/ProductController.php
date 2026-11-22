<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);

        $reviews     = collect();
        $reviewCount = 0;
        $reviewAvg   = (float) ($product->rating ?? 5.0);
        $stats       = collect();

        $related = Product::where('category', $product->category)
                          ->where('id', '!=', $product->id)
                          ->take(4)
                          ->get();

        return view('customer.show', compact('product', 'reviews', 'reviewCount', 'reviewAvg', 'stats', 'related'));
    }
}