@extends('layouts.app')

@section('title', 'TokoKu — Katalog Kurasi')

@section('content')
<!-- ========================================== -->
<!-- 1. HERO SECTION (Centered Glass Card)      -->
<!-- ========================================== -->
<main class="relative w-full max-w-[95vw] mx-auto px-2 md:px-6 pt-6 pb-20">
    
    <!-- Pendaran Cahaya Lembut di Belakang -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] h-[80%] bg-blue-100/60 rounded-[4rem] blur-[120px] pointer-events-none -z-10"></div>

    <!-- Kartu Kaca Utama -->
    <div class="relative header-glass-blue rounded-[2rem] md:rounded-[4rem] p-8 md:p-16 min-h-[75vh] flex flex-col justify-center items-center shadow-2xl shadow-blue-900/10">
        
        <div class="max-w-4xl mx-auto text-center">
            
            <!-- Badge (Hero Anim) -->
            <div class="hero-anim inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/60 backdrop-blur-md text-blue-700 text-xs font-semibold mb-8 border border-white/80 shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                Katalog Kurasi Minggu Ini
            </div>
            
            <!-- Judul (Hero Anim) -->
            <h1 class="hero-anim text-5xl md:text-7xl lg:text-8xl font-serif-display text-slate-900 mb-6 leading-[1.05]">
                Temukan Barang<br>
                <span class="italic text-slate-600">Istimewa.</span>
            </h1>
            
            <!-- Sub-judul (Hero Anim) -->
            <p class="hero-anim text-lg md:text-xl text-slate-600 mb-12 leading-relaxed max-w-2xl mx-auto">
                Koleksi pilihan dari penjual terpercaya. Lacak setiap perjalanan paket Anda hingga tiba di depan pintu dengan transparansi penuh.
            </p>

            <!-- Search Bar (Hero Anim) -->
            <div class="hero-anim relative max-w-2xl mx-auto mb-10">
                <div class="bg-white/70 backdrop-blur-xl border border-white/90 flex items-center p-2 rounded-full shadow-[0_8px_30px_rgba(0,0,0,0.04)] focus-within:bg-white transition-all">
                    <svg class="w-6 h-6 text-slate-400 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="Cari sepatu, baju, elektronik..." class="w-full bg-transparent border-none outline-none px-4 py-3 text-slate-800 placeholder-slate-400 text-lg">
                    <button class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-full hover:bg-blue-700 transition-all duration-300 shadow-md">
                        Cari
                    </button>
                </div>
            </div>

            <!-- Tautan Cepat (Hero Anim) -->
            <div class="hero-anim flex flex-wrap justify-center gap-x-6 gap-y-2 text-sm text-slate-500">
                <span class="font-medium text-slate-400">Populer:</span>
                <a href="#" class="hover:text-blue-600 transition underline decoration-slate-300 underline-offset-4">Sneakers</a>
                <a href="#" class="hover:text-blue-600 transition underline decoration-slate-300 underline-offset-4">Headphone</a>
                <a href="#" class="hover:text-blue-600 transition underline decoration-slate-300 underline-offset-4">Jam Tangan</a>
            </div>

        </div>
    </div>
</main>

<!-- ========================================== -->
<!-- 2. FEATURED PRODUCTS (Grid Minimalis)      -->
<!-- ========================================== -->
<section class="py-24 max-w-7xl mx-auto px-6">
    <div class="scroll-anim flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
        <div>
            <h2 class="text-3xl md:text-4xl font-serif-display text-slate-900 mb-2">Pilihan Kurator</h2>
            <p class="text-slate-500">Produk yang paling banyak diapresiasi minggu ini.</p>
        </div>
        <a href="{{ route('products') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-900 flex items-center gap-1 border-b border-slate-300 pb-1 self-start md:self-auto transition">
            Lihat Koleksi <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    
    <!-- Grid Container (Untuk trigger animasi) -->
    <div class="product-grid-container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <x-glass-card class="product-card stagger-item rounded-[2rem] p-3 cursor-pointer">
            <div class="h-56 bg-slate-50 rounded-[1.5rem] flex items-center justify-center text-7xl mb-4">👟</div>
            <div class="px-2 pb-2">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Fashion</p>
                <h3 class="font-bold text-slate-800 text-base mb-1">Sneakers Putih Premium</h3>
                <p class="text-slate-500 text-sm mb-3">⭐ 4.8 · 120 terjual</p>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-base text-slate-900">Rp 450.000</p>
                    <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-lg hover:bg-slate-900 hover:text-white transition">+</div>
                </div>
            </div>
        </x-glass-card>

        <!-- Card 2 -->
        <x-glass-card class="product-card stagger-item rounded-[2rem] p-3 cursor-pointer">
            <div class="h-56 bg-slate-50 rounded-[1.5rem] flex items-center justify-center text-7xl mb-4">🎧</div>
            <div class="px-2 pb-2">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Elektronik</p>
                <h3 class="font-bold text-slate-800 text-base mb-1">Headphone Wireless</h3>
                <p class="text-slate-500 text-sm mb-3">⭐ 4.9 · 89 terjual</p>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-base text-slate-900">Rp 850.000</p>
                    <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-lg hover:bg-slate-900 hover:text-white transition">+</div>
                </div>
            </div>
        </x-glass-card>
        
        <!-- Card 3 -->
        <x-glass-card class="product-card stagger-item rounded-[2rem] p-3 cursor-pointer">
            <div class="h-56 bg-slate-50 rounded-[1.5rem] flex items-center justify-center text-7xl mb-4">👕</div>
            <div class="px-2 pb-2">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Fashion</p>
                <h3 class="font-bold text-slate-800 text-base mb-1">Kaos Katun Premium</h3>
                <p class="text-slate-500 text-sm mb-3">⭐ 4.7 · 234 terjual</p>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-base text-slate-900">Rp 150.000</p>
                    <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-lg hover:bg-slate-900 hover:text-white transition">+</div>
                </div>
            </div>
        </x-glass-card>

        <!-- Card 4 -->
        <x-glass-card class="product-card stagger-item rounded-[2rem] p-3 cursor-pointer">
            <div class="h-56 bg-slate-50 rounded-[1.5rem] flex items-center justify-center text-7xl mb-4">⌚</div>
            <div class="px-2 pb-2">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Elektronik</p>
                <h3 class="font-bold text-slate-800 text-base mb-1">Smartwatch Pro</h3>
                <p class="text-slate-500 text-sm mb-3">⭐ 4.6 · 45 terjual</p>
                <div class="flex items-center justify-between">
                    <p class="font-bold text-base text-slate-900">Rp 1.200.000</p>
                    <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-lg hover:bg-slate-900 hover:text-white transition">+</div>
                </div>
            </div>
        </x-glass-card>
    </div>
</section>
@endsection