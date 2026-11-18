@extends('layouts.app')

@section('title', 'Loka — Discover Exceptional Items')

@section('content')

<!-- ========================================================= -->
<!-- 🌟 [BACKGROUND FIXED] GAMBAR LANGIT                       -->
<!-- ========================================================= -->
<div class="fixed inset-0 bg-cover bg-center -z-10" 
     style="background-image: url('https://images.unsplash.com/photo-1513002749550-c59d786b8e6c?q=80&w=2000&auto=format&fit=crop');"></div>

<!-- Wrapper Relatif (Membungkus Section 1 & 2) -->
<div class="relative w-full">
    
    <!-- ========================================================= -->
    <!-- 🌟 [SECTION 1] HERO SECTION                               -->
    <!-- ========================================================= -->
    <section id="hero" class="relative w-full h-screen min-h-[750px] overflow-hidden flex items-center justify-center z-20">
        <!-- Efek Kaca Dipisah ke Div -->
        <div class="absolute inset-0 bg-white/20 backdrop-blur-[20px] pointer-events-none"></div>

        <div class="relative z-20 w-full max-w-4xl mx-auto px-6 text-center mt-10">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-serif-display text-white mb-2 leading-[1.2] drop-shadow-[0_4px_8px_rgba(0,0,0,0.3)]">
                <span class="hover-text block cursor-default">Elevate your everyday.</span>
            </h1>

            <h2 class="text-3xl md:text-5xl lg:text-7xl font-serif-display italic text-black mb-8 leading-[1.2]">
                <span class="hover-text block cursor-default">Curated exceptional items.</span>
            </h2>
            
            <p class="text-slate-700 text-base md:text-xl mb-10 max-w-2xl mx-auto leading-relaxed font-medium">
                Discover premium products from trusted sellers. Seamless shopping, secure checkout, and reliable delivery.
            </p>
            
            <div>
                <!-- FIX: route('products') diganti route('shop') -->
                <a href="{{ route('shop') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-white/10 backdrop-blur-xl border border-white/60 text-slate-900 font-bold rounded-full hover:bg-white/30 transition-all duration-300 shadow-[0_8px_32px_rgba(0,0,0,0.1)] hover:shadow-[0_8px_32px_rgba(0,0,0,0.15)] hover:-translate-y-1">
                    Shop Now &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 🌟 [SECTION 2] ABOUT SECTION (Fixed Bug Duplikat)         -->
    <!-- ========================================================= -->
    <section id="about" class="relative w-full h-screen overflow-hidden flex items-center justify-center z-20">
        
        <div class="absolute inset-0 bg-white/20 backdrop-blur-[20px] border-t border-white/40 pointer-events-none"></div>

        <div class="relative w-full max-w-7xl mx-auto px-6 h-full flex items-center justify-center z-10">

            <div id="why-badge" class="absolute inline-flex items-center px-5 py-2.5 rounded-full border border-blue-200/50 bg-white/50 backdrop-blur-md text-blue-600 text-[11px] font-bold tracking-[0.2em] uppercase shadow-sm opacity-0 z-30" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
                Why Loka?
            </div>

            <div id="about-content" class="max-w-4xl ml-auto text-left opacity-0 translate-y-10 relative pl-6 md:pl-10 border-l border-slate-400/50">

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

                <!-- FIX: route('products') diganti route('shop') -->
                <a href="{{ route('shop') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-white/20 backdrop-blur-md border border-white/50 text-slate-900 font-bold rounded-full hover:bg-white/40 transition-all duration-300 shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-0.5">
                    Explore Our Standards &rarr;
                </a>
            </div>
        </div>
    </section>

</div> <!-- PENUTUP WRAPPER SECTION 1 & 2 -->

<!-- ========================================================= -->
<!-- 🌟 [WRAPPER BAWAH] BACKGROUND BIRU AWAN (Section 3 & 4)   -->
<!-- ========================================================= -->
<div class="relative w-full overflow-x-hidden bg-[#eaf6ff]">

    <!-- Efek Awan/Fog di Background -->
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-[10%] -left-[10%] w-[70vw] h-[70vw] bg-white/70 rounded-full blur-[150px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[60vw] h-[60vw] bg-blue-200/40 rounded-full blur-[150px]"></div>
        <div class="absolute bottom-[10%] left-[10%] w-[50vw] h-[50vw] bg-[#dbeafe]/50 rounded-full blur-[130px]"></div>
    </div>

    <!-- ========================================================= -->
    <!-- 🌟 [SECTION 3] CATEGORIES SECTION (Horizontal Scroll)     -->
    <!-- ========================================================= -->
    <section id="categories-wrapper" class="relative z-10 bg-transparent">
        <!-- FIX: Mengembalikan div #categories-pinned yang hilang dan menghapus tag <a> yang nyasar -->
        <div id="categories-pinned" class="h-screen flex flex-col justify-center overflow-hidden relative w-full">
            
            <div class="text-center mb-10 px-6 relative z-10">
                <h2 class="text-4xl md:text-5xl font-serif-display text-slate-900 mb-4">Curated Categories.</h2>
                <p class="text-slate-600">Explore our collections, tailored for your lifestyle.</p>
            </div>

            <div id="categories-track" class="flex gap-6 px-6 w-max relative z-10">
                @php
                $categories = [
                ['name' => 'Fashion', 'slug' => 'fashion', 'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Electronics', 'slug' => 'electronics', 'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Beauty', 'slug' => 'beauty', 'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Home', 'slug' => 'home', 'image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Gaming', 'slug' => 'gaming', 'image' => 'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?q=80&w=800&auto=format&fit=crop'],
                ];
                @endphp

                @foreach($categories as $c)
                <!-- FIX: route('products') diganti route('shop') -->
                <a href="{{ route('shop', ['category' => $c['slug']]) }}"
                    class="category-card shrink-0 w-[300px] md:w-[400px] h-[500px] relative rounded-[2.5rem] overflow-hidden group cursor-pointer border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-500 hover:shadow-2xl hover:border-white">

                    <img src="{{ $c['image'] }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $c['name'] }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent z-10"></div>
                    <div class="absolute inset-0 bg-white/10 backdrop-blur-[2px] z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                    <div class="absolute top-6 left-6 z-20 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white text-[10px] font-bold tracking-wider uppercase">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> Category
                    </div>

                    <div class="absolute bottom-8 left-8 z-20">
                        <h3 class="text-3xl font-serif-display text-white mb-2">{{ $c['name'] }}</h3>
                        <div class="flex items-center gap-2 text-white/80 text-sm font-medium opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                            Explore Collection <span class="text-lg">&rarr;</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 🌟 [SECTION 4] CONTACT / FAQ SECTION                      -->
    <!-- ========================================================= -->
    <section id="contact" class="relative z-10 bg-transparent py-24 max-w-3xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-serif-display text-slate-900 mb-4">Frequently Asked Questions</h2>
        </div>
        <div class="space-y-4">
            @php
            $faqs = [
            ['q' => 'How do I order a product?', 'a' => 'Select a product, add it to your cart, and proceed to checkout.'],
            ['q' => 'What payment methods are available?', 'a' => 'We accept bank transfers, credit cards, and e-wallets.'],
            ['q' => 'How long does shipping take?', 'a' => 'Regular shipping takes 2-4 business days, depending on your location.'],
            ];
            @endphp
            @foreach($faqs as $faq)
            <div class="border border-slate-200/60 rounded-2xl overflow-hidden bg-white/50 backdrop-blur-md hover:border-slate-300 transition-colors">
                <button class="w-full px-6 py-5 text-left font-bold text-slate-900 flex justify-between items-center focus:outline-none" onclick="toggleFaq(this)">
                    {{ $faq['q'] }}
                    <svg class="w-5 h-5 text-slate-500 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-content px-6 pb-5 text-slate-500 hidden leading-relaxed">{{ $faq['a'] }}</div>
            </div>
            @endforeach
        </div>
    </section>

</div>
@endsection