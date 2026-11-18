<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TokoKu')</title>
    
    <x-layout.css />
    @stack('styles')
</head>
<body class="min-h-screen text-slate-800">

    <!-- ========================================== -->
    <!-- 🌟 [PRELOADER] ANIMASI GURITA LIQUID SMOOTH-->
    <!-- ========================================== -->
    <div id="preloader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-gradient-to-br from-[#eaf6ff] via-white to-sky-200">
        
        <!-- Efek Awan Halus di Belakang -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-white/60 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-200/50 rounded-full blur-[100px]"></div>
        </div>

        <div class="relative z-10 flex flex-col items-center">
            
            <!-- SVG Gurita Elegan -->
            <svg viewBox="0 0 100 100" class="w-32 h-32 drop-shadow-2xl mb-6">
                <defs>
                    <clipPath id="octo-clip">
                        <path d="M50,10 C55,10 58,14 58,18 C70,22 80,34 80,50 C80,58 76,66 80,72 C84,78 76,84 70,82 C66,80 64,76 60,76 C56,76 56,84 50,84 C44,84 44,76 40,76 C36,76 34,80 30,82 C24,84 16,78 20,72 C24,66 20,58 20,50 C20,34 30,22 42,18 C42,14 45,10 50,10 Z" />
                    </clipPath>
                    <!-- Gradient Air Depan -->
                    <linearGradient id="water-grad-front" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#38bdf8" /> <!-- sky-400 -->
                        <stop offset="100%" stop-color="#0284c7" /> <!-- sky-600 -->
                    </linearGradient>
                    <!-- Gradient Air Belakang -->
                    <linearGradient id="water-grad-back" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#7dd3fc" /> <!-- sky-300 -->
                        <stop offset="100%" stop-color="#0ea5e9" /> <!-- sky-500 -->
                    </linearGradient>
                </defs>
                
                <!-- Outline Gurita -->
                <path d="M50,10 C55,10 58,14 58,18 C70,22 80,34 80,50 C80,58 76,66 80,72 C84,78 76,84 70,82 C66,80 64,76 60,76 C56,76 56,84 50,84 C44,84 44,76 40,76 C36,76 34,80 30,82 C24,84 16,78 20,72 C24,66 20,58 20,50 C20,34 30,22 42,18 C42,14 45,10 50,10 Z" 
                      fill="white" stroke="white" stroke-width="3" stroke-linejoin="round" />
                
                <!-- Area Air di Dalam Gurita -->
                <g clip-path="url(#octo-clip)">
                    <!-- Lapisan Belakang (Lebih terang, bergerak ke kanan) -->
                    <path id="liquid-back" d="M -800 50 Q -700 30 -600 50 T -400 50 T -200 50 T 0 50 T 200 50 T 400 50 T 600 50 T 800 50 L 800 200 L -800 200 Z" fill="url(#water-grad-back)" opacity="0.6" />
                    
                    <!-- Lapisan Depan (Lebih gelap, bergerak ke kiri) -->
                    <path id="liquid-front" d="M -800 50 Q -700 70 -600 50 T -400 50 T -200 50 T 0 50 T 200 50 T 400 50 T 600 50 T 800 50 L 800 200 L -800 200 Z" fill="url(#water-grad-front)" />
                </g>
            </svg>
            
            <!-- Teks Elegan -->
            <h1 class="text-4xl font-bold text-slate-900 mb-2" style="font-family: 'Playfair Display', serif;">
                Loka
            </h1>
            <p class="text-sky-600 text-xs font-bold tracking-[0.2em] uppercase">
                Curating Experience
            </p>
        </div>
    </div>

    <!-- Background Bersih -->
    <div class="bg-grid"></div>
    <div class="glow-orb orb-1"></div>
    <div class="glow-orb orb-2"></div>

    <!-- 🌟 HEADER (Disembunyikan di halaman Login & Register) -->
    @if(!request()->routeIs('login') && !request()->routeIs('register'))
        <x-layout.header />
    @endif

    <!-- Konten -->
    <main>
        @yield('content')
    </main>

    <!-- 🌟 FOOTER (Disembunyikan di halaman Login & Register) -->
    @if(!request()->routeIs('login') && !request()->routeIs('register'))
        <x-layout.footer />
    @endif
    
    <!-- Script JS -->
    <x-layout.js />
    @stack('scripts')
</body>
</html>