<!-- Header Melayang (Floating) - Lebar Pas, Tinggi Ramping -->
<nav class="fixed top-5 left-1/2 -translate-x-1/2 w-[95%] max-w-7xl z-50">
    <!-- Container Kaca Kebiruan (Padding dikurangi) -->
    <div class="header-glass-blue flex items-center justify-between px-6 py-2 rounded-full shadow-lg">
        
        <!-- 1. LOGO KIRI (Diperkecil) -->
        <a href="{{ url('/') }}" class="flex items-center gap-2.5">
            <!-- Ikon Bulat -->
            <div class="w-8 h-8 rounded-full border-2 border-slate-800 flex items-center justify-center">
                <svg class="w-4 h-4 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            </div>
            <!-- Teks Logo -->
            <span class="text-xl font-bold text-slate-900 tracking-tight" style="font-family: 'Georgia', serif;">TokoKu</span>
        </a>
        
        <!-- 2. MENU TENGAH -->
        <div class="hidden md:flex items-center gap-1 bg-black/5 px-2 py-1 rounded-full border border-white/40">
            
            <!-- Beranda -->
            <a href="{{ url('/') }}" 
               class="px-5 py-1.5 rounded-full text-[13px] font-semibold transition-all duration-300 
               {{ request()->is('/') ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }}">
                Beranda
            </a>
            
            <!-- Produk -->
            <a href="{{ route('products') }}" 
               class="px-5 py-1.5 rounded-full text-[13px] font-semibold transition-all duration-300 
               {{ request()->is('produk*') ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }}">
                Produk
            </a>
            
            <!-- Lacak Pesanan -->
            <a href="{{ url('/lacak/ORD-123') }}" 
               class="px-5 py-1.5 rounded-full text-[13px] font-semibold transition-all duration-300 
               {{ request()->is('lacak*') ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }}">
                Lacak Pesanan
            </a>
        </div>
        
        <!-- 3. TOMBOL KANAN (Masuk & Daftar Dirampingkan) -->
        <div class="flex items-center gap-3">
            <!-- Masuk -->
            <a href="#" class="text-[13px] font-bold text-slate-700 hover:text-blue-600 transition px-2 py-1">Masuk</a>
            
            <!-- Tombol Daftar -->
            <button class="px-5 py-2 bg-slate-900 text-white text-[13px] font-bold rounded-full hover:bg-black transition-all duration-300 shadow-md">
                Daftar
            </button>
        </div>
        
    </div>
</nav>