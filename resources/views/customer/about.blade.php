@extends('layouts.app')

@section('title', 'Loka — About Us')

@section('content')

<!-- ========================================================= -->
<!-- 🌟 [BACKGROUND FIXED] GAMBAR LANGIT                       -->
<!-- ========================================================= -->
<div class="fixed inset-0 bg-cover bg-center -z-10"
    style="background-image: url('https://images.unsplash.com/photo-1513002749550-c59d786b8e6c?q=80&w=2000&auto=format&fit=crop');"></div>

<!-- Wrapper Utama dengan Panel Kaca -->
<main class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 pt-32 pb-24">

    <!-- Panel Kaca Utama -->
    <div class="bg-white/30 backdrop-blur-[30px] border border-white/50 rounded-[3rem] p-8 md:p-16 shadow-[0_8px_32px_rgba(0,0,0,0.1)]">
        
        <!-- HEADER ABOUT -->
        <div class="text-center max-w-3xl mx-auto mb-16 scroll-anim">
            <h1 class="text-5xl md:text-7xl font-serif-display text-slate-900 mb-6 leading-tight drop-shadow-sm">
                The Story<br><span class="italic text-slate-700">Behind Loka.</span>
            </h1>
            <p class="text-lg text-slate-800 leading-relaxed font-medium">
                We believe in full transparency, from the materials used to the hands that crafted them.
            </p>
        </div>

        <!-- KONTEN UTAMA (Teks & Gambar) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-20 scroll-anim">
            <!-- Teks Kiri -->
            <div class="border-l border-slate-400/50 pl-6 md:pl-8">
                <h2 class="text-3xl md:text-4xl font-serif-display text-slate-900 leading-[1.3] mb-6">
                    Curating the exceptional, for the everyday.
                </h2>
                <p class="text-lg text-slate-800 leading-relaxed font-light mb-6">
                    By carefully curating our collections from verified sellers, Loka™ ensures you get nothing but the best. We want you to shop with confidence, knowing every item has passed our rigorous quality standards.
                </p>
                <p class="text-lg text-slate-800 leading-relaxed font-light">
                    We don't just sell products; we tell stories. Every item in our collection has a journey, and we bring that transparency directly to you.
                </p>
            </div>
            
            <!-- Gambar Kanan -->
            <div class="relative h-[400px] rounded-[2.5rem] overflow-hidden border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.1)] group">
                <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=800&auto=format&fit=crop" 
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                     alt="Loka Story">
                <div class="absolute inset-0 bg-white/10 backdrop-blur-[2px] z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </div>
        </div>

        <!-- GRID NILAI / STANDAR -->
        <div class="scroll-anim">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-serif-display text-slate-900 mb-4">Explore Our Standards</h2>
                <p class="text-slate-700">Three principles that guide everything we do.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Standar 1 -->
                <div class="bg-white/50 backdrop-blur-xl border border-white/70 p-8 rounded-[2rem] hover:bg-white/70 transition-all duration-300 hover:-translate-y-1 shadow-sm">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Verified Quality</h3>
                    <p class="text-slate-600 leading-relaxed text-sm">Every seller and product is strictly vetted to ensure it meets our premium standards.</p>
                </div>

                <!-- Standar 2 -->
                <div class="bg-white/50 backdrop-blur-xl border border-white/70 p-8 rounded-[2rem] hover:bg-white/70 transition-all duration-300 hover:-translate-y-1 shadow-sm">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Full Transparency</h3>
                    <p class="text-slate-600 leading-relaxed text-sm">Know exactly where your products come from, the materials used, and who made them.</p>
                </div>

                <!-- Standar 3 -->
                <div class="bg-white/50 backdrop-blur-xl border border-white/70 p-8 rounded-[2rem] hover:bg-white/70 transition-all duration-300 hover:-translate-y-1 shadow-sm">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Seamless Experience</h3>
                    <p class="text-slate-600 leading-relaxed text-sm">From secure checkout to reliable delivery, we make your shopping experience effortless.</p>
                </div>
            </div>
        </div>

        <!-- CALL TO ACTION -->
        <div class="mt-20 text-center scroll-anim">
            <a href="{{ route('shop') }}" class="inline-flex items-center justify-center px-8 py-4 bg-slate-900 text-white font-bold rounded-full hover:bg-blue-600 transition-all duration-300 shadow-xl hover:-translate-y-1">
                Explore The Collection &rarr;
            </a>
        </div>

    </div>
</main>
@endsection