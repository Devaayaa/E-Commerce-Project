<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Seller;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Produk wajib punya penjual (foreign key seller_id)
        $seller = Seller::first();
        if (! $seller) {
            $this->command?->warn('Belum ada seller. Jalankan DatabaseSeeder terlebih dahulu.');

            return;
        }

        $products = [
            ['name' => 'Headphone Wireless Pro', 'description' => 'Active Noise Cancelling dengan baterai 40 jam.', 'category' => 'electronics', 'emoji' => '🎧', 'price' => 850000, 'original_price' => 1000000, 'discount' => 15, 'stock' => 25, 'sold' => 120],
            ['name' => 'Smartwatch Series X', 'description' => 'Pemantau kesehatan dan notifikasi di pergelangan tangan.', 'category' => 'electronics', 'emoji' => '⌚', 'price' => 1250000, 'stock' => 18, 'sold' => 64],
            ['name' => 'Sneakers Putih Premium', 'description' => 'Sepatu kasual minimalis untuk aktivitas harian.', 'category' => 'fashion', 'emoji' => '👟', 'price' => 350000, 'stock' => 40, 'sold' => 210],
            ['name' => 'Jaket Denim Classic', 'description' => 'Jaket denim tebal, nyaman dipakai segala cuaca.', 'category' => 'fashion', 'emoji' => '🧥', 'price' => 420000, 'original_price' => 500000, 'discount' => 16, 'stock' => 30, 'sold' => 88],
            ['name' => 'Serum Wajah Glow', 'description' => 'Serum vitamin C untuk kulit tampak cerah.', 'category' => 'beauty', 'emoji' => '🧴', 'price' => 175000, 'stock' => 60, 'sold' => 340],
            ['name' => 'Lipstik Matte Rose', 'description' => 'Warna tahan lama dengan hasil matte lembut.', 'category' => 'beauty', 'emoji' => '💄', 'price' => 95000, 'stock' => 80, 'sold' => 190],
            ['name' => 'Lampu Meja Minimalis', 'description' => 'Lampu LED hangat dengan tiga level kecerahan.', 'category' => 'home', 'emoji' => '💡', 'price' => 225000, 'stock' => 35, 'sold' => 77],
            ['name' => 'Set Cangkir Keramik', 'description' => 'Satu set empat cangkir keramik handmade.', 'category' => 'home', 'emoji' => '☕', 'price' => 160000, 'stock' => 50, 'sold' => 142],
            ['name' => 'Gaming Mouse RGB', 'description' => 'Sensor presisi 16.000 DPI dengan 6 tombol programmable.', 'category' => 'gaming', 'emoji' => '🖱️', 'price' => 310000, 'stock' => 45, 'sold' => 155],
            ['name' => 'Controller Wireless', 'description' => 'Controller nirkabel kompatibel PC dan konsol.', 'category' => 'gaming', 'emoji' => '🎮', 'price' => 599000, 'original_price' => 699000, 'discount' => 14, 'stock' => 22, 'sold' => 93],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(
                ['seller_id' => $seller->id, 'name' => $data['name']],
                $data
            );
        }
    }
}
