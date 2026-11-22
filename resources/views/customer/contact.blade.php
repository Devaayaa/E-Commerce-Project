@extends('layouts.app')

@section('title', 'Loka — Contact Us')

@section('content')

{{-- Styling: public/css/contact.css | Script: public/js/contact.js --}}
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">

<!-- ☁️ BACKGROUND — sama dengan Home, Shop & About -->
<div class="sky" aria-hidden="true">
    <div class="cloud-pic" style="top:4%;left:-4%;--w:420px;--d:18s"></div>
    <div class="cloud-pic" style="top:22%;right:-3%;--w:520px;--d:22s;--dl:-6s"></div>
    <div class="cloud-pic" style="top:48%;left:-6%;--w:380px;--d:15s;--dl:-3s"></div>
    <div class="cloud-pic" style="top:66%;right:2%;--w:460px;--d:20s;--dl:-9s"></div>
    <div class="cloud-pic" style="top:84%;left:8%;--w:340px;--d:17s;--dl:-2s"></div>
</div>

<main id="contact-top" class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 pt-36 pb-24">

    <!-- 🪟 PANE LIQUID GLASS UTAMA (lapisan kaca terpisah + glow kuning) -->
    <div class="relative rounded-[3rem]">
        <div class="lg bg-white/10 absolute inset-0 rounded-[3rem] pointer-events-none" aria-hidden="true">
            <div class="pane-glow"><i class="g1"></i><i class="g2"></i><i class="g3"></i></div>
        </div>
        <div class="absolute inset-0 overflow-hidden rounded-[3rem] pointer-events-none" aria-hidden="true">
            <span class="rise" style="left:6%;top:8%;--s:14px;--d:9s;--dl:-1s">✦</span>
            <span class="rise" style="left:90%;top:14%;--s:18px;--d:11s;--dl:-4s">✦</span>
            <span class="rise" style="left:12%;top:26%;--s:10px;--d:8s;--dl:-3s">✦</span>
            <span class="rise" style="left:84%;top:38%;--s:12px;--d:10s;--dl:-6s">✦</span>
            <span class="rise" style="left:5%;top:50%;--s:16px;--d:12s;--dl:-2s">✦</span>
            <span class="rise" style="left:92%;top:60%;--s:10px;--d:9s;--dl:-5s">✦</span>
            <span class="rise" style="left:14%;top:72%;--s:18px;--d:11s;--dl:-7s">✦</span>
            <span class="rise" style="left:80%;top:80%;--s:12px;--d:8s;--dl:-1s">✦</span>
            <span class="rise" style="left:8%;top:90%;--s:12px;--d:10s;--dl:-4s">✦</span>
            <span class="rise" style="left:88%;top:94%;--s:16px;--d:12s;--dl:-8s">✦</span>
        </div>

        <div class="relative z-10 p-5 sm:p-8 lg:p-12 space-y-20 md:space-y-28">

            <!-- ========================================================= -->
            <!-- 1. HEADER (+ status online real-time)                     -->
            <!-- ========================================================= -->
            <section class="about-head relative text-center max-w-3xl mx-auto scroll-anim">
                <span class="sparkle twinkle hidden sm:block" style="top:28%;left:6%;font-size:30px" aria-hidden="true">✦</span>
                <span class="sparkle twinkle d2 hidden sm:block" style="top:8%;right:10%;font-size:18px" aria-hidden="true">✦</span>
                <span class="sparkle twinkle d3 hidden sm:block" style="top:62%;right:4%;font-size:12px" aria-hidden="true">✦</span>

                <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-2 rounded-full text-[10px] font-extrabold tracking-[0.2em] uppercase text-sky-800 mb-6">
                    <span class="text-amber-500 text-xs">✦</span> Contact Loka
                </span>
                <h1 class="text-5xl md:text-7xl font-serif-display text-slate-900 mb-6 leading-[1.15]">
                    Let’s Start<br><span class="italic text-sky-700 text-shimmer">a Conversation.</span>
                </h1>
                <p class="text-lg text-slate-700 leading-relaxed font-medium">
                    Have a question, feedback, or need a hand? Our team is here, and we’re happy to help.
                </p>
                <div class="flex flex-wrap justify-center gap-2 mt-7">
                    <span id="office-status" class="lg lg-soft inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold text-slate-700">
                        <i class="live-dot" aria-hidden="true"></i><span data-status-text>Checking availability…</span>
                    </span>
                    <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold text-slate-700"><span class="text-amber-500">✦</span> Replies within 24h</span>
                    <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold text-slate-700"><span class="text-amber-500">★</span> Real humans</span>
                </div>
            </section>

            <!-- ========================================================= -->
            <!-- 2. KANAL KONTAK (jelly + riak air, copy sekali klik)      -->
            <!-- ========================================================= -->
            <section class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 scroll-anim">
                <!-- Email -->
                <div class="about-stat lg lg-soft lg-spot rounded-[2rem] p-6 md:p-7 text-center">
                    <span class="lg lg-gold w-12 h-12 rounded-full grid place-items-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </span>
                    <h3 class="font-serif-display text-2xl text-slate-900 mb-1">Email us</h3>
                    <p class="text-sm text-slate-600 mb-3">Our team replies within 24 hours.</p>
                    <a href="mailto:hello@loka.com" class="block text-sky-700 font-bold hover:underline break-all">hello@loka.com</a>
                    <button type="button" data-copy="hello@loka.com" class="copy-btn lg lg-soft"><span class="copy-label">Copy</span></button>
                </div>

                <!-- Phone -->
                <div class="about-stat lg lg-soft lg-spot rounded-[2rem] p-6 md:p-7 text-center">
                    <span class="lg lg-gold w-12 h-12 rounded-full grid place-items-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </span>
                    <h3 class="font-serif-display text-2xl text-slate-900 mb-1">Call us</h3>
                    <p class="text-sm text-slate-600 mb-3">Mon–Fri from 8am to 5pm.</p>
                    <a href="tel:+628123456789" class="block text-sky-700 font-bold hover:underline">+62 812 3456 789</a>
                    <button type="button" data-copy="+62 812 3456 789" class="copy-btn lg lg-soft"><span class="copy-label">Copy</span></button>
                </div>

                <!-- Location -->
                <div class="about-stat lg lg-soft lg-spot rounded-[2rem] p-6 md:p-7 text-center">
                    <span class="lg lg-gold w-12 h-12 rounded-full grid place-items-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </span>
                    <h3 class="font-serif-display text-2xl text-slate-900 mb-1">Visit us</h3>
                    <p class="text-sm text-slate-600 mb-3">Come say hello at our office.</p>
                    <a href="https://www.google.com/maps/search/?api=1&query=0.5626183,101.4267777" target="_blank" rel="noopener" class="block text-sky-700 font-bold hover:underline">Pekanbaru,<br>Riau, Indonesia</a>
                    <button type="button" data-copy="Pekanbaru, Riau, Indonesia" class="copy-btn lg lg-soft"><span class="copy-label">Copy</span></button>
                </div>
            </section>

            <!-- ========================================================= -->
            <!-- 4. FORM INTERAKTIF + JAM OPERASIONAL + PETA               -->
            <!-- ========================================================= -->
            <section class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-10 items-start">

                <!-- FORM -->
                <div class="lg:col-span-3 scroll-anim">
                    <div id="contact-card" class="contact-card lg lg-spot rounded-[2.5rem] p-6 sm:p-8 md:p-10 relative overflow-hidden">
                        <span class="absolute -top-12 -right-10 w-56 h-56 rounded-full bg-amber-300/50 blur-3xl pointer-events-none" aria-hidden="true"></span>
                        <span class="absolute -bottom-16 -left-10 w-56 h-56 rounded-full bg-sky-300/45 blur-3xl pointer-events-none" aria-hidden="true"></span>

                        <form id="contact-form" class="contact-form relative space-y-6" action="#" method="POST">
                            @csrf
                            <div data-in>
                                <span class="block h-1 w-14 rounded-full bg-gradient-to-r from-amber-300 to-amber-500 mb-5"></span>
                                <h2 class="text-3xl md:text-4xl font-serif-display text-slate-900 leading-[1.25] mb-2">
                                    Send us <span class="italic text-sky-700">a message.</span>
                                </h2>
                                <p class="text-slate-600">Pick a topic, tell us a little, and we’ll take it from there.</p>
                            </div>

                            <fieldset data-in>
                                <legend class="text-[10px] font-extrabold tracking-[0.2em] uppercase text-slate-600 mb-3">What’s it about?</legend>
                                <div class="flex flex-wrap gap-2">
                                    <label class="topic-chip"><input type="radio" name="topic" value="General" class="sr-only" data-hint="How can we help you?" checked><span class="lg lg-soft">💬 General</span></label>
                                    <label class="topic-chip"><input type="radio" name="topic" value="Order help" class="sr-only" data-hint="Share your order number and what happened"><span class="lg lg-soft">📦 Order help</span></label>
                                    <label class="topic-chip"><input type="radio" name="topic" value="Become a seller" class="sr-only" data-hint="Tell us about you and what you’d like to sell"><span class="lg lg-soft">🏪 Become a seller</span></label>
                                    <label class="topic-chip"><input type="radio" name="topic" value="Feedback" class="sr-only" data-hint="What’s on your mind? We’re listening"><span class="lg lg-soft">💡 Feedback</span></label>
                                </div>
                            </fieldset>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" data-in>
                                <div class="field">
                                    <input type="text" id="c-name" name="name" placeholder=" " autocomplete="name" required>
                                    <label for="c-name">Full name</label>
                                </div>
                                <div class="field">
                                    <input type="email" id="c-email" name="email" placeholder=" " autocomplete="email" required>
                                    <label for="c-email">Email address</label>
                                </div>
                            </div>

                            <div class="field" data-in>
                                <textarea id="msg" name="message" rows="5" maxlength="500" placeholder=" " required></textarea>
                                <label id="msg-label" for="msg">How can we help you?</label>
                                <span id="msg-count" class="msg-count absolute right-4 bottom-3">0 / 500</span>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-in>
                                <p class="text-xs text-slate-500 flex items-center gap-2"><span class="text-amber-500">✦</span> We’ll never share your email.</p>
                                <button type="submit" id="send-btn" class="send-btn contact-shine lg lg-gold lg-btn inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full font-bold w-full sm:w-auto">
                                    <span class="btn-label">Send Message</span>
                                    <svg class="plane w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                                </button>
                            </div>
                        </form>

                        <!-- Tampilan sukses -->
                        <div id="form-success" class="form-success" role="status" aria-live="polite" aria-hidden="true">
                            <span class="success-check lg lg-gold" aria-hidden="true">✓</span>
                            <h3 class="font-serif-display text-3xl md:text-4xl text-slate-900 mb-3">Message <span class="italic text-sky-700">sent!</span></h3>
                            <p class="text-slate-600 max-w-sm mb-7">Thank you for reaching out. We’ll reply to your email within 24 hours.</p>
                            <button type="button" id="send-again" class="lg lg-soft lg-btn inline-flex items-center justify-center px-7 py-3 rounded-full font-bold text-slate-900">Send another message</button>
                        </div>
                    </div>
                </div>

                <!-- SISI KANAN -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Jam operasional -->
                    <div class="lg lg-soft lg-spot rounded-[2rem] p-6 scroll-anim">
                        <div class="flex items-center justify-between gap-3 mb-5">
                            <h3 class="font-serif-display text-2xl text-slate-900">Office hours</h3>
                            <span id="office-badge" class="office-badge lg lg-soft"><i class="live-dot" aria-hidden="true"></i><span data-badge-text>…</span></span>
                        </div>
                        <div id="week-days" class="flex justify-between gap-1.5" aria-hidden="true">
                            <span class="day" data-d="1">M</span>
                            <span class="day" data-d="2">T</span>
                            <span class="day" data-d="3">W</span>
                            <span class="day" data-d="4">T</span>
                            <span class="day" data-d="5">F</span>
                            <span class="day" data-d="6">S</span>
                            <span class="day" data-d="0">S</span>
                        </div>
                        <p id="office-detail" class="mt-5 text-sm text-slate-600">Mon–Fri, 8:00 AM – 5:00 PM WIB</p>
                    </div>

                    <!-- Peta -->
                    <div class="relative scroll-anim">
                        <span class="absolute -top-6 -right-4 w-40 h-40 rounded-full bg-amber-300/50 blur-3xl pointer-events-none" aria-hidden="true"></span>
                        <div class="lg rounded-[2.5rem] p-3 relative">
                            <div id="contact-map" class="contact-map h-[320px] rounded-[2rem] overflow-hidden" role="img" aria-label="Map showing the Loka office in Pekanbaru"></div>
                        </div>
                        <span class="float-y lg lg-gold absolute -top-4 left-6 px-4 py-2 rounded-full text-xs font-bold -rotate-3 z-10">✦ Our office</span>
                        <a href="https://www.google.com/maps/search/?api=1&query=0.5626183,101.4267777" target="_blank" rel="noopener" class="float-y lg lg-soft absolute -bottom-5 right-6 rounded-2xl px-4 py-3 flex items-center gap-3 z-10" style="animation-delay:-1.8s">
                            <span class="lg-blue lg w-9 h-9 rounded-full grid place-items-center text-sm">➜</span>
                            <span class="leading-tight">
                                <span class="block text-sm font-bold text-slate-900">Open in Maps</span>
                                <span class="block text-[11px] text-slate-600">Get directions</span>
                            </span>
                        </a>
                    </div>
                </div>
            </section>

            <!-- ========================================================= -->
            <!-- 5. FAQ CEPAT                                              -->
            <!-- ========================================================= -->
            <section>
                <div class="text-center max-w-2xl mx-auto mb-12 scroll-anim">
                    <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[10px] font-extrabold tracking-[0.2em] uppercase text-sky-700 mb-5">
                        <span class="text-amber-500 text-xs">✦</span> Quick answers
                    </span>
                    <h2 class="text-3xl md:text-5xl font-serif-display text-slate-900 mb-4">Before you <span class="italic text-sky-700">ask.</span></h2>
                    <p class="text-slate-600">The questions we hear the most.</p>
                </div>

                <div id="faq-list" class="space-y-4 max-w-3xl mx-auto">
                    <div class="faq-item lg lg-soft">
                        <button type="button" class="faq-btn" aria-expanded="false" onclick="toggleFaq(this)">
                            <span class="faq-num">01</span><span class="faq-q">How fast will you reply?</span><span class="faq-icon" aria-hidden="true"></span>
                        </button>
                        <div class="faq-panel"><div class="faq-body">We reply to every message within 24 hours on business days. Messages sent on weekends are answered first thing on Monday.</div></div>
                    </div>
                    <div class="faq-item lg lg-soft">
                        <button type="button" class="faq-btn" aria-expanded="false" onclick="toggleFaq(this)">
                            <span class="faq-num">02</span><span class="faq-q">I have a question about my order.</span><span class="faq-icon" aria-hidden="true"></span>
                        </button>
                        <div class="faq-panel"><div class="faq-body">Choose “Order help” above and include your order number. It lets us find your order and get back to you faster.</div></div>
                    </div>
                    <div class="faq-item lg lg-soft">
                        <button type="button" class="faq-btn" aria-expanded="false" onclick="toggleFaq(this)">
                            <span class="faq-num">03</span><span class="faq-q">How do I become a Loka seller?</span><span class="faq-icon" aria-hidden="true"></span>
                        </button>
                        <div class="faq-panel"><div class="faq-body">Choose “Become a seller” and tell us a bit about you and your products. Our team will get back to you with the next steps.</div></div>
                    </div>
                    <div class="faq-item lg lg-soft">
                        <button type="button" class="faq-btn" aria-expanded="false" onclick="toggleFaq(this)">
                            <span class="faq-num">04</span><span class="faq-q">Can I change or cancel an order?</span><span class="faq-icon" aria-hidden="true"></span>
                        </button>
                        <div class="faq-panel"><div class="faq-body">Message us as soon as possible with your order number and we’ll do our best to help before it ships.</div></div>
                    </div>
                </div>
            </section>

            <!-- ========================================================= -->
            <!-- 6. QUOTE + CTA                                            -->
            <!-- ========================================================= -->
            <section class="lg lg-spot relative overflow-hidden rounded-[2.5rem] px-6 py-14 md:px-16 md:py-20 text-center scroll-anim">
                <span class="absolute -top-12 -right-10 w-64 h-64 rounded-full bg-amber-300/55 blur-3xl pointer-events-none" aria-hidden="true"></span>
                <span class="absolute -bottom-16 -left-10 w-64 h-64 rounded-full bg-sky-300/45 blur-3xl pointer-events-none" aria-hidden="true"></span>
                <span class="sparkle twinkle" style="top:14%;left:9%;font-size:26px" aria-hidden="true">✦</span>
                <span class="sparkle twinkle d2" style="bottom:18%;right:10%;font-size:34px" aria-hidden="true">✦</span>
                <span class="sparkle twinkle d3" style="top:20%;right:24%;font-size:14px" aria-hidden="true">✦</span>

                <p data-split class="relative text-2xl md:text-4xl font-serif-display italic text-slate-900 leading-[1.4] max-w-3xl mx-auto">
                    “Every great find begins with a <span class="text-sky-700">friendly conversation.</span>”
                </p>
                <p class="relative mt-6 text-[11px] font-extrabold tracking-[0.22em] uppercase text-amber-600">— The Loka Team</p>

                <div class="relative flex flex-wrap justify-center gap-3 mt-10">
                    <a href="{{ route('shop') }}" class="lg lg-gold lg-btn auto-shine inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full font-bold">
                        Explore The Collection &rarr;
                    </a>
                    <a href="#contact-top" data-top class="lg lg-soft lg-btn inline-flex items-center justify-center px-8 py-3.5 rounded-full font-bold text-slate-900">
                        Back to top ↑
                    </a>
                </div>
            </section>

        </div>
    </div>
</main>
<script src="{{ asset('js/contact.js') }}" defer></script>

@endsection