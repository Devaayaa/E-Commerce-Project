<?php

namespace Database\Seeders;

use App\Models\Courier;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Semua akun demo memakai password: "password"
     */
    public function run(): void
    {
        // --- Admin ---
        User::updateOrCreate(
            ['email' => 'admin@loka.test'],
            ['name' => 'Admin Loka', 'password' => 'password', 'role' => User::ROLE_ADMIN]
        );

        // --- Penjual + toko ---
        $sellerUser = User::updateOrCreate(
            ['email' => 'seller@loka.test'],
            ['name' => 'Penjual Demo', 'password' => 'password', 'role' => User::ROLE_SELLER]
        );
        Seller::updateOrCreate(
            ['user_id' => $sellerUser->id],
            [
                'store_name' => 'Loka Official Store',
                'store_slug' => 'loka-official-store',
                'phone' => '081200000001',
                'address' => 'Jl. Sudirman No. 1, Jakarta Pusat',
                'latitude' => -6.2000000,
                'longitude' => 106.8166000,
                'status' => 'active',
            ]
        );

        // --- Kurir ---
        $courierUser = User::updateOrCreate(
            ['email' => 'courier@loka.test'],
            [
                'name' => 'Budi Santoso', 
                'password' => ('1234'), 
                'role' => User::ROLE_COURIER ?? 'courier' // Antisipasi jika konstanta belum ada
            ]
        );

        Courier::updateOrCreate(
            ['user_id' => $courierUser->id],
            [
                'phone' => '081200000002',
                'vehicle_type' => 'motor',
                'vehicle_plate' => 'B 1234 XYZ',
                
                // 💡 DISESUAIKAN: Set 'offline' agar Anda bisa menguji tombol "MULAI KERJA"
                // Jika diset 'available', kurir langsung online saat login.
                'status' => 'offline', 
                
                // Koordinat awal (Misal: Jakarta Pusat)
                'current_latitude' => -6.2100000,
                'current_longitude' => 106.8300000,
                'last_location_update' => now(),
            ]
        );

        // --- Pelanggan ---
        $customerUser = User::updateOrCreate(
            ['email' => 'customer@loka.test'],
            ['name' => 'Ani Wijaya', 'password' => 'password', 'role' => User::ROLE_CUSTOMER]
        );
        $customerUser->ensureCustomerProfile()->update([
            'phone' => '081200000003',
            'address' => 'Jl. Kebon Jeruk Raya No. 42, Jakarta Barat',
            'latitude' => -6.1900000,
            'longitude' => 106.7700000,
        ]);

        $this->call(ProductSeeder::class);
    }
}
