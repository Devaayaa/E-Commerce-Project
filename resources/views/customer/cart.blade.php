@extends('layouts.app')

@section('title', 'Loka — Shopping Cart')

@section('content')
<main class="max-w-4xl mx-auto px-6 pt-24 pb-32">
    <div class="text-center mb-12 hero-anim">
        <h1 class="text-4xl md:text-5xl font-serif-display text-slate-900 mb-4">Your Cart</h1>
        <p class="text-slate-500">Selected items ready to be processed.</p>
    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 text-center font-semibold border border-green-200">
        {{ session('success') }}
    </div>
    @endif

    @if(count($cart) > 0)
    <div class="bg-white/60 backdrop-blur-xl border border-white/80 rounded-[2rem] p-6 shadow-xl">
        <div class="space-y-6">
            @php $total = 0; @endphp
            @foreach($cart as $id => $details)
            @php $total += $details['price'] * $details['quantity']; @endphp
            <div class="flex items-center justify-between border-b border-slate-200 pb-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-slate-100 rounded-xl flex items-center justify-center text-3xl">
                        {{ $details['emoji'] ?? '📦' }}
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">{{ $details['name'] }}</h3>
                        <p class="text-sm text-slate-500">Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm font-semibold text-slate-600">Qty: {{ $details['quantity'] }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-between items-center">
            <div>
                <p class="text-slate-500">Total Payment</p>
                <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($total, 0, ',', '.') }}</p>
            </div>
            <!-- Updated link to checkout -->
            <a href="{{ route('checkout') }}" class="bg-blue-600 text-white px-8 py-3 rounded-full font-bold hover:bg-blue-700 transition shadow-lg">
                Proceed to Checkout
            </a>
        </div>
    </div>
    @else
    <div class="text-center py-20 bg-white/40 backdrop-blur-md border border-white/60 rounded-[2rem]">
        <span class="text-6xl mb-4 block">🛒</span>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Your Cart is Empty</h3>
        <p class="text-slate-500 mb-6">Let's find your dream products now!</p>
        <a href="{{ route('products') }}" class="bg-slate-900 text-white px-8 py-3 rounded-full font-bold hover:bg-black transition">
            Start Shopping
        </a>
    </div>
    @endif
</main>
@endsection