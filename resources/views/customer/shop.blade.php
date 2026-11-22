@extends('layouts.app')

@section('title', 'Loka — Shop Collection')

@section('content')
@php
$searchQuery = request('search');
$activeCat = request('category') ?? '';
// slug => label (samakan slug dengan yang dipakai di database/controller)
$cats = ['' => 'All', 'fashion' => 'Fashion', 'electronics' => 'Electronics', 'beauty' => 'Beauty', 'home' => 'Home', 'gaming' => 'Gaming'];
@endphp

<!-- ☁️ BACKGROUND — sama persis dengan Home -->
<div class="sky" aria-hidden="true">
    <div class="cloud-pic" style="top:4%;left:-4%;--w:420px;--d:18s"></div>
    <div class="cloud-pic" style="top:22%;right:-3%;--w:520px;--d:22s;--dl:-6s"></div>
    <div class="cloud-pic" style="top:48%;left:-6%;--w:380px;--d:15s;--dl:-3s"></div>
    <div class="cloud-pic" style="top:66%;right:2%;--w:460px;--d:20s;--dl:-9s"></div>
    <div class="cloud-pic" style="top:84%;left:8%;--w:340px;--d:17s;--dl:-2s"></div>
</div>

<main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 pt-36 pb-24">

    <div class="relative rounded-[3rem]">
        <div class="lg bg-white/10 absolute inset-0 rounded-[3rem] pointer-events-none" aria-hidden="true">
            <div class="pane-glow"><i class="g1"></i><i class="g2"></i><i class="g3"></i></div>
        </div>
        <div class="relative z-10 p-5 sm:p-8 lg:p-12">

            <!-- 1. TITLE -->
            <div class="relative text-center max-w-3xl mx-auto mb-10">
                <span class="sparkle hidden sm:block" style="top:30%;left:12%;font-size:28px" aria-hidden="true">✦</span>
                <span class="sparkle hidden sm:block" style="top:14%;right:14%;font-size:18px" aria-hidden="true">✦</span>
                <span class="sparkle hidden sm:block" style="top:58%;right:20%;font-size:12px" aria-hidden="true">✦</span>
                <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-2 rounded-full text-[10px] font-extrabold tracking-[0.2em] uppercase text-sky-800 mb-6">
                    <span class="text-amber-500 text-xs">✦</span> Shop
                </span>
                <h1 class="text-5xl md:text-7xl font-serif-display text-slate-900 mb-6 leading-[1.15]">
                    Shop<br><span class="italic text-sky-700">Collection.</span>
                </h1>
                <p class="text-lg text-slate-700 leading-relaxed font-medium">
                    Discover essential products from various categories. Carefully curated to accompany your every moment.
                </p>
                <div class="flex flex-wrap justify-center gap-2 mt-7">
                    <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold text-slate-700"><span class="text-amber-500">✦</span> Verified sellers</span>
                    <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold text-slate-700"><span class="text-amber-500">★</span> Curated picks</span>
                    <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold text-slate-700"><span class="text-amber-500">✓</span> Secure checkout</span>
                </div>
            </div>

            <!-- 2. SEARCH -->
            <form id="search-bar" action="{{ route('shop') }}" method="GET" data-shop-search class="max-w-2xl mx-auto mb-8">
                <label class="lg lg-soft flex items-center gap-3 rounded-full pl-5 pr-2 py-2 focus-within:ring-2 focus-within:ring-sky-400/50 transition">
                    <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Type product name and press Enter..." class="flex-1 min-w-0 bg-transparent outline-none text-slate-900 placeholder-slate-500 py-2">
                    <button type="submit" class="lg lg-blue lg-btn px-6 py-2.5 rounded-full text-sm font-bold">Search</button>
                </label>
            </form>

            <div id="shop-dynamic">
            @if($searchQuery)
            <!-- 3a. SEARCH BANNER -->
            <div class="lg lg-soft rounded-[2rem] text-center p-6 max-w-2xl mx-auto mb-10">
                <h2 class="text-2xl font-bold text-slate-900 mb-1">Search Results: “{{ $searchQuery }}”</h2>
                <p class="text-slate-600">Found {{ $products->count() }} products.</p>
                <a href="{{ route('shop') }}" data-shop-nav class="text-sm font-semibold text-sky-700 hover:underline mt-3 inline-block">&larr; Back to all categories</a>
            </div>
            @else
            <!-- 3b. CATEGORY CHIPS -->
            <nav class="flex flex-wrap justify-center gap-3 mb-12" aria-label="Categories">
                @foreach($cats as $slug => $label)
                @php $on = (string) $activeCat === (string) $slug; @endphp
                <a href="{{ $slug === '' ? route('shop') : route('shop', ['category' => $slug]) }}"
                    data-shop-nav class="lg {{ $on ? 'lg-blue' : 'lg-soft text-slate-700' }} lg-btn px-6 py-2.5 rounded-full text-sm font-semibold">{{ $label }}</a>
                @endforeach
            </nav>
            @endif

            <!-- 4. PRODUCTS -->
            @if($products->count() > 0)
            <div class="flex items-center gap-3 mb-5 px-1"><span class="h-4 w-1 rounded-full bg-gradient-to-b from-amber-300 to-amber-500"></span>
                <p class="text-sm font-semibold text-slate-700">{{ $products->count() }} products</p>
            </div>
            <div class="product-grid-container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $p)
                <article class="stagger-item group lg lg-spot rounded-[2rem] p-3 flex flex-col">
                    {{-- form untuk tombol Add to cart --}}
                    <form id="add-{{ $p->id }}" action="{{ route('cart.add') }}" method="POST" class="hidden">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $p->id }}">
                        <input type="hidden" name="name" value="{{ $p->name }}">
                        <input type="hidden" name="price" value="{{ $p->price }}">
                        <input type="hidden" name="emoji" value="{{ $p->emoji ?? '📦' }}">
                    </form>

                    <div class="lg lg-soft relative h-[200px] rounded-[1.5rem] flex items-center justify-center overflow-hidden mb-4">
                        @if(isset($p->discount) && $p->discount > 0)
                        <span class="absolute top-3 left-3 z-10 bg-gradient-to-r from-amber-400 to-orange-400 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-[0_4px_12px_rgba(251,146,60,.45)]">-{{ $p->discount }}%</span>
                        @endif
                        <span class="absolute w-28 h-28 rounded-full bg-amber-300/40 blur-2xl transition-colors duration-500 group-hover:bg-amber-300/70" aria-hidden="true"></span>
                        {{-- klik gambar → halaman detail produk (instan) --}}
                        <a href="{{ route('product.show', $p->id) }}" data-instant class="float-y relative">
                            <span data-fly-src class="block text-7xl transition-transform duration-500 group-hover:scale-110">{{ $p->emoji ?? '📦' }}</span>
                        </a>
                    </div>

                    <div class="px-1 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-0.5 {{ $p->badge_color ?? 'bg-blue-100 text-blue-700' }} text-[10px] font-bold rounded-full">{{ $p->badge ?? 'New' }}</span>
                            <span class="text-[10px] text-slate-600 font-medium">{{ $p->category ?? 'General' }}</span>
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm leading-tight mb-2 line-clamp-2">
                            {{-- klik nama → halaman detail produk (instan) --}}
                            <a href="{{ route('product.show', $p->id) }}" data-instant class="hover:text-sky-700 transition-colors">{{ $p->name }}</a>
                        </h3>
                        <div class="flex items-center gap-1 text-[11px] text-slate-600 mb-3">
                            <span class="text-amber-500 text-sm">★</span><span class="font-semibold text-slate-800">{{ $p->rating ?? '5.0' }}</span><span class="mx-1">•</span><span>{{ $p->sold ?? '0' }} Sold</span>
                        </div>
                        <div class="mt-auto pt-3 border-t border-white/60">
                            @if(isset($p->original_price) && $p->original_price > 0)
                            <p class="text-xs text-slate-500 line-through">Rp {{ number_format($p->original_price, 0, ',', '.') }}</p>
                            @endif
                            <p class="font-bold text-lg text-slate-900 leading-none mb-3">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                            <div class="flex items-center gap-2">
                                {{-- Buy Now → loading di tombol, lalu halaman checkout (instan) --}}
                                <a href="{{ route('checkout.show', $p->id) }}" data-instant data-loading class="lg lg-gold lg-btn flex-1 h-11 rounded-full text-[13px] font-bold inline-flex items-center justify-center gap-2">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                                    </svg>
                                    <span>Buy Now</span>
                                </a>
                                <button type="submit" form="add-{{ $p->id }}" data-fly aria-label="Add {{ $p->name }} to cart" title="Add to cart" class="lg lg-soft lg-btn shrink-0 w-11 h-11 rounded-full inline-flex items-center justify-center text-sky-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                        <path stroke-linecap="round" d="M13.2 7.6v4.2M11.1 9.7h4.2" stroke-width="1.6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
            @else
            <!-- EMPTY STATE -->
            <div class="lg lg-spot rounded-[2.5rem] text-center py-20 px-6 max-w-2xl mx-auto">
                <span class="text-6xl mb-4 block">{{ $searchQuery ? '🔍' : '📦' }}</span>
                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $searchQuery ? 'Product Not Found' : 'No products available yet.' }}</h3>
                @if($searchQuery)
                <p class="text-slate-600 mb-6">Sorry, we couldn’t find any products with the keyword “{{ $searchQuery }}”.</p>
                <a href="{{ route('shop') }}" data-shop-nav class="lg lg-blue lg-btn inline-flex px-6 py-2.5 rounded-full text-sm font-bold">View All Products</a>
                @endif
            </div>
            @endif
            </div><!-- /#shop-dynamic -->

        </div>
    </div>

</main>

@endsection