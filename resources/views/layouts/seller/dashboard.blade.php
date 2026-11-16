@extends('layouts.app')

@section('title', 'Dashboard Penjual')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <x-glass-card class="p-6 rounded-[32px] mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Toko Anda</h2>
        <p class="text-slate-500">Kelola produk dan pesanan yang masuk.</p>
    </x-glass-card>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-glass-card class="p-5 rounded-2xl">
            <p class="text-sm text-slate-500 mb-1">Total Pendapatan</p>
            <p class="text-2xl font-bold text-slate-900">Rp 4.500.000</p>
        </x-glass-card>
        <x-glass-card class="p-5 rounded-2xl">
            <p class="text-sm text-slate-500 mb-1">Pesanan Baru</p>
            <p class="text-2xl font-bold text-blue-600">12</p>
        </x-glass-card>
    </div>
</div>
@endsection