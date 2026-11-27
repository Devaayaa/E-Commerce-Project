<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    public const SHIPPING = [
        'reguler' => ['label' => 'Regular Shipping',  'eta' => '3–5 business days', 'cost' => 15000],
        'express' => ['label' => 'Express Shipping',  'eta' => '1–2 business days', 'cost' => 30000],
        'instan'  => ['label' => 'Instant Loka',      'eta' => 'Same day (Loka Courier)', 'cost' => 45000],
    ];

    public const PAYMENTS = [
        'Bank Transfer' => [
            'bca'     => 'BCA Virtual Account',
            'mandiri' => 'Mandiri Virtual Account',
            'bni'     => 'BNI Virtual Account',
        ],
        'E-Wallet' => [
            'gopay'     => 'GoPay',
            'ovo'       => 'OVO',
            'dana'      => 'DANA',
            'shopeepay' => 'ShopeePay',
        ],
        'Other Methods' => [
            'qris' => 'QRIS',
            'cod'  => 'Cash on Delivery (COD)',
        ],
    ];

    public function index()
    {
        session()->forget('buy_now_item');

        $cart = $this->activeCart();

        if (count($cart) === 0) {
            return redirect()->route('shop')->with('error', 'Your cart is empty!');
        }

        /** @var User $user */
        $user     = Auth::user();
        $customer = $user->ensureCustomerProfile();
        $shipping = self::SHIPPING;
        $payments = self::PAYMENTS;

        return view('customer.checkout', compact('cart', 'customer', 'shipping', 'payments'));
    }

    public function show(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $qty     = max(1, min(99, (int) $request->query('qty', 1)));

        if ($product->stock < $qty) {
            return redirect()->route('product.show', $product->id)
                ->with('error', "Insufficient stock for \"{$product->name}\" ({$product->stock} left).");
        }

        session()->put('buy_now_item', [
            $product->id => [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => $product->price,
                'quantity'   => $qty,
                'emoji'      => $product->emoji ?? '📦',
            ]
        ]);

        $cart = $this->activeCart();

        /** @var User $user */
        $user     = Auth::user();
        $customer = $user->ensureCustomerProfile();
        $shipping = self::SHIPPING;
        $payments = self::PAYMENTS;

        return view('customer.checkout', compact('cart', 'customer', 'shipping', 'payments'));
    }

    public function store(Request $request)
    {
        $allPay = collect(self::PAYMENTS)->flatMap(fn ($g) => array_keys($g))->all();

        $data = $request->validate([
            'name'               => ['required', 'string', 'max:255'],
            'phone'              => ['required', 'regex:/^(\+62|62|0)8[0-9]{8,12}$/'],
            'province'           => ['required', 'string', 'max:80'],
            'city'               => ['required', 'string', 'max:80'],
            'postal_code'        => ['required', 'digits:5'],
            'address'            => ['required', 'string', 'max:1000'],
            'notes'              => ['nullable', 'string', 'max:250'],
            'shipping'           => ['required', Rule::in(array_keys(self::SHIPPING))],
            'payment'            => ['required', Rule::in($allPay)],
            'shipping_latitude'  => ['nullable', 'numeric', 'between:-90,90'],
            'shipping_longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ], [
            'phone.regex' => 'Invalid phone number format (e.g., 081234567890).',
        ]);

        $cart = $this->activeCart();
        if (count($cart) === 0) {
            return redirect()->route('shop')->with('error', 'Your cart is empty!');
        }

        $isBuyNow = session()->has('buy_now_item');

        /** @var User $user */
        $user     = Auth::user();
        $customer = $user->ensureCustomerProfile();

        // Gabungkan alamat lengkap + kota + provinsi + kode pos + catatan kurir
        $fullAddress = trim($data['address']) . ", {$data['city']}, {$data['province']} {$data['postal_code']}"
            . (! empty($data['notes']) ? " (Notes: {$data['notes']})" : '');

        $shippingCost = self::SHIPPING[$data['shipping']]['cost'];

        try {
            $orders = DB::transaction(function () use ($cart, $data, $customer, $fullAddress, $shippingCost) {
                $products = Product::whereIn('id', array_keys($cart))->lockForUpdate()->get()->keyBy('id');

                $bySeller = [];
                foreach ($cart as $productId => $line) {
                    $product = $products->get($productId);
                    $qty     = (int) $line['quantity'];

                    if (! $product) {
                        throw new \RuntimeException("Product \"{$line['name']}\" is no longer available.");
                    }
                    if ($product->stock < $qty) {
                        throw new \RuntimeException("Insufficient stock for \"{$product->name}\" ({$product->stock} left).");
                    }

                    $bySeller[$product->seller_id][] = [$product, $qty];
                }

                $customer->update([
                    'phone'     => $data['phone'],
                    'address'   => $fullAddress,
                    'latitude'  => $data['shipping_latitude'] ?? $customer->latitude,
                    'longitude' => $data['shipping_longitude'] ?? $customer->longitude,
                ]);

                $created  = [];
                $isFirst  = true;

                foreach ($bySeller as $sellerId => $lines) {
                    $total = 0;
                    foreach ($lines as [$product, $qty]) {
                        $total += $product->price * $qty;
                    }

                    if ($isFirst) {
                        $total  += $shippingCost;
                        $isFirst = false;
                    }

                    $order = Order::create([
                        'order_number'       => Order::generateNumber(),
                        'customer_id'        => $customer->id,
                        'seller_id'          => $sellerId,
                        'total'              => $total,
                        'payment_method'     => $data['payment'],
                        'recipient_name'     => $data['name'],
                        'recipient_phone'    => $data['phone'],
                        'shipping_address'   => $fullAddress,
                        'shipping_latitude'  => $data['shipping_latitude'] ?? null,
                        'shipping_longitude' => $data['shipping_longitude'] ?? null,
                        'status'             => Order::STATUS_PENDING,
                    ]);

                    foreach ($lines as [$product, $qty]) {
                        $order->items()->create([
                            'product_id'   => $product->id,
                            'product_name' => $product->name,
                            'emoji'        => $product->emoji,
                            'price'        => $product->price,
                            'quantity'     => $qty,
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

        $isBuyNow ? session()->forget('buy_now_item') : session()->forget('cart');

        $message = 'Order placed successfully! Waiting for seller confirmation.';

        return count($orders) === 1
            ? redirect()->route('tracking', $orders[0]->order_number)->with('success', $message)
            : redirect()->route('tracking')->with('success', $message . ' Your order has been split by store.');
    }

    private function activeCart(): array
    {
        return session()->has('buy_now_item')
            ? session()->get('buy_now_item')
            : session()->get('cart', []);
    }
}