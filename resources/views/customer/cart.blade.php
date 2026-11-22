@extends('layouts.app')

@section('title', 'Loka — Shopping Cart')

@section('content')
@php
    $total = collect($cart)->sum(fn ($d) => (float) $d['price'] * (int) $d['quantity']);
    $count = collect($cart)->sum('quantity');
@endphp

<div class="sky" aria-hidden="true">
    <div class="cloud-pic" style="top:4%;left:-4%;--w:420px;--d:18s"></div>
    <div class="cloud-pic" style="top:22%;right:-3%;--w:520px;--d:22s;--dl:-6s"></div>
    <div class="cloud-pic" style="top:48%;left:-6%;--w:380px;--d:15s;--dl:-3s"></div>
    <div class="cloud-pic" style="top:66%;right:2%;--w:460px;--d:20s;--dl:-9s"></div>
    <div class="cloud-pic" style="top:84%;left:8%;--w:340px;--d:17s;--dl:-2s"></div>
</div>

<main class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 pt-36 pb-24">
    <div class="relative rounded-[3rem]">
        <div class="lg bg-white/10 absolute inset-0 rounded-[3rem] pointer-events-none" aria-hidden="true">
            <div class="pane-glow"><i class="g1"></i><i class="g2"></i><i class="g3"></i></div>
        </div>

        <div class="relative z-10 p-5 sm:p-8 lg:p-10">

            <a href="{{ route('shop') }}" data-instant class="lg lg-soft lg-btn inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm font-semibold text-slate-700 mb-6">&larr; Continue shopping</a>

            <div class="flex flex-wrap items-end justify-between gap-3 mb-8">
                <h1 class="text-4xl md:text-5xl font-serif-display text-slate-900">Your <span class="italic text-sky-700">Cart.</span></h1>
                @if(count($cart) > 0)
                <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold text-slate-700"><span class="text-amber-500">✦</span> {{ $count }} {{ $count === 1 ? 'item' : 'items' }}</span>
                @endif
            </div>

            <x-flash />

            @if(count($cart) > 0)
            {{-- ITEMS --}}
            <div class="space-y-4">
                @foreach($cart as $id => $details)
                <div class="lg lg-soft rounded-[1.75rem] p-4 sm:p-5 flex flex-wrap sm:flex-nowrap items-center gap-4">
                    <div class="lg lg-soft relative w-20 h-20 rounded-[1.25rem] grid place-items-center shrink-0 overflow-hidden">
                        <span class="absolute w-14 h-14 rounded-full bg-amber-300/40 blur-xl" aria-hidden="true"></span>
                        <span class="relative text-4xl">{{ $details['emoji'] ?? '📦' }}</span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <h3 class="font-bold text-slate-900 leading-tight line-clamp-2">{{ $details['name'] }}</h3>
                        <p class="text-sm text-sky-700 font-semibold mt-1">Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                    </div>

                    {{-- Quantity: ubah angka lalu otomatis tersimpan --}}
                    <form action="{{ route('cart.update', $id) }}" method="POST" class="cart-qty-form">
                        @csrf
                        @method('PATCH')
                        <div class="lg lg-soft rounded-full flex items-center">
                            <button type="button" data-step="-1" class="w-9 h-9 font-bold text-slate-800" aria-label="Decrease quantity">−</button>
                            <input name="quantity" type="number" min="1" max="99" value="{{ $details['quantity'] }}" aria-label="Quantity"
                                   class="w-10 text-center bg-transparent outline-none font-bold text-slate-900 [appearance:textfield]">
                            <button type="button" data-step="1" class="w-9 h-9 font-bold text-slate-800" aria-label="Increase quantity">+</button>
                        </div>
                        <noscript><button type="submit" class="mt-2 text-xs font-bold text-sky-700 underline">Update</button></noscript>
                    </form>

                    <p class="sm:w-32 text-right font-bold text-slate-900">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</p>

                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Remove" aria-label="Remove {{ $details['name'] }}" class="lg lg-soft lg-btn w-9 h-9 rounded-full grid place-items-center text-slate-500 hover:text-red-600">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>

            {{-- SUMMARY --}}
            <div class="lg lg-soft rounded-[2rem] p-5 sm:p-6 mt-6 flex flex-wrap items-center justify-between gap-5">
                <div>
                    <p class="text-sm text-slate-600">Total payment</p>
                    <p class="text-3xl font-bold text-slate-900">Rp {{ number_format($total, 0, ',', '.') }}</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm font-semibold text-slate-600 hover:text-red-600 transition px-3 py-2">Clear cart</button>
                    </form>
                    <a href="{{ route('checkout') }}" data-instant class="lg lg-gold lg-btn h-12 px-8 rounded-full text-sm font-bold inline-flex items-center gap-2">Proceed to Checkout <span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
            <p class="text-[11px] text-slate-500 text-center mt-4">Shipping and payment method are chosen at checkout.</p>

            @else
            {{-- EMPTY --}}
            <div class="lg lg-soft rounded-[2.5rem] text-center py-16 px-6">
                <div class="lg lg-soft relative w-24 h-24 rounded-full grid place-items-center mx-auto mb-5">
                    <span class="absolute w-16 h-16 rounded-full bg-amber-300/40 blur-xl" aria-hidden="true"></span>
                    <svg class="relative w-10 h-10 text-sky-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Your cart is empty</h3>
                <p class="text-slate-600 mb-6">Let’s find your dream products now!</p>
                <a href="{{ route('shop') }}" data-instant class="lg lg-gold lg-btn inline-flex items-center h-12 px-8 rounded-full text-sm font-bold">Start shopping</a>
            </div>
            @endif

        </div>
    </div>
</main>
@endsection