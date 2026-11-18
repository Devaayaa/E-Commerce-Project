@php
$cart = session()->get('cart', []);
$cartCount = count($cart) > 0 ? array_sum(array_column($cart, 'quantity')) : 0;
@endphp

<!-- Header dipersempit ke max-w-3xl -->
<nav id="main-header" class="fixed top-6 z-50 w-[95%] max-w-3xl" style="left: 50%; transform: translateX(-50%);">
    <div class="bg-white/80 backdrop-blur-xl border border-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex items-center justify-between px-5 py-2.5 rounded-full">

        <!-- LOGO -->
        <a href="{{ url('/') }}" class="text-lg font-bold tracking-tight text-slate-900 shrink-0" style="font-family: 'Playfair Display', serif;">
            Loka
        </a>

        <!-- MENU (Padding dirapatkan) -->
        <div id="nav-menu" class="hidden md:flex items-center gap-0.5">
            <a href="{{ url('/') }}" class="px-3 py-1.5 text-[12px] font-semibold {{ request()->is('/') ? 'text-slate-900' : 'text-slate-500 hover:text-slate-900' }}">Home</a>
            <a href="{{ route('shop') }}" class="px-3 py-1.5 text-[12px] font-semibold {{ request()->is('produk*') ? 'text-slate-900' : 'text-slate-500 hover:text-slate-900' }}">Shop</a>
            <a href="{{ route('categories') }}" class="px-3 py-1.5 text-[12px] font-semibold {{ request()->is('kategori') ? 'text-slate-900' : 'text-slate-500 hover:text-slate-900' }}">Categories</a>
            <a href="{{ route('about') }}" class="px-3 py-1.5 text-[12px] font-semibold {{ request()->is('tentang') ? 'text-slate-900' : 'text-slate-500 hover:text-slate-900' }}">About</a>
            <a href="{{ route('contact') }}" class="px-3 py-1.5 text-[12px] font-semibold {{ request()->is('kontak') ? 'text-slate-900' : 'text-slate-500 hover:text-slate-900' }}">Contact</a>
        </div>

        <!-- IKON KANAN -->
        <div id="header-right" class="flex items-center gap-3 shrink-0">
            
            <!-- 🌟 LOGIKA AUTENTIKASI -->
            @auth
                <!-- Jika Sudah Login: Tampilkan Tombol Logout -->
                <form action="{{ route('logout') }}" method="POST" class="hidden sm:block m-0">
                    @csrf
                    <button type="submit" class="flex items-center gap-1.5 px-4 py-1.5 bg-red-50 text-red-600 text-[11px] font-bold rounded-full hover:bg-red-100 hover:text-red-700 transition-all duration-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            @else
                <!-- Jika Belum Login: Tampilkan Tombol Sign In -->
                <a href="{{ route('login') }}" class="hidden sm:flex items-center gap-1.5 px-4 py-1.5 bg-slate-900 text-white text-[11px] font-bold rounded-full hover:bg-blue-600 transition-all duration-300 hover:-translate-y-0.5 shadow-md shadow-slate-900/20">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Sign In
                </a>
            @endauth

            <!-- CART ICON -->
            <a href="{{ route('cart.index') }}" class="relative text-slate-900 hover:text-blue-600 group">
                <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                @if($cartCount > 0)
                <span class="absolute -top-1.5 -right-2 inline-flex items-center justify-center px-1 py-0.5 text-[9px] font-bold text-white bg-blue-600 rounded-full">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </div>
</nav>

<!-- FLOATING CART (Saat Scroll) -->
<div id="floating-cart" class="fixed top-6 right-6 z-50 opacity-0 pointer-events-none hidden md:block" style="transform: translateY(-20px);">
    <a href="{{ route('cart.index') }}" class="bg-white/90 backdrop-blur-md border border-white flex items-center gap-3 px-4 py-2.5 rounded-2xl shadow-xl hover:bg-white transition-colors group">
        <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center text-slate-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
        </div>
        <div>
            <p class="text-[10px] text-slate-500 font-semibold mb-0.5">Your Cart</p>
            <p class="text-xs font-bold text-slate-900">{{ $cartCount }} Items</p>
        </div>
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof gsap !== 'undefined') {
            const header = document.getElementById('main-header');
            const navMenu = document.getElementById('nav-menu');
            const headerRight = document.getElementById('header-right');
            const floatingCart = document.getElementById('floating-cart');

            // 1. Mencegah teks turun baris saat ukurannya mengecil
            gsap.set([navMenu, headerRight], {
                whiteSpace: "nowrap"
            });
            // 2. Memastikan sudut kapsul tetap rapi saat menyusut
            gsap.set(header.querySelector('div'), {
                overflow: "hidden"
            });

            // Posisi awal header (Tengah)
            gsap.set(header, {
                left: '50%',
                xPercent: -50,
                width: '95%',
                maxWidth: '768px'
            });

            let isScrolled = false;

            window.addEventListener('scroll', () => {
                if (window.scrollY > 80 && !isScrolled) {
                    isScrolled = true;

                    // --- TIMELINE SAAT SCROLL KE BAWAH ---
                    const tlDown = gsap.timeline();

                    // 1. Menu & Ikon memudar dan mengecil secara perlahan (tanpa display: none)
                    tlDown.to([navMenu, headerRight], {
                        opacity: 0,
                        width: 0,
                        paddingLeft: 0,
                        paddingRight: 0,
                        duration: 0.5,
                        ease: "power3.inOut"
                    }, 0);

                    // 2. Header meluncur ke kiri atas & menyusut hanya menyisakan Logo
                    tlDown.to(header, {
                        left: '24px',
                        top: '16px',
                        xPercent: 0,
                        width: 'auto',
                        maxWidth: '120px', // Lebar pas untuk logo Loka
                        duration: 0.7,
                        ease: 'expo.out' // Kurva animasi paling smooth
                    }, 0);

                    // 3. Floating Cart muncul
                    tlDown.to(floatingCart, {
                        opacity: 1,
                        y: 0,
                        pointerEvents: 'auto',
                        duration: 0.5,
                        delay: 0.2,
                        ease: "power2.out"
                    }, 0);

                } else if (window.scrollY <= 80 && isScrolled) {
                    isScrolled = false;

                    // --- TIMELINE SAAT SCROLL KE ATAS ---
                    const tlUp = gsap.timeline();

                    // 1. Header kembali ke tengah
                    tlUp.to(header, {
                        left: '50%',
                        top: '24px',
                        xPercent: -50,
                        width: '95%',
                        maxWidth: '768px',
                        duration: 0.7,
                        ease: 'expo.out'
                    }, 0);

                    // 2. Menu & Ikon kembali muncul (clearProps mereset agar presisi seperti awal)
                    tlUp.to([navMenu, headerRight], {
                        opacity: 1,
                        width: 'auto',
                        paddingLeft: '',
                        paddingRight: '',
                        duration: 0.5,
                        ease: "power3.inOut",
                        clearProps: "opacity,width,paddingLeft,paddingRight"
                    }, 0.1);

                    // 3. Floating Cart memudar ke atas
                    tlUp.to(floatingCart, {
                        opacity: 0,
                        y: -20,
                        pointerEvents: 'none',
                        duration: 0.4,
                        ease: "power2.in"
                    }, 0);
                }
            });
        }
    });
</script>