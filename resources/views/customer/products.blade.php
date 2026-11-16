@extends('layouts.app')

@section('title', 'TokoKu — Koleksi Kategori')

@section('content')
<main class="max-w-7xl mx-auto px-6 pt-24 pb-32">
    
    <!-- 1. HEADER & SEARCH -->
    <div class="text-center max-w-3xl mx-auto mb-12 hero-anim">
        <h1 class="text-5xl md:text-7xl font-serif-display text-slate-900 mb-6 leading-tight">
            Jelajahi<br><span class="italic text-slate-600">Koleksi Kami.</span>
        </h1>
        <p class="text-lg text-slate-500 leading-relaxed">
            Temukan produk esensial dari berbagai kategori. Dikurasi dengan cermat untuk menemani setiap momen Anda.
        </p>
    </div>

    <div class="max-w-2xl mx-auto mb-12 hero-anim">
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" placeholder="Cari koleksi, penjual, atau kategori..." class="w-full pl-12 pr-6 py-4 bg-white/60 backdrop-blur-md border border-white/80 rounded-full shadow-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500/30 transition-all duration-300">
        </div>
    </div>

    <!-- 2. FILTER KATEGORI -->
    <div class="flex flex-wrap justify-center gap-3 mb-20 scroll-anim">
        <button data-category="all" class="filter-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 bg-slate-900 text-white shadow-lg">Semua Koleksi</button>
        <button data-category="fashion" class="filter-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 bg-white/60 text-slate-600 hover:bg-white hover:text-slate-900 border border-slate-200">Fashion</button>
        <button data-category="elektronik" class="filter-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 bg-white/60 text-slate-600 hover:bg-white hover:text-slate-900 border border-slate-200">Elektronik</button>
        <button data-category="kecantikan" class="filter-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 bg-white/60 text-slate-600 hover:bg-white hover:text-slate-900 border border-slate-200">Kecantikan</button>
        <button data-category="rumah" class="filter-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 bg-white/60 text-slate-600 hover:bg-white hover:text-slate-900 border border-slate-200">Kebutuhan Rumah</button>
    </div>

    <!-- 3. DAFTAR PRODUK PER KATEGORI -->
    <div id="product-container" class="space-y-24">
        
        <!-- Section: Fashion -->
        <section class="category-section product-section" data-category="fashion">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <h2 class="text-3xl md:text-4xl font-serif-display text-slate-900 mb-2">Fashion</h2>
                    <p class="text-slate-500">Gaya abadi untuk aktivitas harian.</p>
                </div>
                <a href="#" class="text-sm font-semibold text-slate-500 hover:text-slate-900 border-b border-slate-300 pb-1 transition">Lihat Semua</a>
            </div>
            
            <div class="flex overflow-x-auto gap-6 pb-6 snap-x snap-mandatory scroll-smooth hide-scrollbar">
                
                <!-- KARTU PRODUK 1 -->
                <div class="carousel-item snap-start shrink-0 w-64 sm:w-[280px] group cursor-pointer transition-transform duration-500 hover:-translate-y-2">
                    <div class="relative h-[320px] bg-gradient-to-tr from-blue-100 to-indigo-50 rounded-t-[2rem] flex items-center justify-center overflow-hidden border border-b-0 border-slate-200">
                        <span class="text-8xl transform group-hover:scale-110 transition-transform duration-700 ease-out drop-shadow-xl">👟</span>
                    </div>
                    <!-- Panel Bawah (Abu-abu Grey) -->
                    <div class="bg-gray-600 text-white p-5 rounded-b-[2rem] h-[180px] flex flex-col justify-between shadow-lg group-hover:shadow-2xl transition-shadow duration-500">
                        <div>
                            <div class="flex flex-wrap gap-1.5 mb-3">
                                <span class="px-2.5 py-1 bg-white text-black text-[10px] font-bold rounded-full">Fashion</span>
                                <span class="px-2.5 py-1 bg-[#c4f000] text-black text-[10px] font-bold rounded-full">Best Seller</span>
                            </div>
                            <h3 class="font-bold text-lg leading-tight mb-1">Sneakers Putih Premium</h3>
                            <p class="text-xs text-gray-200 line-clamp-2">Sepatu kasual dengan desain minimalis yang cocok untuk segala aktivitas.</p>
                        </div>
                        <p class="font-semibold text-sm text-white">Rp 450.000</p>
                    </div>
                </div>

                <!-- KARTU PRODUK 2 -->
                <div class="carousel-item snap-start shrink-0 w-64 sm:w-[280px] group cursor-pointer transition-transform duration-500 hover:-translate-y-2">
                    <div class="relative h-[320px] bg-gradient-to-tr from-emerald-100 to-teal-50 rounded-t-[2rem] flex items-center justify-center overflow-hidden border border-b-0 border-slate-200">
                        <span class="text-8xl transform group-hover:scale-110 transition-transform duration-700 ease-out drop-shadow-xl">👕</span>
                    </div>
                    <!-- Panel Bawah (Abu-abu Grey) -->
                    <div class="bg-gray-600 text-white p-5 rounded-b-[2rem] h-[180px] flex flex-col justify-between shadow-lg group-hover:shadow-2xl transition-shadow duration-500">
                        <div>
                            <div class="flex flex-wrap gap-1.5 mb-3">
                                <span class="px-2.5 py-1 bg-white text-black text-[10px] font-bold rounded-full">Fashion</span>
                                <span class="px-2.5 py-1 bg-[#00e0b0] text-black text-[10px] font-bold rounded-full">Eco Friendly</span>
                            </div>
                            <h3 class="font-bold text-lg leading-tight mb-1">Kaos Katun Premium</h3>
                            <p class="text-xs text-gray-200 line-clamp-2">100% bahan katun organik yang lembut dan nyaman dipakai seharian.</p>
                        </div>
                        <p class="font-semibold text-sm text-white">Rp 150.000</p>
                    </div>
                </div>

                <!-- KARTU PRODUK 3 -->
                <div class="carousel-item snap-start shrink-0 w-64 sm:w-[280px] group cursor-pointer transition-transform duration-500 hover:-translate-y-2">
                    <div class="relative h-[320px] bg-gradient-to-tr from-slate-200 to-slate-50 rounded-t-[2rem] flex items-center justify-center overflow-hidden border border-b-0 border-slate-200">
                        <span class="text-8xl transform group-hover:scale-110 transition-transform duration-700 ease-out drop-shadow-xl">🧥</span>
                    </div>
                    <!-- Panel Bawah (Abu-abu Grey) -->
                    <div class="bg-gray-600 text-white p-5 rounded-b-[2rem] h-[180px] flex flex-col justify-between shadow-lg group-hover:shadow-2xl transition-shadow duration-500">
                        <div>
                            <div class="flex flex-wrap gap-1.5 mb-3">
                                <span class="px-2.5 py-1 bg-white text-black text-[10px] font-bold rounded-full">Fashion</span>
                                <span class="px-2.5 py-1 bg-[#f59e0b] text-black text-[10px] font-bold rounded-full">Terbatas</span>
                            </div>
                            <h3 class="font-bold text-lg leading-tight mb-1">Jaket Bomber</h3>
                            <p class="text-xs text-gray-200 line-clamp-2">Jaket tahan angin dan air, sempurna untuk cuaca tidak menentu.</p>
                        </div>
                        <p class="font-semibold text-sm text-white">Rp 350.000</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- Section: Elektronik -->
        <section class="category-section product-section" data-category="elektronik">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <h2 class="text-3xl md:text-4xl font-serif-display text-slate-900 mb-2">Elektronik</h2>
                    <p class="text-slate-500">Teknologi yang memudahkan hidup.</p>
                </div>
                <a href="#" class="text-sm font-semibold text-slate-500 hover:text-slate-900 border-b border-slate-300 pb-1 transition">Lihat Semua</a>
            </div>
            
            <div class="flex overflow-x-auto gap-6 pb-6 snap-x snap-mandatory scroll-smooth hide-scrollbar">
                
                <!-- KARTU PRODUK 1 -->
                <div class="carousel-item snap-start shrink-0 w-64 sm:w-[280px] group cursor-pointer transition-transform duration-500 hover:-translate-y-2">
                    <div class="relative h-[320px] bg-gradient-to-tr from-slate-100 to-white rounded-t-[2rem] flex items-center justify-center overflow-hidden border border-b-0 border-slate-200">
                        <span class="text-8xl transform group-hover:scale-110 transition-transform duration-700 ease-out drop-shadow-xl">🎧</span>
                    </div>
                    <!-- Panel Bawah (Abu-abu Grey) -->
                    <div class="bg-gray-600 text-white p-5 rounded-b-[2rem] h-[180px] flex flex-col justify-between shadow-lg group-hover:shadow-2xl transition-shadow duration-500">
                        <div>
                            <div class="flex flex-wrap gap-1.5 mb-3">
                                <span class="px-2.5 py-1 bg-white text-black text-[10px] font-bold rounded-full">Elektronik</span>
                                <span class="px-2.5 py-1 bg-[#38bdf8] text-black text-[10px] font-bold rounded-full">Baru</span>
                            </div>
                            <h3 class="font-bold text-lg leading-tight mb-1">Headphone Wireless</h3>
                            <p class="text-xs text-gray-200 line-clamp-2">Active Noise Cancelling dengan baterai tahan hingga 40 jam.</p>
                        </div>
                        <p class="font-semibold text-sm text-white">Rp 850.000</p>
                    </div>
                </div>

                <!-- KARTU PRODUK 2 -->
                <div class="carousel-item snap-start shrink-0 w-64 sm:w-[280px] group cursor-pointer transition-transform duration-500 hover:-translate-y-2">
                    <div class="relative h-[320px] bg-gradient-to-tr from-amber-100 to-orange-50 rounded-t-[2rem] flex items-center justify-center overflow-hidden border border-b-0 border-slate-200">
                        <span class="text-8xl transform group-hover:scale-110 transition-transform duration-700 ease-out drop-shadow-xl">⌚</span>
                    </div>
                    <!-- Panel Bawah (Abu-abu Grey) -->
                    <div class="bg-gray-600 text-white p-5 rounded-b-[2rem] h-[180px] flex flex-col justify-between shadow-lg group-hover:shadow-2xl transition-shadow duration-500">
                        <div>
                            <div class="flex flex-wrap gap-1.5 mb-3">
                                <span class="px-2.5 py-1 bg-white text-black text-[10px] font-bold rounded-full">Elektronik</span>
                                <span class="px-2.5 py-1 bg-[#fbbf24] text-black text-[10px] font-bold rounded-full">Premium</span>
                            </div>
                            <h3 class="font-bold text-lg leading-tight mb-1">Smartwatch Pro</h3>
                            <p class="text-xs text-gray-200 line-clamp-2">Pantau kesehatan dan notifikasi langsung dari pergelangan tangan.</p>
                        </div>
                        <p class="font-semibold text-sm text-white">Rp 1.200.000</p>
                    </div>
                </div>

            </div>
        </section>

    </div>
</main>
@endsection