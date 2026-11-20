@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<div class="max-w-7xl mx-auto px-6 pt-28 pb-12">
    <x-glass-card class="p-6 rounded-[32px] mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Admin Panel</h2>
        <p class="text-slate-500">Ringkasan sistem Loka secara keseluruhan.</p>
    </x-glass-card>

    <x-flash />

    {{-- STATISTIK --}}
    @php
        $cards = [
            ['Total Pelanggan', number_format($stats['customers'])],
            ['Total Penjual', number_format($stats['sellers'])],
            ['Total Kurir', number_format($stats['couriers'])],
            ['Total Produk', number_format($stats['products'])],
            ['Total Pesanan', number_format($stats['orders'])],
            ['Pendapatan Selesai', 'Rp ' . number_format($stats['revenue'], 0, ',', '.')],
        ];
    @endphp
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        @foreach($cards as [$label, $value])
        <x-glass-card class="p-5 rounded-2xl">
            <p class="text-xs text-slate-500 mb-1">{{ $label }}</p>
            <p class="text-xl font-bold text-slate-900">{{ $value }}</p>
        </x-glass-card>
        @endforeach
    </div>

    {{-- PESANAN --}}
    <x-glass-card class="p-6 rounded-[32px] mb-6">
        <h3 class="font-bold text-slate-900 mb-4">Pesanan Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-500 border-b border-slate-200">
                        <th class="py-2 pr-4">No. Pesanan</th>
                        <th class="py-2 pr-4">Pelanggan</th>
                        <th class="py-2 pr-4">Toko</th>
                        <th class="py-2 pr-4">Total</th>
                        <th class="py-2 pr-4">Status</th>
                        <th class="py-2">Kurir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $o)
                    <tr class="border-b border-slate-100">
                        <td class="py-3 pr-4 font-semibold">
                            <a href="{{ route('tracking', $o->order_number) }}" class="text-blue-600 hover:underline">#{{ $o->order_number }}</a>
                        </td>
                        <td class="py-3 pr-4">{{ $o->customer?->user?->name ?? $o->recipient_name }}</td>
                        <td class="py-3 pr-4">{{ $o->seller?->store_name }}</td>
                        <td class="py-3 pr-4">Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                        <td class="py-3 pr-4">{{ $o->statusLabel() }}</td>
                        <td class="py-3">
                            @if($o->status === 'confirmed')
                            <form action="{{ route('admin.orders.courier', $o) }}" method="POST" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <select name="courier_id" class="px-2 py-1 rounded-lg border border-slate-200 bg-white text-xs">
                                    @foreach($couriers as $c)
                                    <option value="{{ $c->id }}" @selected($o->courier_id === $c->id)>{{ $c->user?->name ?? 'Kurir #'.$c->id }} ({{ $c->status }})</option>
                                    @endforeach
                                </select>
                                <button class="px-3 py-1 bg-slate-900 text-white text-xs font-bold rounded-lg hover:bg-blue-600 transition">Tugaskan</button>
                            </form>
                            @else
                            {{ $o->courier?->user?->name ?? '—' }}
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-6 text-center text-slate-500">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-glass-card>

    {{-- PENGGUNA --}}
    <x-glass-card class="p-6 rounded-[32px]">
        <h3 class="font-bold text-slate-900 mb-4">Manajemen Pengguna</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-500 border-b border-slate-200">
                        <th class="py-2 pr-4">Nama</th>
                        <th class="py-2 pr-4">Email</th>
                        <th class="py-2">Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr class="border-b border-slate-100">
                        <td class="py-3 pr-4 font-semibold">{{ $u->name }}</td>
                        <td class="py-3 pr-4 text-slate-600">{{ $u->email }}</td>
                        <td class="py-3">
                            @if($u->id === auth()->id())
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-full">{{ $u->role }} (Anda)</span>
                            @else
                            <form action="{{ route('admin.users.role', $u) }}" method="POST" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <select name="role" class="px-2 py-1 rounded-lg border border-slate-200 bg-white text-xs">
                                    @foreach(\App\Models\User::ROLES as $role)
                                    <option value="{{ $role }}" @selected($u->role === $role)>{{ $role }}</option>
                                    @endforeach
                                </select>
                                <button class="px-3 py-1 bg-slate-900 text-white text-xs font-bold rounded-lg hover:bg-blue-600 transition">Simpan</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-glass-card>
</div>
@endsection
