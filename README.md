# Loka — E-Commerce (Laravel 12)

Marketplace multi-role: **Pelanggan, Penjual, Kurir, Admin** dengan pelacakan kurir real-time (Leaflet).

## Setup

```bash
composer install
php artisan migrate:fresh --seed
php artisan serve
```

Login Google (opsional): isi `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, dan `GOOGLE_REDIRECT_URI` di `.env`
(redirect URI di Google Console harus sama persis, contoh `http://localhost:8000/auth/google/callback`).

## Akun demo (password: `password`)

| Role      | Email               | Dashboard            |
|-----------|---------------------|----------------------|
| Admin     | admin@loka.test     | `/admin/dashboard`   |
| Penjual   | seller@loka.test    | `/penjual/dashboard` |
| Kurir     | courier@loka.test   | `/kurir/dashboard`   |
| Pelanggan | customer@loka.test  | `/` (belanja)        |

## Alur sistem

1. **Pelanggan** menambah produk ke keranjang → checkout (wajib login). Harga & stok selalu divalidasi dari database.
   Keranjang berisi produk beberapa toko otomatis dipecah menjadi satu order per toko.
2. **Penjual** mengonfirmasi / membatalkan pesanan. Saat dikonfirmasi, kurir *available* dengan antrean paling sedikit
   (dan terdekat dari toko) ditugaskan otomatis. Pembatalan mengembalikan stok.
3. **Kurir** menekan *Mulai Online*, *Ambil Paket*, lalu *Selesai Diantar*. Browser kurir mengirim lokasi GPS tiap ±8 detik.
4. **Pelanggan** melihat posisi kurir, status, dan ETA di `/lacak/{nomor-pesanan}` (polling tiap 8 detik).
5. **Admin** mengubah role pengguna (profil toko/kurir dibuat otomatis) dan menugaskan ulang kurir.

Status pesanan: `pending → confirmed → shipped → delivered` (atau `cancelled`).
