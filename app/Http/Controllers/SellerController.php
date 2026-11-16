<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function dashboard()
    {
        // Logika untuk penjual
        return view('seller.dashboard');
    }
}
