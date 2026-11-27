@extends('layouts.app')

@section('title', $product->name . ' — Loka')

@section('content')
@php
$price = (float) $product->price;
$orig = (float) ($product->original_price ?? 0);
$disc = (int) ($product->discount ?? 0);
$avg = $reviewAvg ?? (float) ($product->rating ?? 5);
$reviewCount = $reviewCount ?? 0;
$reviews = $reviews ?? collect();
$related = $related ?? collect();
$storeName = $product->seller->shop_name ?? $product->store_name ?? 'Loka Official Store';
$storeCity = $product->store_city ?? 'Indonesia';
$emoji = $product->emoji ?? '📦';
$maxStock = max(1, (int) ($product->stock ?? 99));
$stars = fn ($n) => str_repeat('★', (int) round($n)) . str_repeat('☆', 5 - (int) round($n));
@endphp


</style>
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

            <a href="{{ route('shop') }}" data-instant class="lg lg-soft lg-btn inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm font-semibold text-slate-700 mb-8">&larr; Back to Shop</a>

            {{-- ============ PRODUCT DETAILS ============ --}}
            <article class="grid lg:grid-cols-2 gap-8 lg:gap-12">

                {{-- Product Visual --}}
                <div class="lg lg-soft relative rounded-[2rem] min-h-[360px] lg:min-h-[480px] flex items-center justify-center overflow-hidden">
                    @if($disc > 0)
                    <span class="absolute top-5 left-5 z-10 bg-gradient-to-r from-amber-400 to-orange-400 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-[0_4px_12px_rgba(251,146,60,.45)]">-{{ $disc }}%</span>
                    @endif
                    <span class="absolute w-64 h-64 rounded-full bg-amber-300/50 blur-3xl" aria-hidden="true"></span>
                    @if($product->image)
                    <img data-fly-src src="{{ \Illuminate\Support\Str::startsWith($product->image, ['http', '/']) ? $product->image : asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="relative block w-full h-full max-h-[480px] object-cover">
                    @else
                    <span data-fly-src class="float-y relative block text-[9rem] leading-none">{{ $emoji }}</span>
                    @endif
                </div>

                {{-- Product Info --}}
                <div class="flex flex-col">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-3 py-1 {{ $product->badge_color ?? 'bg-blue-100 text-blue-700' }} text-[11px] font-bold rounded-full">{{ $product->badge ?? 'New' }}</span>
                        <span class="text-xs text-slate-600 font-medium">{{ $product->category ?? 'General' }}</span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-serif-display text-slate-900 leading-tight mb-4">{{ $product->name }}</h1>

                    {{-- Rating & Sold --}}
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-slate-700 mb-5">
                        <span class="flex items-center gap-1.5"><span class="text-amber-500 text-base">★</span><b class="text-slate-900">{{ number_format($avg, 1) }}</b></span>
                        <span class="text-slate-400">|</span>
                        <span><b class="text-slate-900">{{ $reviewCount }}</b> Reviews</span>
                        <span class="text-slate-400">|</span>
                        <span><b class="text-slate-900">{{ number_format($product->sold ?? 0, 0, ',', '.') }}</b> Sold</span>
                    </div>

                    {{-- Price --}}
                    <div class="lg lg-soft rounded-[1.5rem] px-5 py-4 mb-5">
                        @if($orig > 0)
                        <p class="text-sm text-slate-500 line-through">Rp {{ number_format($orig, 0, ',', '.') }}</p>
                        @endif
                        <p class="text-3xl font-bold text-slate-900">Rp {{ number_format($price, 0, ',', '.') }}</p>
                    </div>

                    {{-- Store Info --}}
                    <div class="lg lg-soft rounded-[1.5rem] p-4 flex items-center gap-4 mb-5">
                        <div class="lg lg-blue w-12 h-12 rounded-full grid place-items-center font-bold text-lg shrink-0">{{ strtoupper(mb_substr($storeName, 0, 1)) }}</div>
                        <div class="min-w-0 flex-1">
                            <p class="font-bold text-slate-900 truncate">{{ $storeName }} <span class="text-sky-600 text-xs font-semibold">✓ Verified</span></p>
                            <p class="text-xs text-slate-600">📍 {{ $storeCity }}</p>
                        </div>
                        <div class="text-right text-xs text-slate-600">
                            <p class="font-bold text-slate-900">{{ number_format($avg, 1) }} ★</p>
                            <p>Store rating</p>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="mb-6">
                        <h2 class="text-sm font-extrabold tracking-widest uppercase text-sky-800 mb-2">Description</h2>
                        <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $product->description ?: 'No description available for this product yet.' }}</p>
                    </div>

                    {{-- Quantity & Actions --}}
                    <div class="mt-auto">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="text-sm font-semibold text-slate-700">Quantity</span>
                            <div class="lg lg-soft rounded-full flex items-center">
                                <button type="button" id="qty-minus" class="w-10 h-10 text-lg font-bold text-slate-800" aria-label="Decrease">−</button>
                                <input id="qty" type="number" min="1" max="{{ $maxStock }}" value="1" class="w-12 text-center bg-transparent outline-none font-bold text-slate-900 [appearance:textfield]">
                                <button type="button" id="qty-plus" class="w-10 h-10 text-lg font-bold text-slate-800" aria-label="Increase">+</button>
                            </div>
                            <span class="text-xs text-slate-500">Stock: {{ $product->stock ?? 0 }}</span>
                        </div>

                        <form id="add-{{ $product->id }}" action="{{ route('cart.add') }}" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="emoji" value="{{ $emoji }}">
                            <input type="hidden" name="qty" id="cart-qty" value="1">
                        </form>

                        <div class="flex items-center gap-3">
                            <a id="buy-link" href="{{ route('checkout.show', $product->id) }}" data-instant data-loading
                                class="lg lg-blue lg-btn flex-1 h-12 rounded-full text-sm font-bold inline-flex items-center justify-center gap-2">Buy Now</a>
                            <button type="submit" form="add-{{ $product->id }}" data-fly
                                class="lg lg-soft lg-btn h-12 px-6 rounded-full text-sm font-bold text-sky-700 inline-flex items-center gap-2">+ Add to Cart</button>
                        </div>
                    </div>
                </div>
            </article>

            {{-- ============ REVIEWS ============ --}}
            <section class="mt-14" aria-labelledby="rv-title">
                <div class="flex items-center gap-3 mb-6">
                    <span class="h-5 w-1 rounded-full bg-gradient-to-b from-amber-300 to-amber-500"></span>
                    <h2 id="rv-title" class="text-2xl font-bold text-slate-900">Ratings & Reviews</h2>
                </div>

                <div class="grid lg:grid-cols-3 gap-6">
                    <div class="lg lg-soft rounded-[2rem] p-6 text-center lg:text-left">
                        <p class="text-6xl font-serif-display text-slate-900 leading-none">{{ number_format($avg, 1) }}</p>
                        <p class="text-amber-500 text-xl mt-2">{{ $stars($avg) }}</p>
                        <p class="text-sm text-slate-600 mt-1 mb-5">from {{ $reviewCount }} reviews</p>
                        @for($s = 5; $s >= 1; $s--)
                        @php $c = (int) ($stats[$s] ?? 0); $pct = $reviewCount ? round($c / $reviewCount * 100) : 0; @endphp
                        <div class="flex items-center gap-2 text-xs text-slate-700 mb-1.5">
                            <span class="w-6">{{ $s }} ★</span>
                            <div class="flex-1 h-2 rounded-full bg-white/60 overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-amber-300 to-amber-500" @style(["width: {$pct}%"])></div>
                            </div>
                            <span class="w-8 text-right">{{ $c }}</span>
                        </div>
                        @endfor
                    </div>

                    <div class="lg:col-span-2 space-y-4">
                        @forelse($reviews as $r)
                        <div class="lg lg-soft rounded-[1.5rem] p-5">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="lg lg-blue w-9 h-9 rounded-full grid place-items-center text-sm font-bold">{{ strtoupper(mb_substr($r->user_name, 0, 1)) }}</div>
                                <div class="flex-1">
                                    <p class="font-bold text-sm text-slate-900">{{ $r->user_name }}</p>
                                    <p class="text-amber-500 text-sm leading-none">{{ $stars($r->rating) }}</p>
                                </div>
                                <span class="text-xs text-slate-500">{{ $r->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-slate-700 leading-relaxed">{{ $r->comment }}</p>
                        </div>
                        @empty
                        <div class="lg lg-soft rounded-[1.5rem] p-10 text-center text-slate-600">
                            <span class="text-4xl block mb-2">💬</span>No reviews for this product yet.
                        </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- ============ RELATED PRODUCTS ============ --}}
            @if($related->count())
            <section class="mt-14">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Related Products</h2>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($related as $rp)
                    <a href="{{ route('product.show', $rp->id) }}" data-instant class="lg lg-soft lg-btn rounded-[1.5rem] p-4 block text-center">
                        <span class="block text-5xl mb-2">{{ $rp->emoji ?? '📦' }}</span>
                        <p class="text-sm font-bold text-slate-900 line-clamp-2">{{ $rp->name }}</p>
                        <p class="text-sm font-semibold text-sky-700 mt-1">Rp {{ number_format($rp->price, 0, ',', '.') }}</p>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

        </div>
    </div>
</main>
@endsection