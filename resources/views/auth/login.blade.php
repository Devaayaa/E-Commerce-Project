@extends('layouts.app')

@section('title', 'Loka — Sign In')

@section('content')
@php
    $field = 'w-full bg-white/50 border border-white/70 rounded-2xl px-4 py-3 text-slate-900 placeholder-slate-500 outline-none focus:ring-2 focus:ring-sky-400/50 transition';
    $label = 'block text-xs font-bold tracking-wide uppercase text-slate-600 mb-1.5';
@endphp

{{-- transisi halaman halus (aman bila sudah ada di layout) --}}

<div class="sky" aria-hidden="true">
    <div class="cloud-pic" style="top:4%;left:-4%;--w:420px;--d:18s"></div>
    <div class="cloud-pic" style="top:22%;right:-3%;--w:520px;--d:22s;--dl:-6s"></div>
    <div class="cloud-pic" style="top:48%;left:-6%;--w:380px;--d:15s;--dl:-3s"></div>
    <div class="cloud-pic" style="top:66%;right:2%;--w:460px;--d:20s;--dl:-9s"></div>
    <div class="cloud-pic" style="top:84%;left:8%;--w:340px;--d:17s;--dl:-2s"></div>
</div>

<main class="relative z-10 min-h-screen flex items-center justify-center px-4 sm:px-6 py-12">
    <div class="relative w-full max-w-lg rounded-[3rem]">
        <div class="lg bg-white/10 absolute inset-0 rounded-[3rem] pointer-events-none" aria-hidden="true">
            <div class="pane-glow"><i class="g1"></i><i class="g2"></i><i class="g3"></i></div>
        </div>

        <div class="relative z-10 p-8 md:p-10">

            <div class="text-center mb-8">
                <a href="{{ url('/') }}" data-instant class="font-serif-display text-2xl text-slate-900">Loka</a>
                <h1 class="text-4xl md:text-5xl font-serif-display text-slate-900 mt-5 mb-3 leading-tight">
                    Welcome<br><span class="italic text-sky-700">Back.</span>
                </h1>
                <p class="text-slate-700 text-sm">Sign in to continue your curated experience.</p>
            </div>

            <x-flash />

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="{{ $label }}" for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" class="{{ $field }}" required>
                    @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="text-xs font-bold tracking-wide uppercase text-slate-600" for="password">Password</label>
                        <a href="#" class="text-xs font-semibold text-sky-700 hover:underline">Forgot?</a>
                    </div>
                    <div class="relative">
                        <input id="password" type="password" name="password" placeholder="••••••••" autocomplete="current-password" class="{{ $field }} pr-12" required>
                        <button type="button" data-toggle-pw aria-label="Show password" class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 grid place-items-center rounded-full text-slate-500 hover:text-slate-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>
                    </div>
                    @error('password')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <label for="remember" class="flex items-center gap-2 cursor-pointer w-fit">
                    <input type="checkbox" id="remember" name="remember" value="1" class="w-4 h-4 rounded accent-sky-600">
                    <span class="text-sm text-slate-700 font-medium">Remember me</span>
                </label>

                <button type="submit" class="lg lg-gold lg-btn w-full h-12 rounded-full text-sm font-bold">Sign In</button>
            </form>

            <div class="flex items-center gap-4 py-6">
                <div class="flex-1 border-t border-white/70"></div>
                <span class="text-slate-600 text-[11px] font-bold uppercase tracking-wider">Or continue with</span>
                <div class="flex-1 border-t border-white/70"></div>
            </div>

            <a href="{{ route('google.login') }}" class="lg lg-soft lg-btn w-full h-12 rounded-full text-sm font-bold text-slate-900 inline-flex items-center justify-center gap-3">
                <svg class="w-5 h-5" viewBox="0 0 24 24" aria-hidden="true">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
                Sign In with Google
            </a>

            <p class="text-center text-sm text-slate-700 mt-7 font-medium">
                Don’t have an account?
                <a href="{{ route('register') }}" data-instant class="font-bold text-sky-700 hover:underline">Sign Up</a>
            </p>

        </div>
    </div>
</main>
<script>
    // Tampilkan / sembunyikan password
    document.addEventListener('click', function (e) {
        var b = e.target.closest('[data-toggle-pw]'); if (!b) return;
        var i = b.parentElement.querySelector('input'), show = i.type === 'password';
        i.type = show ? 'text' : 'password';
        b.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
        b.classList.toggle('text-sky-700', show);
    });
</script>
@endsection