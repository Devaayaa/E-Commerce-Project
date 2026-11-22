@extends('layouts.app')

@section('title', 'Loka — About Us')

@section('content')

{{-- Styling: public/css/about.css | Script: public/js/about.js | Data: AboutController --}}
<link rel="stylesheet" href="{{ asset('css/about.css') }}">

<!-- ☁️ BACKGROUND — sama dengan Home & Shop -->
<div class="sky" aria-hidden="true">
    <div class="cloud-pic" style="top:4%;left:-4%;--w:420px;--d:18s"></div>
    <div class="cloud-pic" style="top:22%;right:-3%;--w:520px;--d:22s;--dl:-6s"></div>
    <div class="cloud-pic" style="top:48%;left:-6%;--w:380px;--d:15s;--dl:-3s"></div>
    <div class="cloud-pic" style="top:66%;right:2%;--w:460px;--d:20s;--dl:-9s"></div>
    <div class="cloud-pic" style="top:84%;left:8%;--w:340px;--d:17s;--dl:-2s"></div>
</div>

<main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 pt-36 pb-24">

    <!-- 🪟 PANE LIQUID GLASS UTAMA (lapisan kaca terpisah + glow kuning) -->
    <div class="relative rounded-[3rem]">
        <div class="lg bg-white/10 absolute inset-0 rounded-[3rem] pointer-events-none" aria-hidden="true">
            <div class="pane-glow"><i class="g1"></i><i class="g2"></i><i class="g3"></i></div></div><div class="absolute inset-0 overflow-hidden rounded-[3rem] pointer-events-none" aria-hidden="true"><span class="rise" style="left:6%;top:8%;--s:14px;--d:9s;--dl:-1s" aria-hidden="true">✦</span><span class="rise" style="left:90%;top:14%;--s:18px;--d:11s;--dl:-4s" aria-hidden="true">✦</span><span class="rise" style="left:12%;top:26%;--s:10px;--d:8s;--dl:-3s" aria-hidden="true">✦</span><span class="rise" style="left:84%;top:38%;--s:12px;--d:10s;--dl:-6s" aria-hidden="true">✦</span><span class="rise" style="left:5%;top:50%;--s:16px;--d:12s;--dl:-2s" aria-hidden="true">✦</span><span class="rise" style="left:92%;top:60%;--s:10px;--d:9s;--dl:-5s" aria-hidden="true">✦</span><span class="rise" style="left:14%;top:72%;--s:18px;--d:11s;--dl:-7s" aria-hidden="true">✦</span><span class="rise" style="left:80%;top:80%;--s:12px;--d:8s;--dl:-1s" aria-hidden="true">✦</span><span class="rise" style="left:8%;top:90%;--s:12px;--d:10s;--dl:-4s" aria-hidden="true">✦</span><span class="rise" style="left:88%;top:94%;--s:16px;--d:12s;--dl:-8s" aria-hidden="true">✦</span>
        </div>

        <div class="relative z-10 p-5 sm:p-8 lg:p-12 space-y-20 md:space-y-28">

            <!-- ========================================================= -->
            <!-- 1. HEADER                                                 -->
            <!-- ========================================================= -->
            <section class="about-head relative text-center max-w-3xl mx-auto scroll-anim">
                <span class="sparkle twinkle hidden sm:block" style="top:28%;left:6%;font-size:30px" aria-hidden="true">✦</span>
                <span class="sparkle twinkle d2 hidden sm:block" style="top:8%;right:10%;font-size:18px" aria-hidden="true">✦</span>
                <span class="sparkle twinkle d3 hidden sm:block" style="top:62%;right:4%;font-size:12px" aria-hidden="true">✦</span>

                <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-2 rounded-full text-[10px] font-extrabold tracking-[0.2em] uppercase text-sky-800 mb-6">
                    <span class="text-amber-500 text-xs">✦</span> About Loka
                </span>
                <h1 class="text-5xl md:text-7xl font-serif-display text-slate-900 mb-6 leading-[1.15]">
                    The Story<br><span class="italic text-sky-700 text-shimmer">Behind Loka.</span>
                </h1>
                <p class="text-lg text-slate-700 leading-relaxed font-medium">
                    We believe in full transparency, from the materials used to the hands that crafted them.
                </p>
                <div class="flex flex-wrap justify-center gap-2 mt-7">
                    <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold text-slate-700"><span class="text-amber-500">✦</span> Verified sellers</span>
                    <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold text-slate-700"><span class="text-amber-500">★</span> Curated picks</span>
                    <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold text-slate-700"><span class="text-amber-500">✓</span> Secure checkout</span>
                </div>
            </section>

            <!-- ========================================================= -->
            <!-- 2. STORY (teks + foto berbingkai kaca)                    -->
            <!-- ========================================================= -->
            <section class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-center scroll-anim">
                <div class="lg lg-spot rounded-[2.5rem] p-8 md:p-12">
                    <span class="block h-1 w-14 rounded-full bg-gradient-to-r from-amber-300 to-amber-500 mb-6"></span>
                    <h2 class="text-3xl md:text-4xl font-serif-display text-slate-900 leading-[1.3] mb-6">
                        Curating the exceptional, <span class="italic text-sky-700">for the everyday.</span>
                    </h2>
                    <p class="text-lg text-slate-700 leading-relaxed mb-5">
                        By carefully curating our collections from verified sellers, Loka™ ensures you get nothing but the best. We want you to shop with confidence, knowing every item has passed our rigorous quality standards.
                    </p>
                    <p class="text-lg text-slate-700 leading-relaxed">
                        We don't just sell products; we tell stories. Every item in our collection has a journey, and we bring that transparency directly to you.
                    </p>
                </div>

                <div class="relative">
                    <span class="absolute -top-8 -right-6 w-56 h-56 rounded-full bg-amber-300/50 blur-3xl pointer-events-none" aria-hidden="true"></span>
                    <span class="absolute -bottom-10 -left-8 w-56 h-56 rounded-full bg-sky-300/50 blur-3xl pointer-events-none" aria-hidden="true"></span>

                    <div class="about-tilt lg rounded-[2.5rem] p-3 relative">
                        <div class="about-photo relative h-[360px] md:h-[440px] rounded-[2rem] overflow-hidden"><div class="about-par absolute inset-x-0 -top-[10%] -bottom-[10%]">
                            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1000&auto=format&fit=crop"
                                 alt="Loka Story" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                            </div><div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent"></div>
                        </div>
                    </div>

                    {{-- badge kaca melayang --}}
                    <span class="float-y lg lg-gold absolute -top-4 left-6 px-4 py-2 rounded-full text-xs font-bold -rotate-3 z-10">✦ Hand-picked</span>
                    <div class="float-y lg lg-soft absolute -bottom-5 right-6 rounded-2xl px-4 py-3 flex items-center gap-3 z-10" style="animation-delay:-1.8s">
                        <span class="lg-blue lg w-9 h-9 rounded-full grid place-items-center text-sm">✓</span>
                        <div class="leading-tight">
                            <p class="text-sm font-bold text-slate-900">Verified sellers</p>
                            <p class="text-[11px] text-slate-600">Vetted one by one</p>
                        </div>
                    </div>
                    <span class="sparkle twinkle" style="top:42%;right:-10px;font-size:22px" aria-hidden="true">✦</span>
                </div>
            </section>

            <!-- ========================================================= -->
            <!-- 3. STATS KACA                                             -->
            <!-- ========================================================= -->
            <section class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 scroll-anim">
                @foreach($stats as $s)
                <div class="about-stat lg lg-soft lg-spot rounded-[2rem] p-5 md:p-7 text-center">
                    <span class="lg lg-gold w-11 h-11 rounded-full grid place-items-center mx-auto mb-4 text-lg">{{ $s['icon'] }}</span>
                    <b class="block font-serif-display text-2xl md:text-3xl text-slate-900 leading-none mb-1">{{ $s['value'] }}</b>
                    <span class="text-[10px] md:text-[11px] font-bold tracking-[0.12em] uppercase text-slate-600">{{ $s['label'] }}</span>
                </div>
                @endforeach
            </section>

            <!-- ========================================================= -->
            <!-- 4. STANDAR / NILAI                                        -->
            <!-- ========================================================= -->
            <section>
                <div class="text-center max-w-2xl mx-auto mb-12 scroll-anim">
                    <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[10px] font-extrabold tracking-[0.2em] uppercase text-sky-700 mb-5">
                        <span class="text-amber-500 text-xs">✦</span> Our principles
                    </span>
                    <h2 class="text-3xl md:text-5xl font-serif-display text-slate-900 mb-4">Explore Our <span class="italic text-sky-700">Standards.</span></h2>
                    <p class="text-slate-600">Three principles that guide everything we do.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="std-card lg lg-spot rounded-[2rem] p-8 text-center">
                        <span class="block font-serif-display italic text-sky-500 text-lg mb-3">01</span>
                        <div class="float-y lg lg-soft w-16 h-16 mx-auto text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Verified Quality</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Every seller and product is strictly vetted to ensure it meets our premium standards.</p>
                    </div>

                    <div class="std-card lg lg-spot rounded-[2rem] p-8 text-center">
                        <span class="block font-serif-display italic text-sky-500 text-lg mb-3">02</span>
                        <div class="float-y lg lg-soft w-16 h-16 mx-auto text-emerald-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Full Transparency</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Know exactly where your products come from, the materials used, and who made them.</p>
                    </div>

                    <div class="std-card lg lg-spot rounded-[2rem] p-8 text-center">
                        <span class="block font-serif-display italic text-amber-500 text-lg mb-3">03</span>
                        <div class="float-y lg lg-gold w-16 h-16 mx-auto rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Seamless Experience</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">From secure checkout to reliable delivery, we make your shopping experience effortless.</p>
                    </div>
                </div>
            </section>

            <!-- ========================================================= -->
            <!-- 5. HOW LOKA WORKS (timeline)                              -->
            <!-- ========================================================= -->
            <section class="scroll-anim">
                <div class="text-center max-w-2xl mx-auto mb-14">
                    <h2 class="text-3xl md:text-5xl font-serif-display text-slate-900 mb-4">How Loka <span class="italic text-sky-700">works.</span></h2>
                    <p class="text-slate-600">From the seller's hands to your door, in four simple steps.</p>
                </div>

                <div class="relative">
                    <div class="hidden md:block absolute top-9 left-[12%] right-[12%] border-t-2 border-dashed border-amber-400/70" id="tl-line" aria-hidden="true"></div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-6">
                        @foreach($steps as $i => $st)
                        <div class="relative text-center">
                            <span class="lg lg-gold relative z-10 w-[72px] h-[72px] rounded-full grid place-items-center mx-auto mb-5 font-serif-display text-2xl step-dot"><i class="about-ring" aria-hidden="true"></i>{{ $i + 1 }}</span>
                            <div class="step-card lg lg-soft lg-spot rounded-[1.75rem] p-5">
                                <h3 class="font-bold text-slate-900 mb-2">{{ $st['title'] }}</h3>
                                <p class="text-sm text-slate-600 leading-relaxed">{{ $st['text'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- ========================================================= -->
            <!-- 6. QUOTE BAND                                             -->
            <!-- ========================================================= -->
            <section class="lg lg-spot relative overflow-hidden rounded-[2.5rem] px-6 py-14 md:px-16 md:py-20 text-center scroll-anim">
                <span class="absolute -top-12 -right-10 w-64 h-64 rounded-full bg-amber-300/55 blur-3xl pointer-events-none" aria-hidden="true"></span>
                <span class="absolute -bottom-16 -left-10 w-64 h-64 rounded-full bg-sky-300/45 blur-3xl pointer-events-none" aria-hidden="true"></span>
                <span class="sparkle twinkle" style="top:14%;left:9%;font-size:26px" aria-hidden="true">✦</span>
                <span class="sparkle twinkle d2" style="bottom:18%;right:10%;font-size:34px" aria-hidden="true">✦</span>
                <span class="sparkle twinkle d3" style="top:20%;right:24%;font-size:14px" aria-hidden="true">✦</span>

                <p data-split class="relative text-2xl md:text-4xl font-serif-display italic text-slate-900 leading-[1.4] max-w-3xl mx-auto">
                    “Every item has a journey, and we bring that transparency <span class="text-sky-700">straight to you.</span>”
                </p>
                <p class="relative mt-6 text-[11px] font-extrabold tracking-[0.22em] uppercase text-amber-600">— The Loka Team</p>
            </section>

            <!-- ========================================================= -->
            <!-- 7. CALL TO ACTION                                         -->
            <!-- ========================================================= -->
            <section class="text-center scroll-anim">
                <h2 class="text-3xl md:text-4xl font-serif-display text-slate-900 mb-3">Ready to <span class="italic text-sky-700">explore?</span></h2>
                <p class="text-slate-600 mb-8">Find something exceptional, or say hello. We're happy to help.</p>
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('shop') }}" class="lg lg-gold lg-btn auto-shine inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full font-bold">
                        Explore The Collection &rarr;
                    </a>
                    <a href="{{ route('contact') }}" class="lg lg-soft lg-btn inline-flex items-center justify-center px-8 py-3.5 rounded-full font-bold text-slate-900">
                        Contact us
                    </a>
                </div>
            </section>

        </div>
    </div>
</main>
<script src="{{ asset('js/about.js') }}" defer></script>

@endsection