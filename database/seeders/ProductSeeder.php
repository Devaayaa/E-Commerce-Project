<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // Pastikan model Product sudah ada

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Headphone Wireless Pro',
                'description' => 'Active Noise Cancelling dengan baterai 40 jam.',
                'price' => 850000,
                'emoji' => '🎧',
                // tambahkan field lain sesuai skema tabel Anda
            ],
            [
                'name' => 'Sneakers Putih Premium',
                'description' => 'Sepatu kasual minimalis untuk aktivitas harian.',
                'price' => 350000,
                'emoji' => '👟',
            ],
            // ... tambahkan produk lainnya
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}