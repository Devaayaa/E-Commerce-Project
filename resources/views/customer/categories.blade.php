@extends('layouts.app')

@section('title', 'Loka — Curated Categories')

@section('content')

<!-- ========================================================= -->
<!-- 🌟 [BACKGROUND FIXED] GAMBAR LANGIT                       -->
<!-- ========================================================= -->
<div class="fixed inset-0 bg-cover bg-center -z-10"
    style="background-image: url('https://images.unsplash.com/photo-1513002749550-c59d786b8e6c?q=80&w=2000&auto=format&fit=crop');"></div>

<!-- Wrapper Utama dengan Panel Kaca -->
<main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 pt-32 pb-24">

    <!-- Panel Kaca Utama -->
    <div class="bg-white/30 backdrop-blur-[30px] border border-white/50 rounded-[3rem] p-6 md:p-12 shadow-[0_8px_32px_rgba(0,0,0,0.1)]">

        <!-- HEADER -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-5xl md:text-7xl font-serif-display text-slate-900 mb-6 leading-tight drop-shadow-sm">
                Curated<br><span class="italic text-slate-700">Categories.</span>
            </h1>
            <p class="text-lg text-slate-800 leading-relaxed font-medium">
                Explore our collections, tailored for your lifestyle. Carefully curated to bring you nothing but the best.
            </p>
        </div>

        @php
        $categories = [
            ['name' => 'Fashion', 'slug' => 'fashion', 'desc' => 'Timeless style for daily activities.', 'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=800&auto=format&fit=crop'],
            ['name' => 'Electronics', 'slug' => 'electronics', 'desc' => 'Technology that makes life easier.', 'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?q=80&w=800&auto=format&fit=crop'],
            ['name' => 'Beauty', 'slug' => 'beauty', 'desc' => 'Enhance your natural charm.', 'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?q=80&w=800&auto=format&fit=crop'],
            ['name' => 'Home', 'slug' => 'home', 'desc' => 'Make your space more comfortable.', 'image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?q=80&w=800&auto=format&fit=crop'],
            ['name' => 'Gaming', 'slug' => 'gaming', 'desc' => 'Level up your gaming performance.', 'image' => 'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?q=80&w=800&auto=format&fit=crop'],
        ];
        @endphp

        <!-- GRID KATEGORI (Desain menyatu dengan Home) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach($categories as $c)
            <a href="{{ route('shop', ['category' => $c['slug']]) }}"
                class="category-card group cursor-pointer h-[400px] relative rounded-[2.5rem] overflow-hidden border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-500 hover:shadow-2xl hover:border-white hover:-translate-y-2">

                <img src="{{ $c['image'] }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $c['name'] }}">
                
                <!-- Overlay Gradient -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent z-10"></div>
                
                <!-- Overlay Kaca saat Hover -->
                <div class="absolute inset-0 bg-white/10 backdrop-blur-[2px] z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                <!-- Badge -->
                <div class="absolute top-6 left-6 z-20 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white text-[10px] font-bold tracking-wider uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> Category
                </div>

                <!-- Teks Konten -->
                <div class="absolute bottom-8 left-8 right-8 z-20">
                    <h3 class="text-3xl font-serif-display text-white mb-2">{{ $c['name'] }}</h3>
                    <p class="text-white/70 text-sm mb-4">{{ $c['desc'] }}</p>
                    
                    <div class="flex items-center gap-2 text-white text-sm font-bold opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                        Explore Collection <span class="text-lg">&rarr;</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</main>
@endsection