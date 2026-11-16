@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <x-glass-card class="p-6 rounded-[32px] mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Admin Panel</h2>
        <p class="text-slate-500">Ringkasan sistem TokoKu secara keseluruhan.</p>
    </x-glass-card>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-glass-card class="p-5 rounded-2xl">
            <p class="text-xs text-slate-500 mb-1">Total Pelanggan</p>
            <p class="text-2xl font-bold text-slate-900">1,240</p>
        </x-glass-card>
        <x-glass-card class="p-5 rounded-2xl">
            <p class="text-xs text-slate-500 mb-1">Total Kurir</p>
            <p class="text-2xl font-bold text-slate-900">12</p>
        </x-glass-card>
    </div>
</div>
@endsection