@extends('layouts.app')

@section('title', 'Checkout — Loka')

@section('content')
@php
    $user      = Auth::user();
    $isBuyNow  = session()->has('buy_now_item');
    $firstKey  = array_key_first($cart);
    $firstItem = $firstKey !== null ? $cart[$firstKey] : null;
    $isSingle  = count($cart) === 1;
    $firstShip = array_key_first($shipping);

    $field = 'w-full bg-white/50 border border-white/70 rounded-2xl px-4 py-3 text-slate-900 placeholder-slate-500 outline-none focus:ring-2 focus:ring-sky-400/50 transition';
    $label = 'block text-xs font-bold tracking-wide uppercase text-slate-600 mb-1.5';

    $initialSubtotal = collect($cart)->sum(fn ($item) => (float) $item['price'] * (int) $item['quantity']);
    $initialShipCost = (float) ($shipping[$firstShip]['cost'] ?? 0);
@endphp

<div class="sky" aria-hidden="true">
    <div class="cloud-pic" style="top:4%;left:-4%;--w:420px;--d:18s"></div>
    <div class="cloud-pic" style="top:22%;right:-3%;--w:520px;--d:22s;--dl:-6s"></div>
    <div class="cloud-pic" style="top:48%;left:-6%;--w:380px;--d:15s;--dl:-3s"></div>
    <div class="cloud-pic" style="top:66%;right:2%;--w:460px;--d:20s;--dl:-9s"></div>
    <div class="cloud-pic" style="top:84%;left:8%;--w:340px;--d:17s;--dl:-2s"></div>
</div>

<main class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 pt-36 pb-24">
    <div class="relative rounded-[3rem]">
        <div class="lg bg-white/10 absolute inset-0 rounded-[3rem] pointer-events-none" aria-hidden="true">
            <div class="pane-glow"><i class="g1"></i><i class="g2"></i><i class="g3"></i></div>
        </div>

        <div class="relative z-10 p-5 sm:p-8 lg:p-10">

            <a href="{{ $isBuyNow && $firstItem ? route('product.show', $firstItem['product_id']) : route('cart.index') }}"
               data-instant
               class="lg lg-soft lg-btn inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm font-semibold text-slate-700 mb-6">
                &larr; {{ $isBuyNow ? 'Back to product' : 'Back to cart' }}
            </a>

            <h1 class="text-4xl md:text-5xl font-serif-display text-slate-900 mb-8">Checkout<span class="italic text-sky-700">.</span></h1>

            @if(session('error'))
            <div class="lg lg-soft rounded-2xl p-4 mb-6 text-sm text-red-700 font-semibold">
                {{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="lg lg-soft rounded-2xl p-4 mb-6 text-sm text-red-700">
                <b>Please review your details:</b>
                <ul class="list-disc ml-5 mt-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST" class="grid lg:grid-cols-3 gap-6 items-start">
                @csrf
                <input type="hidden" id="shipping_latitude" name="shipping_latitude" value="{{ old('shipping_latitude', $customer->latitude ?? '') }}">
                <input type="hidden" id="shipping_longitude" name="shipping_longitude" value="{{ old('shipping_longitude', $customer->longitude ?? '') }}">

                <div class="lg:col-span-2 space-y-6">

                    {{-- 1. RECIPIENT & SHIPPING ADDRESS --}}
                    <section class="lg lg-soft rounded-[2rem] p-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-4">1. Recipient & Shipping Address</h2>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="{{ $label }}" for="name">Recipient Name</label>
                                <input id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required class="{{ $field }}" placeholder="Full name">
                            </div>
                            <div>
                                <label class="{{ $label }}" for="phone">Phone / WhatsApp Number</label>
                                <input id="phone" name="phone" type="tel" inputmode="tel" value="{{ old('phone', $customer->phone ?? '') }}" required
                                       pattern="^(\+62|62|0)8[0-9]{8,12}$" class="{{ $field }}" placeholder="081234567890">
                            </div>
                            <div>
                                <label class="{{ $label }}" for="province">Province</label>
                                <input id="province" name="province" value="{{ old('province', 'Riau') }}" required class="{{ $field }}" placeholder="Riau">
                            </div>
                            <div>
                                <label class="{{ $label }}" for="city">City / Regency</label>
                                <input id="city" name="city" value="{{ old('city', 'Pekanbaru') }}" required class="{{ $field }}" placeholder="Pekanbaru">
                            </div>
                            <div>
                                <label class="{{ $label }}" for="postal_code">Postal Code</label>
                                <input id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required inputmode="numeric" maxlength="5" pattern="[0-9]{5}" class="{{ $field }}" placeholder="28116">
                            </div>
                            <div>
                                <label class="{{ $label }}" for="notes">Courier Notes (Optional)</label>
                                <input id="notes" name="notes" value="{{ old('notes') }}" class="{{ $field }}" placeholder="Green gate, leave with security…">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="{{ $label }}" for="address">Full Delivery Address</label>
                                <textarea id="address" name="address" rows="3" required class="{{ $field }} resize-none" placeholder="Street name, house number, RT/RW, sub-district, district">{{ old('address', $customer->address ?? '') }}</textarea>
                            </div>
                        </div>
                    </section>

                    {{-- 2. SHIPPING METHOD --}}
                    <section class="lg lg-soft rounded-[2rem] p-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-4">2. Shipping Method</h2>
                        <div class="grid sm:grid-cols-3 gap-3">
                            @foreach($shipping as $key => $s)
                            <label class="cursor-pointer">
                                <input type="radio" name="shipping" value="{{ $key }}" data-cost="{{ $s['cost'] }}" class="peer sr-only" {{ old('shipping', $firstShip) === $key ? 'checked' : '' }}>
                                <div class="rounded-2xl p-4 bg-white/40 border border-white/70 peer-checked:ring-2 peer-checked:ring-sky-400 peer-checked:bg-white/80 transition h-full">
                                    <p class="font-bold text-slate-900 text-sm">{{ $s['label'] }}</p>
                                    <p class="text-xs text-slate-600 mb-2">{{ $s['eta'] }}</p>
                                    <p class="font-bold text-sky-700 text-sm">Rp {{ number_format($s['cost'], 0, ',', '.') }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </section>

                    {{-- 3. PAYMENT METHOD --}}
                    <section class="lg lg-soft rounded-[2rem] p-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-4">3. Payment Method</h2>
                        @foreach($payments as $group => $items)
                        <p class="text-xs font-extrabold tracking-widest uppercase text-sky-800 mt-4 mb-2">{{ $group }}</p>
                        <div class="grid sm:grid-cols-2 gap-3">
                            @foreach($items as $key => $name)
                            <label class="cursor-pointer">
                                <input type="radio" name="payment" value="{{ $key }}" class="peer sr-only" required {{ old('payment', 'bca') === $key ? 'checked' : '' }}>
                                <div class="rounded-2xl px-4 py-3 bg-white/40 border border-white/70 peer-checked:ring-2 peer-checked:ring-sky-400 peer-checked:bg-white/80 transition">
                                    <span class="font-semibold text-sm text-slate-900">{{ $name }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @endforeach
                    </section>
                </div>

                {{-- ORDER SUMMARY --}}
                <aside class="lg lg-soft rounded-[2rem] p-6 lg:sticky lg:top-32">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Order Summary</h2>

                    <div class="space-y-3 mb-4 max-h-64 overflow-y-auto pr-1">
                        @foreach($cart as $item)
                        <div class="flex gap-3 items-center">
                            <div class="lg lg-soft w-14 h-14 rounded-2xl grid place-items-center text-3xl shrink-0">{{ $item['emoji'] ?? '📦' }}</div>
                            <div class="min-w-0 flex-1">
                                <p class="font-bold text-sm text-slate-900 line-clamp-2">{{ $item['name'] }}</p>
                                <p class="text-xs text-sky-700 font-semibold">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }} &times; {{ $item['quantity'] }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if($isSingle && $firstItem)
                    <div class="flex items-center justify-between mb-4 border-t border-white/60 pt-4">
                        <span class="text-sm font-semibold text-slate-700">Quantity</span>
                        <div class="lg lg-soft rounded-full flex items-center">
                            <button type="button" id="q-minus" class="w-9 h-9 font-bold text-slate-800" aria-label="Decrease">−</button>
                            <input id="q" type="number" min="1" max="99"
                                   data-price="{{ (float) $firstItem['price'] }}"
                                   data-base-subtotal="0"
                                   data-sync-url="{{ $isBuyNow ? route('checkout.show', $firstItem['product_id']) : '' }}"
                                   value="{{ (int) $firstItem['quantity'] }}"
                                   class="w-10 text-center bg-transparent outline-none font-bold text-slate-900 [appearance:textfield]">
                            <button type="button" id="q-plus" class="w-9 h-9 font-bold text-slate-800" aria-label="Increase">+</button>
                        </div>
                    </div>
                    @else
                    <input id="q" type="hidden" data-price="0" data-base-subtotal="{{ $initialSubtotal }}" value="1">
                    @endif

                    <dl class="text-sm text-slate-700 space-y-2 border-t border-white/60 pt-4">
                        <div class="flex justify-between">
                            <dt>Subtotal ({{ collect($cart)->sum('quantity') }} items)</dt>
                            <dd id="o-sub" class="font-semibold text-slate-900">Rp {{ number_format($initialSubtotal, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Shipping</dt>
                            <dd id="o-ship" class="font-semibold text-slate-900">Rp {{ number_format($initialShipCost, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between text-base border-t border-white/60 pt-3">
                            <dt class="font-bold text-slate-900">Total</dt>
                            <dd id="o-total" class="font-bold text-slate-900">Rp {{ number_format($initialSubtotal + $initialShipCost, 0, ',', '.') }}</dd>
                        </div>
                    </dl>

                    <button type="submit" class="lg lg-gold lg-btn w-full h-12 mt-5 rounded-full text-sm font-bold">Place Order</button>
                    <p class="text-[11px] text-slate-500 text-center mt-3">By placing your order, you agree to Loka's Terms & Conditions.</p>
                </aside>
            </form>
        </div>
    </div>
</main>
@endsection