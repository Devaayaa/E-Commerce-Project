@extends('layouts.app')

@section('title', 'Loka — Discover Exceptional Items')

@section('content')

<!-- ☁️ [BACKGROUND FIXED] LANGIT + AWAN BERGERAK -->
<div class="sky" aria-hidden="true">
    <div class="cloud-pic" style="top:4%;left:-4%;--w:420px;--d:18s"></div>
    <div class="cloud-pic" style="top:22%;right:-3%;--w:520px;--d:22s;--dl:-6s"></div>
    <div class="cloud-pic" style="top:48%;left:-6%;--w:380px;--d:15s;--dl:-3s"></div>
    <div class="cloud-pic" style="top:66%;right:2%;--w:460px;--d:20s;--dl:-9s"></div>
    <div class="cloud-pic" style="top:84%;left:8%;--w:340px;--d:17s;--dl:-2s"></div>
</div>

<!-- Wrapper Relatif (Section 1 & 2) -->
<div class="relative w-full">

    <!-- 🌟 [SECTION 1] HERO — kartu liquid glass membulat -->
    <section id="hero" class="relative w-full h-screen min-h-[750px] overflow-hidden flex items-center justify-center z-20">
        <!-- Ubah max-w-4xl menjadi max-w-7xl (atau max-w-[1440px]) agar panel melebar ke samping -->
        <div class="relative z-20 w-full max-w-6xl mx-auto px-4 sm:px-8 mt-10">
            <div class="lg lg-spot rounded-[3rem] px-6 md:px-18 lg:px-24 py-12 md:py-16 text-center">
                <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-2 rounded-full text-[10px] font-extrabold tracking-[0.2em] uppercase text-sky-800 mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500 shadow-[0_0_8px_rgba(14,165,233,.9)]"></span> Curated marketplace
                </span>
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-serif-display text-slate-900 mb-2 leading-[1.2]">
                    <span class="hover-text block cursor-default">Elevate your everyday.</span>
                </h1>
                <h2 class="text-3xl md:text-5xl lg:text-7xl font-serif-display italic text-sky-700 mb-8 leading-[1.2]">
                    <span class="hover-text block cursor-default">Curated exceptional items.</span>
                </h2>
                <p class="text-slate-700 text-base md:text-xl mb-10 max-w-3xl mx-auto leading-relaxed font-medium">
                    Discover premium products from trusted sellers. Seamless shopping, secure checkout, and reliable delivery.
                </p>
                <a href="{{ route('shop') }}" class="lg lg-soft lg-btn inline-flex items-center justify-center px-8 py-3.5 text-slate-900 font-bold rounded-full">
                    Shop Now &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- 🌟 [SECTION 2] ABOUT — liquid glass (background menyatu dengan hero) -->
    <section id="about" class="relative w-full h-screen overflow-hidden flex items-center justify-center z-20">
        <div class="relative w-full max-w-7xl mx-auto px-6 h-full flex items-center justify-center z-10">
            <div id="why-badge" class="lg lg-soft absolute inline-flex items-center px-5 py-2.5 rounded-full text-sky-700 text-[11px] font-bold tracking-[0.2em] uppercase opacity-0 z-30" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
                Why Loka?
            </div>
            <div id="about-content" class="lg lg-spot max-w-4xl ml-auto text-left opacity-0 translate-y-10 relative rounded-[2.5rem] p-8 md:p-12">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-serif-display text-slate-900 leading-[1.3] mb-6">
                    <span class="reveal-line block">Discover the story behind every</span>
                    <span class="reveal-line block">product. We believe in full</span>
                    <span class="reveal-line block">transparency, from the</span>
                    <span class="reveal-line block">materials used to the hands that</span>
                    <span class="reveal-line block">crafted them.</span>
                </h2>
                <p class="text-lg md:text-xl text-slate-800 leading-relaxed font-light mb-8">
                    <span class="reveal-line block">By carefully curating our collections from verified sellers,</span>
                    <span class="reveal-line block">Loka™ ensures you get nothing but the best. Shop with</span>
                    <span class="reveal-line block">confidence, knowing every item has passed our rigorous</span>
                    <span class="reveal-line block">quality standards.</span>
                </p>
                <a href="{{ route('shop') }}" class="lg lg-soft lg-btn inline-flex items-center justify-center px-8 py-3.5 text-slate-900 font-bold rounded-full">
                    Explore Our Standards &rarr;
                </a>
            </div>
        </div>
    </section>

</div>

<!-- 🌟 [WRAPPER BAWAH] BACKGROUND BIRU AWAN (overflow-x-clip agar sticky FAQ tetap bekerja) -->
<div class="relative w-full overflow-x-clip bg-gradient-to-b from-[#cfe7ff] via-[#e2f1ff] to-[#d3e9ff]">

    <!-- Latar hidup: awan, orb warna, dan gelembung kaca yang melayang -->
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="orb-float absolute -top-[6%] -left-[10%] w-[70vw] h-[70vw] bg-white/70 rounded-full blur-[150px]"></div>
        <div class="orb-float absolute top-[18%] -right-[12%] w-[60vw] h-[60vw] bg-sky-300/45 rounded-full blur-[150px]" style="animation-delay:-6s"></div>
        <div class="orb-float absolute top-[48%] -left-[8%] w-[45vw] h-[45vw] bg-indigo-300/35 rounded-full blur-[140px]" style="animation-delay:-9s"></div>
        <div class="orb-float absolute top-[68%] right-[4%] w-[40vw] h-[40vw] bg-cyan-200/60 rounded-full blur-[130px]" style="animation-delay:-3s"></div>
        <div class="orb-float absolute bottom-[4%] left-[18%] w-[34vw] h-[34vw] bg-amber-200/35 rounded-full blur-[130px]" style="animation-delay:-12s"></div>

        <div class="cloud" style="--t:12%; --w:620px; --o:.7; --b:18px; --d:130s; --delay:-40s"></div>
        <div class="cloud" style="--t:42%; --w:760px; --o:.65; --b:20px; --d:150s; --delay:-90s"></div>
        <div class="cloud" style="--t:74%; --w:680px; --o:.7; --b:18px; --d:120s; --delay:-20s"></div>

        <div class="bubble" style="top:9%;  left:6%;  width:90px;  height:90px;  --dx:24px;  --dy:-46px; --d:13s"></div>
        <div class="bubble" style="top:27%; right:7%; width:140px; height:140px; --dx:-30px; --dy:-52px; --d:17s; --delay:-5s"></div>
        <div class="bubble" style="top:52%; left:4%;  width:64px;  height:64px;  --dx:18px;  --dy:-36px; --d:11s; --delay:-3s"></div>
        <div class="bubble" style="top:71%; right:10%;width:110px; height:110px; --dx:-22px; --dy:-44px; --d:15s; --delay:-8s"></div>
        <div class="bubble" style="top:88%; left:12%; width:80px;  height:80px;  --dx:26px;  --dy:-40px; --d:14s; --delay:-2s"></div>
    </div>

    <!-- 🌟 [SECTION 3] CATEGORIES — folder terbuka otomatis, isi: kategori -->
    @php
    $categories = [
    ['name' => 'Fashion', 'slug' => 'fashion', 'desc' => 'Everyday pieces with a considered finish.', 'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=800&auto=format&fit=crop'],
    ['name' => 'Electronics', 'slug' => 'electronics', 'desc' => 'Smart tech from trusted sellers.', 'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?q=80&w=800&auto=format&fit=crop'],
    ['name' => 'Beauty', 'slug' => 'beauty', 'desc' => 'Skincare and care essentials, verified.', 'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?q=80&w=800&auto=format&fit=crop'],
    ['name' => 'Home', 'slug' => 'home', 'desc' => 'Quiet, well-made things for your space.', 'image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?q=80&w=800&auto=format&fit=crop'],
    ['name' => 'Gaming', 'slug' => 'gaming', 'desc' => 'Gear built for long sessions.', 'image' => 'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?q=80&w=800&auto=format&fit=crop'],
    ];
    @endphp
    <section id="categories-wrapper" class="relative z-10 py-24 px-2 flex flex-col items-center justify-center scroll-anim overflow-hidden">
        <div class="tf-stage tf-stage--wide">
            <div class="tf-glow"></div>
            <span class="tf-kicker lg lg-soft"><i></i> Collections</span>
            <h2 class="font-serif-display text-3xl md:text-5xl text-slate-900 mb-4">Curated Categories.</h2>
            <p class="text-slate-600 max-w-lg mx-auto">Explore our collections, tailored for your lifestyle.</p>

            <div class="tf-zone tf-zone--row" data-mode="row">
                <div class="tf-folder">
                    <div class="tf-shadow"></div>
                    <div class="tf-back"></div>
                    <div class="tf-tab">Categories</div>
                    <svg class="tf-outline" viewBox="0 0 320 262" fill="none" aria-hidden="true">
                        <defs>
                            <linearGradient id="tf-rim-cat" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0" stop-color="#fff" stop-opacity=".95" />
                                <stop offset=".45" stop-color="#fff" stop-opacity=".25" />
                                <stop offset="1" stop-color="#fff" stop-opacity=".7" />
                            </linearGradient>
                        </defs>
                        <path d="M.6 22Q.6 .6 22 .6L108 .6C124 .6 126 32.6 142 32.6L296 32.6Q319.4 32.6 319.4 56L319.4 238Q319.4 261.4 296 261.4L24 261.4Q.6 261.4 .6 238Z" stroke="url(#tf-rim-cat)" stroke-width="1.6" />
                    </svg>

                    @foreach($categories as $c)
                    <a href="{{ route('shop', ['category' => $c['slug']]) }}" class="tf-card" data-slot="{{ $loop->index }}">
                        <div class="tf-fl">
                            <img src="{{ $c['image'] }}" alt="{{ $c['name'] }}" loading="lazy">
                            <div class="tf-cap">{{ $c['name'] }}<em>Explore &rarr;</em></div>
                        </div>
                    </a>
                    @endforeach

                    <div class="tf-badge tf-bd-a">
                        <div class="tf-fl">✨ New season</div>
                    </div>
                    <div class="tf-badge tf-bd-b">
                        <div class="tf-fl">✓ Verified sellers</div>
                    </div>

                    <div class="tf-front">
                        <div class="tf-stars" style="color:#0c4a6e">📁 <span>5 collections</span></div>
                        <p>"Everything you love, sorted and ready to explore."</p>
                        <div class="tf-who"><span>Tap a file to open</span><span class="tf-ok">→</span></div>
                    </div>
                </div>
            </div>

            {{-- tf-hint dihapus: folder terbuka otomatis saat di-scroll --}}
            <a href="{{ route('shop') }}" class="tf-cta lg lg-soft lg-btn">Shop all categories &rarr;</a>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 🌟 [SECTION 3.5] LIQUID GLASS PRODUCT FOLDER              -->
    <!-- ========================================================= -->
    @php
    $items = collect($products ?? [])->take(5)->values();

    // Slot adaptif: [2]=center, [1]=left, [3]=right, [0]=far-left, [4]=far-right
    $slotMap = [
    1 => [2],
    2 => [1, 3],
    3 => [1, 2, 3],
    4 => [1, 2, 3, 4],
    5 => [2, 1, 3, 0, 4],
    ];
    $slots = $slotMap[$items->count()] ?? [2, 1, 3, 0, 4];

    // Fallback images (Unsplash) — dipakai kalau product->image kosong
    $fallbackImgs = [
    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1546435770-a3e426bf472b?q=80&w=600&auto=format&fit=crop',
    ];

    // Helper: URL gambar produk + fallback per-index
    $imgOf = function ($p, $idx = 0) use ($fallbackImgs) {
    $raw = $p->image ?? '';
    if (\Illuminate\Support\Str::startsWith($raw, ['http', '/'])) {
    return $raw;
    }
    if ($raw) {
    return asset('storage/' . $raw);
    }
    return $fallbackImgs[$idx % count($fallbackImgs)];
    };
    @endphp

    @if($items->count())
    <section id="community" class="relative z-10 py-32 px-6 flex flex-col items-center justify-center scroll-anim overflow-hidden min-h-screen">
        <div class="tf-stage">
            <div class="tf-glow"></div>
            <span class="tf-kicker lg lg-soft"><i></i> Community favorites</span>
            <h2 class="font-serif-display text-3xl md:text-5xl text-slate-900 mb-4">Loved by our community.</h2>
            <p class="text-slate-600 max-w-lg mx-auto">Hover over the folder to discover our curated products and what customers are saying about them.</p>

            <div class="tf-zone" id="tf-zone" data-mode="fan">
                <div class="tf-folder">
                    <div class="tf-shadow"></div>
                    <div class="tf-back"></div>
                    <div class="tf-tab">Loka Picks</div>
                    <svg class="tf-outline" viewBox="0 0 320 262" fill="none" aria-hidden="true">
                        <defs>
                            <linearGradient id="tf-rim" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0" stop-color="#fff" stop-opacity=".95" />
                                <stop offset=".45" stop-color="#fff" stop-opacity=".25" />
                                <stop offset="1" stop-color="#fff" stop-opacity=".7" />
                            </linearGradient>
                        </defs>
                        <path d="M.6 22Q.6 .6 22 .6L108 .6C124 .6 126 32.6 142 32.6L296 32.6Q319.4 32.6 319.4 56L319.4 238Q319.4 261.4 296 261.4L24 261.4Q.6 261.4 .6 238Z" stroke="url(#tf-rim)" stroke-width="1.6" />
                    </svg>

                    @foreach($items as $i => $p)
                    <a href="{{ url('/product/' . $p->id) }}" class="tf-card" data-slot="{{ $slots[$i] }}">
                        <div class="tf-fl">
                            <img src="{{ $imgOf($p, $i) }}" alt="{{ $p->name }}" loading="lazy"
                                onerror="this.src='{{ $fallbackImgs[$i % count($fallbackImgs)] }}'">
                            <div class="tf-cap">
                                {{ \Illuminate\Support\Str::limit($p->name, 20) }}
                                <em>Rp {{ number_format($p->price, 0, ',', '.') }}</em>
                            </div>
                        </div>
                    </a>
                    @endforeach

                    <div class="tf-badge tf-bd-a">
                        <div class="tf-fl">✨ Curated picks</div>
                    </div>
                    <div class="tf-badge tf-bd-b">
                        <div class="tf-fl">✓ 100% Authentic</div>
                    </div>

                    <div class="tf-front">
                        <div class="tf-stars">★★★★★ <span>5.0 / 5.0</span></div>
                        <p>"The quality is absolutely unmatched. The minimalist design fits perfectly with my daily style."</p>
                        <div class="tf-who"><span>— Sarah J., Verified Buyer</span><span class="tf-ok">✓</span></div>
                    </div>
                </div>
            </div>

            <div class="tf-hint lg lg-soft"><span class="dot"></span> Hover or tap the folder</div>

            <div class="tf-stats">
                <div class="tf-stat lg lg-soft"><b>Verified</b><span>Sellers only</span></div>
                <div class="tf-stat lg lg-soft"><b>100%</b><span>Authentic</span></div>
                <div class="tf-stat lg lg-soft"><b>Secure</b><span>Checkout</span></div>
            </div>

            <a href="{{ route('shop') }}" class="tf-cta lg lg-soft lg-btn">View all products &rarr;</a>
        </div>
    </section>
    @endif

    <!-- 🌟 [SECTION 3.6] WHY CHOOSE US -->
    <section class="relative z-10 py-20 max-w-5xl mx-auto px-6 scroll-anim">
        <div class="text-center mb-16 relative z-10">
            <h2 class="text-3xl md:text-4xl font-serif-display text-slate-900 mb-4">The Loka Standard.</h2>
            <p class="text-slate-600 max-w-2xl mx-auto">We go above and beyond to ensure your shopping experience is seamless, secure, and satisfying.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
            <div class="std-card lg lg-spot rounded-[2rem] p-8 text-center">
                <div class="float-y lg lg-soft w-16 h-16 mx-auto text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Verified Sellers</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Every item is curated from trusted, verified sellers to guarantee authenticity and premium quality.</p>
            </div>
            <div class="std-card lg lg-spot rounded-[2rem] p-8 text-center">
                <div class="float-y lg lg-soft w-16 h-16 mx-auto text-emerald-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Secure Delivery</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Track your order in real-time. Our professional couriers ensure your package arrives safely and on time.</p>
            </div>
            <div class="std-card lg lg-spot rounded-[2rem] p-8 text-center">
                <div class="float-y lg lg-soft w-16 h-16 mx-auto text-amber-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Easy Payments</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Choose from a wide range of payment methods including bank transfers, credit cards, and e-wallets.</p>
            </div>
        </div>
    </section>

    <!-- 🌟 [SECTION 4] FAQ — versi baru -->
    <section id="contact" class="relative z-10 bg-transparent py-28 max-w-6xl mx-auto px-6 scroll-anim">
        <div class="grid grid-cols-1 lg:grid-cols-[0.85fr_1.15fr] gap-10 lg:gap-16 items-start">

            <!-- Kiri: judul + kartu bantuan (sticky) -->
            <div class="lg:sticky lg:top-32">
                <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[10px] font-extrabold tracking-[0.2em] uppercase text-sky-700 mb-5">FAQ</span>
                <h2 class="text-4xl md:text-5xl font-serif-display text-slate-900 leading-[1.15] mb-4">
                    Questions,<br><span class="italic text-sky-700">answered.</span>
                </h2>
                <p class="text-slate-600 mb-8 max-w-sm">Everything you need to know about ordering, paying and receiving your items.</p>

                <div class="lg lg-spot rounded-[2rem] p-6 max-w-sm">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="lg lg-soft lg-blue w-10 h-10 rounded-full grid place-items-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.86 9.86 0 01-4-.83L3 20l1.3-3.9A7.6 7.6 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </span>
                        <h3 class="font-bold text-slate-900">Still curious?</h3>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed mb-4">Can't find what you're looking for? Our team is happy to help.</p>
                    <a href="{{ route('contact') }}" class="lg lg-soft lg-btn inline-flex items-center px-5 py-2.5 rounded-full text-[13px] font-bold text-slate-900">Contact support &rarr;</a>
                </div>
            </div>

            <!-- Kanan: pencarian + accordion -->
            <div>
                <label class="lg lg-soft flex items-center gap-3 rounded-full px-5 py-3.5 mb-5">
                    <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                    <input id="faq-search" type="search" placeholder="Search questions…" autocomplete="off" class="w-full bg-transparent outline-none text-sm text-slate-900 placeholder-slate-500">
                </label>

                @php
                $faqs = [
                ['q' => 'How do I order a product?', 'a' => 'Select a product, add it to your cart, and proceed to checkout.'],
                ['q' => 'What payment methods are available?', 'a' => 'We accept bank transfers, credit cards, and e-wallets.'],
                ['q' => 'How long does shipping take?', 'a' => 'Regular shipping takes 2-4 business days, depending on your location.'],
                ['q' => 'How can I track my order?', 'a' => 'Sign in and open My Orders to follow the status of your delivery in real time.'],
                ['q' => 'Are the products authentic?', 'a' => 'Every item is curated from verified sellers to guarantee authenticity and premium quality.'],
                ['q' => 'Who can I contact for help?', 'a' => 'Visit our Contact page and send us a message. We will get back to you as soon as possible.'],
                ];
                @endphp
                <div id="faq-list" class="space-y-3">
                    @foreach($faqs as $i => $faq)
                    <div class="faq-item lg lg-soft lg-spot">
                        <button type="button" class="faq-btn" aria-expanded="false" onclick="toggleFaq(this)">
                            <span class="faq-num">{{ sprintf('%02d', $i + 1) }}</span>
                            <span class="faq-q">{{ $faq['q'] }}</span>
                            <span class="faq-icon" aria-hidden="true"></span>
                        </button>
                        <div class="faq-panel">
                            <div class="faq-body">{{ $faq['a'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p id="faq-empty" class="hidden text-center text-sm text-slate-500 mt-6">No matching questions. Try another keyword.</p>
            </div>
        </div>
    </section>

</div>
@endsection