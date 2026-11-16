@extends('layouts.app')
@section('title', 'Lacak Pesanan')

@section('content')
<main class="max-w-6xl mx-auto px-6 py-8">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Lacak Pesanan <span class="text-blue-600">#ORD-2026-001847</span></h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <x-glass-card class="lg:col-span-2 p-3 rounded-[32px] relative">
            <div id="map" style="height: 500px; border-radius: 24px; z-index: 0;"></div>
            
            <x-glass-card class="absolute bottom-8 left-8 right-8 p-4 rounded-[24px] flex items-center gap-4 z-[400]">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">🛵</div>
                <div class="flex-1">
                    <p class="text-xs text-slate-500">Kurir</p>
                    <p class="font-bold text-slate-800">Budi Santoso</p>
                </div>
            </x-glass-card>
        </x-glass-card>

        <x-glass-card class="p-6 rounded-[32px]">
            <p class="text-slate-500 text-sm mb-1">Estimasi Tiba</p>
            <p class="text-4xl font-bold text-slate-900 mb-4" id="eta">12 menit</p>
            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-blue-600 rounded-full" id="progress" style="width: 25%"></div>
            </div>
        </x-glass-card>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // Script Leaflet Anda
    const map = L.map('map', { zoomControl: false }).setView([-6.2088, 106.8456], 13);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png').addTo(map);
    // ... masukkan sisa kode script peta di sini ...
</script>
@endpush