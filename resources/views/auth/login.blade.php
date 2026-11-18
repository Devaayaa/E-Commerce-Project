@extends('layouts.app')

@section('title', 'Loka — Sign In')

@section('content')

<!-- ========================================================= -->
<!-- 🌟 [BACKGROUND FIXED] GAMBAR LANGIT                       -->
<!-- ========================================================= -->
<div class="fixed inset-0 bg-cover bg-center -z-10"
    style="background-image: url('https://images.unsplash.com/photo-1513002749550-c59d786b8e6c?q=80&w=2000&auto=format&fit=crop');"></div>

<main class="relative z-10 min-h-screen flex items-center justify-center px-4 sm:px-6 pt-24 pb-12">
    
    <!-- 🌟 Panel Kaca Form (Diperlebar menjadi max-w-lg) -->
    <div class="w-full max-w-lg bg-white/30 backdrop-blur-[30px] border border-white/50 rounded-[3rem] p-8 md:p-10 shadow-[0_8px_32px_rgba(0,0,0,0.1)] scroll-anim">
        
        <div class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-serif-display text-slate-900 mb-3 leading-tight drop-shadow-sm">
                Welcome<br><span class="italic text-slate-700">Back.</span>
            </h1>
            <p class="text-slate-800 text-sm">Sign in to continue your curated experience.</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                <input type="email" name="email" placeholder="you@example.com" class="w-full px-5 py-3.5 bg-white/60 border border-white/60 rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500/30 transition-all text-slate-900 placeholder-slate-500" required>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-bold text-slate-700">Password</label>
                    <a href="#" class="text-xs font-semibold text-blue-600 hover:underline">Forgot?</a>
                </div>
                <input type="password" name="password" placeholder="••••••••" class="w-full px-5 py-3.5 bg-white/60 border border-white/60 rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500/30 transition-all text-slate-900 placeholder-slate-500" required>
            </div>

            <div class="flex items-center gap-2 mt-2">
                <input type="checkbox" id="remember" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 bg-white/50">
                <label for="remember" class="text-sm text-slate-700 font-medium cursor-pointer">Remember me</label>
            </div>

            <button type="submit" class="w-full py-4 bg-slate-900 text-white font-bold rounded-xl hover:bg-blue-600 transition-all duration-300 shadow-lg hover:-translate-y-0.5 mt-2">
                Sign In
            </button>
        </form>

        <!-- PEMISAH -->
        <div class="relative flex items-center py-6">
            <div class="flex-grow border-t border-slate-400/30"></div>
            <span class="flex-shrink-0 mx-4 text-slate-600 text-xs font-semibold uppercase tracking-wider">Or continue with</span>
            <div class="flex-grow border-t border-slate-400/30"></div>
        </div>

        <!-- TOMBOL GOOGLE -->
        <a href="{{ route('google.login') }}" class="w-full py-3.5 bg-white/80 backdrop-blur-md text-slate-900 font-bold rounded-xl hover:bg-white transition-all duration-300 shadow-sm hover:-translate-y-0.5 flex items-center justify-center gap-3 border border-white/60">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Sign In with Google
        </a>

        <p class="text-center text-sm text-slate-700 mt-8 font-medium">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline">Sign Up</a>
        </p>

    </div>
</main>
@endsection