@extends('layouts.app')

@section('title', 'Loka — Sign Up')

@section('content')

<!-- ========================================================= -->
<!-- 🌟 [BACKGROUND FIXED] GAMBAR LANGIT                       -->
<!-- ========================================================= -->
<div class="fixed inset-0 bg-cover bg-center -z-10"
    style="background-image: url('https://images.unsplash.com/photo-1513002749550-c59d786b8e6c?q=80&w=2000&auto=format&fit=crop');"></div>

<main class="relative z-10 min-h-screen flex items-center justify-center px-4 sm:px-6 pt-28 pb-12">
    
    <!-- 🌟 Panel Kaca Form (Diperlebar menjadi max-w-lg) -->
    <div class="w-full max-w-lg bg-white/30 backdrop-blur-[30px] border border-white/50 rounded-[3rem] p-8 md:p-10 shadow-[0_8px_32px_rgba(0,0,0,0.1)] scroll-anim">
        
        <div class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-serif-display text-slate-900 mb-3 leading-tight drop-shadow-sm">
                Join<br><span class="italic text-slate-700">Loka.</span>
            </h1>
            <p class="text-slate-800 text-sm">Create an account to discover exceptional items.</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Full Name</label>
                <input type="text" name="name" placeholder="Your name" class="w-full px-5 py-3.5 bg-white/60 border border-white/60 rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500/30 transition-all text-slate-900 placeholder-slate-500" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                <input type="email" name="email" placeholder="you@example.com" class="w-full px-5 py-3.5 bg-white/60 border border-white/60 rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500/30 transition-all text-slate-900 placeholder-slate-500" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                <input type="password" name="password" placeholder="Create a strong password" class="w-full px-5 py-3.5 bg-white/60 border border-white/60 rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500/30 transition-all text-slate-900 placeholder-slate-500" required>
            </div>

            <button type="submit" class="w-full py-4 bg-slate-900 text-white font-bold rounded-xl hover:bg-blue-600 transition-all duration-300 shadow-lg hover:-translate-y-0.5 mt-4">
                Create Account
            </button>
        </form>

        <p class="text-center text-sm text-slate-700 mt-6 font-medium">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:underline">Sign In</a>
        </p>

    </div>
</main>
@endsection