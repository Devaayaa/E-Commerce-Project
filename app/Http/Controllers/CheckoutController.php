<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = $this->activeCart();

        if (count($cart) === 0) {
            return redirect()->route('shop')->with('error', 'Keranjang Anda kosong!');
        }

        $customer = auth()->user()->ensureCustomerProfile();

        return view('customer.checkout', compact('cart', 'customer'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:bank_transfer,e_wallet,credit_card,cod'],
            'shipping_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'shipping_longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $cart = $this->activeCart();
        if (count($cart) === 0) {
            return redirect()->route('shop')->with('error', 'Keranjang Anda kosong!');
        }

        $isBuyNow = session()->has('buy_now_item');
        $customer = auth()->user()->ensureCustomerProfile();

        try {
            $orders = DB::transaction(function () use ($cart, $data, $customer) {
                // Kunci baris produk agar stok tidak bisa dibeli ganda secara bersamaan.
                $products = Product::whereIn('id', array_keys($cart))->lockForUpdate()->get()->keyBy('id');

                // Validasi stok + kelompokkan per penjual (1 penjual = 1 order).
                $bySeller = [];
                foreach ($cart as $productId => $line) {
                    $product = $products->get($productId);
                    $qty = (int) $line['quantity'];

                    if (! $product) {
                        throw new \RuntimeException("Produk \"{$line['name']}\" sudah tidak tersedia.");
                    }
                    if ($product->stock < $qty) {
                        throw new \RuntimeException("Stok \"{$product->name}\" tidak mencukupi (tersisa {$product->stock}).");
                    }

                    $bySeller[$product->seller_id][] = [$product, $qty];
                }

                $customer->update([
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'latitude' => $data['shipping_latitude'] ?? $customer->latitude,
                    'longitude' => $data['shipping_longitude'] ?? $customer->longitude,
                ]);

                $created = [];
                foreach ($bySeller as $sellerId => $lines) {
                    $total = 0;
                    foreach ($lines as [$product, $qty]) {
                        $total += $product->price * $qty;
                    }

                    $order = Order::create([
                        'order_number' => Order::generateNumber(),
                        'customer_id' => $customer->id,
                        'seller_id' => $sellerId,
                        'total' => $total,
                        'payment_method' => $data['payment_method'],
                        'recipient_name' => $data['name'],
                        'recipient_phone' => $data['phone'],
                        'shipping_address' => $data['address'],
                        'shipping_latitude' => $data['shipping_latitude'] ?? null,
                        'shipping_longitude' => $data['shipping_longitude'] ?? null,
                        'status' => Order::STATUS_PENDING,
                    ]);

                    foreach ($lines as [$product, $qty]) {
                        $order->items()->create([
                            'product_id' => $product->id,
                            'product_name' => $product->name,
                            'emoji' => $product->emoji,
                            'price' => $product->price, // harga dikunci saat checkout
                            'quantity' => $qty,
                        ]);
                        $product->decrement('stock', $qty);
                    }

                    $created[] = $order;
                }

                return $created;
            });
        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        // Bersihkan hanya sumber yang dipakai checkout ini.
        $isBuyNow ? session()->forget('buy_now_item') : session()->forget('cart');

        $message = 'Pesanan berhasil dibuat! Menunggu konfirmasi penjual.';

        return count($orders) === 1
            ? redirect()->route('tracking', $orders[0]->order_number)->with('success', $message)
            : redirect()->route('tracking')->with('success', $message . ' Pesanan Anda dipisah per toko.');
    }

    /** Sumber item checkout: "Beli Sekarang" lebih diutamakan, jika tidak ada pakai isi keranjang. */
    private function activeCart(): array
    {
        return session()->has('buy_now_item')
            ? session()->get('buy_now_item')
            : session()->get('cart', []);
    }
}
