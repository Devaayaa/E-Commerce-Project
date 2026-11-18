<!-- ========================================== -->
<!-- WRAPPER BACKGROUND PUTIH                   -->
<!-- ========================================== -->
<!-- Background putih bersih -->
<div class="relative w-full bg-white py-10 px-4 md:px-8">
    
    <!-- ========================================== -->
    <!-- PANEL FOOTER (PUTIH, KECIL, & RINGKAS)     -->
    <!-- ========================================== -->
    <!-- max-w-3xl = Membatasi lebar agar tidak memanjang -->
    <!-- p-6 md:p-8 = Padding kecil agar kotak tidak tinggi -->
    <footer class="relative z-10 max-w-3xl mx-auto bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm">
        
        <!-- Konten Atas: Logo & Menu -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-6">
            
            <!-- KIRI: Logo & Tagline -->
            <div>
                <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight text-slate-900 mb-1.5 block" style="font-family: 'Playfair Display', serif;">
                    Loka
                </a>
                <p class="text-slate-500 text-xs leading-relaxed">
                    Curated collections.<br>Quality you can trace.
                </p>
            </div>

            <!-- KANAN: Tautan Shop (Menyamping) -->
            <div>
                <h4 class="font-bold text-slate-900 mb-2 text-xs md:text-right uppercase tracking-wider">Shop</h4>
                <ul class="flex flex-wrap md:justify-end gap-x-5 gap-y-2 text-[12px] font-medium text-slate-600">
                    <li><a href="{{ url('/') }}" class="hover:text-blue-600 transition-colors">Home</a></li>
                    <li><a href="{{ route('shop') }}" class="hover:text-blue-600 transition-colors">All Products</a></li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-blue-600 transition-colors">Cart</a></li>
                </ul>
            </div>
        </div>

        <!-- Garis Pembatas & Copyright (Sangat Rapat) -->
        <div class="border-t border-slate-100 pt-4 flex flex-col md:flex-row justify-between items-center gap-2">
            <p class="text-[10px] text-slate-400 font-medium">
                &copy; {{ date('Y') }} Loka Ltd. All Rights Reserved.
            </p>
            <div class="flex gap-4 text-[10px] text-slate-400 font-medium">
                <a href="#" class="hover:text-slate-900 transition-colors">Terms & Conditions</a>
                <a href="#" class="hover:text-slate-900 transition-colors">Privacy Policy</a>
            </div>
        </div>
    </footer>
</div>