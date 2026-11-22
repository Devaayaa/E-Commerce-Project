<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function index()
    {
        return view('customer.about', [
            // Kata pada pita berjalan
            'words' => ['Curated', 'Verified sellers', 'Full transparency', 'Secure checkout', 'Real-time tracking', 'Authentic'],

            // Kartu statistik
            'stats' => [
                ['icon' => '🛡️', 'value' => 'Verified', 'label' => 'Sellers only'],
                ['icon' => '✨',  'value' => '100%',     'label' => 'Authentic items'],
                ['icon' => '🔒', 'value' => 'Secure',   'label' => 'Checkout'],
                ['icon' => '📍', 'value' => 'Live',     'label' => 'Order tracking'],
            ],

            // Timeline "How Loka works"
            'steps' => [
                ['title' => 'Sellers apply', 'text' => 'Independent sellers submit their products and story to us.'],
                ['title' => 'We verify',     'text' => 'Each seller and item is checked for authenticity and quality.'],
                ['title' => 'You shop',      'text' => 'Browse curated collections and check out securely.'],
                ['title' => 'We deliver',    'text' => 'Track your order in real time until it reaches your door.'],
            ],
        ]);
    }
}