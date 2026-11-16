<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function dashboard()
    {
        // Nanti di sini kamu bisa mengambil data order yang ditugaskan ke kurir ini
        // $orders = Order::where('courier_id', auth()->id())->get();
        
        return view('courier.dashboard');
    }
}
