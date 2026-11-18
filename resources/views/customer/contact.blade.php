@extends('layouts.app')

@section('title', 'Loka — Contact Us')

@section('content')

<!-- ========================================================= -->
<!-- 🌟 [BACKGROUND FIXED] GAMBAR LANGIT                       -->
<!-- ========================================================= -->
<div class="fixed inset-0 bg-cover bg-center -z-10"
    style="background-image: url('https://images.unsplash.com/photo-1513002749550-c59d786b8e6c?q=80&w=2000&auto=format&fit=crop');"></div>

<!-- Wrapper Utama dengan Panel Kaca -->
<main class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 pt-32 pb-24">

    <!-- Panel Kaca Utama -->
    <div class="bg-white/30 backdrop-blur-[30px] border border-white/50 rounded-[3rem] p-8 md:p-16 shadow-[0_8px_32px_rgba(0,0,0,0.1)]">
        
        <!-- HEADER CONTACT -->
        <div class="text-center max-w-3xl mx-auto mb-16 scroll-anim">
            <h1 class="text-5xl md:text-7xl font-serif-display text-slate-900 mb-6 leading-tight drop-shadow-sm">
                Get in<br><span class="italic text-slate-700">Touch.</span>
            </h1>
            <p class="text-lg text-slate-800 leading-relaxed font-medium">
                Have a question, feedback, or need assistance? Our team is here to help you.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            
            <!-- KOLOM KIRI: FORM KONTAK -->
            <div class="scroll-anim bg-white/50 backdrop-blur-xl border border-white/70 p-8 rounded-[2rem] shadow-sm">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Send us a message</h2>
                
                <form action="#" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Full Name</label>
                        <input type="text" placeholder="Your name" class="w-full px-5 py-3.5 bg-white/60 border border-white/60 rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500/30 transition-all text-slate-900 placeholder-slate-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                        <input type="email" placeholder="you@example.com" class="w-full px-5 py-3.5 bg-white/60 border border-white/60 rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500/30 transition-all text-slate-900 placeholder-slate-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Message</label>
                        <textarea rows="4" placeholder="How can we help you?" class="w-full px-5 py-3.5 bg-white/60 border border-white/60 rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500/30 transition-all text-slate-900 placeholder-slate-500" required></textarea>
                    </div>

                    <button type="submit" class="w-full py-4 bg-slate-900 text-white font-bold rounded-xl hover:bg-blue-600 transition-all duration-300 shadow-lg hover:-translate-y-0.5">
                        Send Message
                    </button>
                </form>
            </div>

            <!-- KOLOM KANAN: INFO KONTAK -->
            <div class="space-y-6 scroll-anim">
                <!-- Email -->
                <div class="bg-white/50 backdrop-blur-xl border border-white/70 p-6 rounded-[2rem] flex items-start gap-4 hover:bg-white/70 transition-colors">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Email Us</h3>
                        <p class="text-slate-600 text-sm mb-1">Our team will respond within 24 hours.</p>
                        <a href="mailto:hello@loka.com" class="text-blue-600 font-bold hover:underline">hello@loka.com</a>
                    </div>
                </div>

                <!-- Phone -->
                <div class="bg-white/50 backdrop-blur-xl border border-white/70 p-6 rounded-[2rem] flex items-start gap-4 hover:bg-white/70 transition-colors">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Call Us</h3>
                        <p class="text-slate-600 text-sm mb-1">Mon-Fri from 8am to 5pm.</p>
                        <a href="tel:+628123456789" class="text-blue-600 font-bold hover:underline">+62 812 3456 789</a>
                    </div>
                </div>

                <!-- Location -->
                <div class="bg-white/50 backdrop-blur-xl border border-white/70 p-6 rounded-[2rem] flex items-start gap-4 hover:bg-white/70 transition-colors">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Visit Us</h3>
                        <p class="text-slate-600 text-sm mb-1">Come say hello at our office.</p>
                        <p class="text-slate-800 font-medium">Sudirman Central Business District,<br>Jakarta, Indonesia</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</main>
@endsection