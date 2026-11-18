@extends('layouts.app')

@section('title', 'Loka — Shop Collection')

@section('content')

<!-- ========================================================= -->
<!-- 🌟 [BACKGROUND FIXED] GAMBAR LANGIT (MENYATU DENGAN HOME) -->
<!-- ========================================================= -->
<div class="fixed inset-0 bg-cover bg-center -z-10"
    style="background-image: url('https://images.unsplash.com/photo-1513002749550-c59d786b8e6c?q=80&w=2000&auto=format&fit=crop');"></div>

<!-- Wrapper Utama dengan Panel Kaca -->
<main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 pt-32 pb-24">

    <!-- Panel Kaca Utama -->
    <div class="bg-white/30 backdrop-blur-[30px] border border-white/50 rounded-[3rem] p-6 md:p-12 shadow-[0_8px_32px_rgba(0,0,0,0.1)]">

        <!-- 1. HEADER PAGE & SEARCH -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-5xl md:text-7xl font-serif-display text-slate-900 mb-6 leading-tight drop-shadow-sm">
                Shop<br><span class="italic text-slate-700">Collection.</span>
            </h1>
            <p class="text-lg text-slate-800 leading-relaxed font-medium">
                Discover essential products from various categories. Carefully curated to accompany your every moment.
            </p>
        </div>

        <!-- SEARCH FORM -->
        <div id="search-bar" class="max-w-2xl mx-auto mb-12">
            <form action="{{ route('shop') }}" method="GET" class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-500 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Type product name and press Enter..." class="w-full pl-12 pr-32 py-4 bg-white/40 backdrop-blur-xl border border-white/60 rounded-full shadow-sm text-slate-900 placeholder-slate-500 focus:outline-none focus:bg-white/60 focus:ring-2 focus:ring-blue-500/30 transition-all duration-300">
                <button type="submit" class="absolute inset-y-2 right-2 px-6 bg-slate-900 text-white rounded-full text-sm font-bold hover:bg-blue-600 transition-colors shadow-md">Search</button>
            </form>
        </div>

        @php
        $searchQuery = request('search');
        @endphp

        <!-- 2. SEARCH RESULTS -->
        @if($searchQuery)
        <div class="mb-8 text-center mt-12 bg-white/40 p-6 rounded-2xl border border-white/60 backdrop-blur-md">
            <h2 class="text-2xl font-bold text-slate-900 mb-2">Search Results: "{{ $searchQuery }}"</h2>
            <p class="text-slate-600">Found {{ $products->count() }} products.</p>
            <a href="{{ route('shop') }}" class="text-sm font-semibold text-blue-600 hover:underline mt-4 inline-block">&larr; Back to all categories</a>
        </div>

        @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
            @foreach($products as $p)
            <!-- PRODUCT CARD -->
            <div class="group cursor-pointer bg-white/50 backdrop-blur-xl border border-white/70 rounded-[1.5rem] p-3 flex flex-col relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:bg-white/70 hover:-translate-y-1">
                <!-- Quick Add -->
                <form action="{{ route('cart.add') }}" method="POST" class="absolute top-4 right-4 z-10">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $p->id }}">
                    <input type="hidden" name="name" value="{{ $p->name }}">
                    <input type="hidden" name="price" value="{{ $p->price }}">
                    <input type="hidden" name="emoji" value="{{ $p->emoji ?? '📦' }}">
                    <button type="submit" class="w-8 h-8 bg-white/80 backdrop-blur rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:bg-white transition-colors shadow-sm" title="Add to Cart">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </button>
                </form>

                @if(isset($p->discount) && $p->discount > 0)
                <div class="absolute top-4 left-4 z-10 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-sm">-{{ $p->discount }}%</div>
                @endif
                <div class="relative h-[220px] bg-white/60 rounded-[1.2rem] flex items-center justify-center overflow-hidden mb-4 border border-white/40">
                    <span class="text-7xl transform group-hover:scale-110 transition-transform duration-500 ease-out">{{ $p->emoji ?? '📦' }}</span>
                </div>
                <div class="px-1 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-0.5 {{ $p->badge_color ?? 'bg-blue-100 text-blue-700' }} text-[10px] font-bold rounded">{{ $p->badge ?? 'New' }}</span>
                            <span class="text-[10px] text-slate-600 font-medium">{{ $p->category ?? 'General' }}</span>
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm leading-tight mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $p->name }}</h3>
                        <div class="flex items-center gap-1 text-[11px] text-slate-600 mb-3">
                            <span class="text-amber-500 text-sm">★</span> <span class="font-semibold text-slate-800">{{ $p->rating ?? '5.0' }}</span> <span class="mx-1">•</span> <span>{{ $p->sold ?? '0' }} Sold</span>
                        </div>
                    </div>
                    <div class="mt-auto pt-3 border-t border-white/50">
                        <div class="flex flex-col mb-3">
                            @if(isset($p->original_price) && $p->original_price > 0)
                            <p class="text-xs text-slate-500 line-through">Rp {{ number_format($p->original_price, 0, ',', '.') }}</p>
                            @endif
                            <p class="font-bold text-lg text-slate-900 leading-none">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $p->id }}">
                            <input type="hidden" name="name" value="{{ $p->name }}">
                            <input type="hidden" name="price" value="{{ $p->price }}">
                            <input type="hidden" name="emoji" value="{{ $p->emoji ?? '📦' }}">
                            <button type="submit" class="w-full py-2 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-blue-600 transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Buy
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Not Found State -->
        <div class="text-center py-20 bg-white/50 backdrop-blur-md border border-white/60 rounded-[2rem] max-w-2xl mx-auto mt-8">
            <span class="text-6xl mb-4 block">🔍</span>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Product Not Found</h3>
            <p class="text-slate-600 mb-6">Sorry, we couldn't find any products with the keyword "{{ $searchQuery }}".</p>
            <a href="{{ route('shop') }}" class="inline-block px-6 py-2.5 bg-slate-900 text-white rounded-full text-sm font-bold hover:bg-black transition">View All Products</a>
        </div>
        @endif

        @else
        <!-- 3. CATEGORY VIEW -->
        <div class="flex flex-wrap justify-center gap-3 mb-16 mt-12">
            <a href="{{ route('shop') }}" class="filter-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 bg-slate-900 text-white shadow-lg">All</a>
            <a href="{{ route('shop', ['category' => 'fashion']) }}" class="filter-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 bg-white/50 text-slate-700 hover:bg-white/80 hover:text-slate-900 border border-white/60 backdrop-blur-md">Fashion</a>
            <a href="{{ route('shop', ['category' => 'elektronik']) }}" class="filter-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 bg-white/50 text-slate-700 hover:bg-white/80 hover:text-slate-900 border border-white/60 backdrop-blur-md">Electronics</a>
            <a href="{{ route('shop', ['category' => 'kecantikan']) }}" class="filter-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 bg-white/50 text-slate-700 hover:bg-white/80 hover:text-slate-900 border border-white/60 backdrop-blur-md">Beauty</a>
            <a href="{{ route('shop', ['category' => 'rumah']) }}" class="filter-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 bg-white/50 text-slate-700 hover:bg-white/80 hover:text-slate-900 border border-white/60 backdrop-blur-md">Home</a>
            <a href="{{ route('shop', ['category' => 'gaming']) }}" class="filter-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 bg-white/50 text-slate-700 hover:bg-white/80 hover:text-slate-900 border border-white/60 backdrop-blur-md">Gaming</a>
        </div>

        <div id="product-container" class="space-y-20">
            
            {{-- Looping Semua Produk dari Database --}}
            @if($products->count() > 0)
                <section class="category-section product-section">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($products as $p)
                        <div class="group cursor-pointer bg-white/50 backdrop-blur-xl border border-white/70 rounded-[1.5rem] p-3 flex flex-col relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:bg-white/70 hover:-translate-y-1">
                            
                            <form action="{{ route('cart.add') }}" method="POST" class="absolute top-4 right-4 z-10">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                <input type="hidden" name="name" value="{{ $p->name }}">
                                <input type="hidden" name="price" value="{{ $p->price }}">
                                <input type="hidden" name="emoji" value="{{ $p->emoji ?? '📦' }}">
                                <button type="submit" class="w-8 h-8 bg-white/80 backdrop-blur rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:bg-white transition-colors shadow-sm" title="Add to Cart">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </button>
                            </form>

                            @if(isset($p->discount) && $p->discount > 0)
                            <div class="absolute top-4 left-4 z-10 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-sm">-{{ $p->discount }}%</div>
                            @endif

                            <div class="relative h-[220px] bg-white/60 rounded-[1.2rem] border border-white/40 flex items-center justify-center overflow-hidden mb-4">
                                <span class="text-7xl transform group-hover:scale-110 transition-transform duration-500 ease-out">{{ $p->emoji ?? '📦' }}</span>
                            </div>

                            <div class="px-1 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="px-2 py-0.5 {{ $p->badge_color ?? 'bg-blue-100 text-blue-700' }} text-[10px] font-bold rounded">{{ $p->badge ?? 'New' }}</span>
                                        <span class="text-[10px] text-slate-600 font-medium">{{ $p->category ?? 'General' }}</span>
                                    </div>
                                    <h3 class="font-bold text-slate-900 text-sm leading-tight mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $p->name }}</h3>
                                    <div class="flex items-center gap-1 text-[11px] text-slate-600 mb-3">
                                        <span class="text-amber-500 text-sm">★</span> <span class="font-semibold text-slate-800">{{ $p->rating ?? '5.0' }}</span> <span class="mx-1">•</span> <span>{{ $p->sold ?? '0' }} Sold</span>
                                    </div>
                                </div>
                                <div class="mt-auto pt-3 border-t border-white/50">
                                    <div class="flex flex-col mb-3">
                                        @if(isset($p->original_price) && $p->original_price > 0)
                                        <p class="text-xs text-slate-500 line-through">Rp {{ number_format($p->original_price, 0, ',', '.') }}</p>
                                        @endif
                                        <p class="font-bold text-lg text-slate-900 leading-none">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $p->id }}">
                                        <input type="hidden" name="name" value="{{ $p->name }}">
                                        <input type="hidden" name="price" value="{{ $p->price }}">
                                        <input type="hidden" name="emoji" value="{{ $p->emoji ?? '📦' }}">
                                        <button type="submit" class="w-full py-2 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-blue-600 transition-colors flex items-center justify-center gap-2">Buy</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
            @else
                <div class="text-center py-20">
                    <h2 class="text-2xl font-bold text-slate-600">Belum ada produk yang tersedia.</h2>
                </div>
            @endif
        </div>
        @endif
    </div> <!-- Penutup Panel Kaca -->

</main>
@endsection