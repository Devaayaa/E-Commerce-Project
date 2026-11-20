@extends('layouts.app')

@section('title', 'Loka — Shopping Cart')

@section('content')
<main class="max-w-4xl mx-auto px-6 pt-24 pb-32">
    <div class="text-center mb-12 hero-anim">
        <h1 class="text-4xl md:text-5xl font-serif-display text-slate-900 mb-4">Your Cart</h1>
        <p class="text-slate-500">Selected items ready to be processed.</p>
    </div>

    <x-flash />

    @if(count($cart) > 0)
    <div class="bg-white/60 backdrop-blur-xl border border-white/80 rounded-[2rem] p-6 shadow-xl">
        <div class="space-y-6">
            @php $total = 0; @endphp
            @foreach($cart as $id => $details)
            @php $total += $details['price'] * $details['quantity']; @endphp
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 pb-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-slate-100 rounded-xl flex items-center justify-center text-3xl">
                        {{ $details['emoji'] ?? '📦' }}
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">{{ $details['name'] }}</h3>
                        <p class="text-sm text-slate-500">Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <label class="text-sm font-semibold text-slate-600" for="qty-{{ $id }}">Qty</label>
                        <input id="qty-{{ $id }}" type="number" name="quantity" min="1" max="99" value="{{ $details['quantity'] }}"
                            class="w-16 px-2 py-1.5 rounded-lg border border-slate-200 bg-white text-center text-sm focus:outline-none focus:border-blue-500">
                        <button type="submit" class="px-3 py-1.5 bg-slate-900 text-white text-xs font-bold rounded-lg hover:bg-blue-600 transition">Update</button>
                    </form>

                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 text-xs font-bold rounded-lg hover:bg-red-100 transition">Remove</button>
                    </form>
                </div>

                <p class="w-full sm:w-auto text-right font-semibold text-slate-800">
                    Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                </p>
            </div>
            @endforeach
        </div>

        <div class="mt-8 flex flex-wrap justify-between items-center gap-4">
            <div>
                <p class="text-slate-500">Total Payment</p>
                <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($total, 0, ',', '.') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-semibold text-slate-500 hover:text-red-600 transition">Clear cart</button>
                </form>
                <a href="{{ route('checkout') }}" class="bg-blue-600 text-white px-8 py-3 rounded-full font-bold hover:bg-blue-700 transition shadow-lg">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-20 bg-white/40 backdrop-blur-md border border-white/60 rounded-[2rem]">
        <span class="text-6xl mb-4 block">🛒</span>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Your Cart is Empty</h3>
        <p class="text-slate-500 mb-6">Let's find your dream products now!</p>
        <a href="{{ route('shop') }}" class="bg-slate-900 text-white px-8 py-3 rounded-full font-bold hover:bg-black transition">
            Start Shopping
        </a>
    </div>
    @endif
</main>
@endsection
