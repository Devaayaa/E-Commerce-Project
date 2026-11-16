@extends('layouts.app')

@section('title', 'Dashboard Kurir')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    
    <x-glass-card class="p-6 rounded-[32px] mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Halo, Budi!</h2>
            <p class="text-slate-500">Anda memiliki 3 pesanan yang harus diantar hari ini.</p>
        </div>
        <div class="px-4 py-2 bg-green-50 text-green-700 rounded-full border border-green-200 flex items-center gap-2 text-sm font-bold">
            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> GPS Aktif
        </div>
    </x-glass-card>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-glass-card class="p-5 rounded-2xl border-l-4 border-l-blue-600">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs text-blue-600 font-bold mb-1">SEDANG DIKIRIM</p>
                    <p class="font-bold text-slate-800">#ORD-2026-001847</p>
                    <p class="text-sm text-slate-500">Ani Wijaya · 0812-1111-2222</p>
                </div>
            </div>
            <p class="text-sm text-slate-600 mb-4">Jl. Kebon Jeruk Raya No. 42, Jakarta Barat</p>
            <a href="{{ route('tracking') }}" class="block text-center w-full py-2 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">Buka Peta Navigasi</a>
        </x-glass-card>
    </div>

</div>
@endsection