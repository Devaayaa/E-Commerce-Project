@extends('layouts.app')

@section('title', 'Dashboard Penjual')

@section('content')
<div class="max-w-7xl mx-auto px-6 pt-28 pb-12">
    <x-glass-card class="p-6 rounded-[32px] mb-6">
        <h2 class="text-2xl font-bold text-slate-900">{{ $seller->store_name }}</h2>
        <p class="text-slate-500">Kelola produk dan pesanan yang masuk.</p>
    </x-glass-card>

    <x-flash />

    {{-- STATISTIK --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <x-glass-card class="p-5 rounded-2xl">
            <p class="text-sm text-slate-500 mb-1">Total Pendapatan</p>
            <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
        </x-glass-card>
        <x-glass-card class="p-5 rounded-2xl">
            <p class="text-sm text-slate-500 mb-1">Pesanan Baru</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['new_orders'] }}</p>
        </x-glass-card>
        <x-glass-card class="p-5 rounded-2xl">
            <p class="text-sm text-slate-500 mb-1">Dalam Proses</p>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['in_process'] }}</p>
        </x-glass-card>
        <x-glass-card class="p-5 rounded-2xl">
            <p class="text-sm text-slate-500 mb-1">Jumlah Produk</p>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['products'] }}</p>
        </x-glass-card>
    </div>

    {{-- PESANAN MASUK --}}
    <x-glass-card class="p-6 rounded-[32px] mb-6">
        <h3 class="font-bold text-slate-900 mb-4">Pesanan Masuk</h3>
        <div class="space-y-4">
            @forelse($orders as $o)
            <div class="border border-slate-100 rounded-2xl p-4 bg-white/60">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="font-bold text-slate-900">#{{ $o->order_number }}
                            <span class="ml-2 px-2 py-0.5 text-[11px] rounded-full bg-blue-100 text-blue-700 font-bold">{{ $o->statusLabel() }}</span>
                        </p>
                        <p class="text-sm text-slate-500">{{ $o->recipient_name }} · {{ $o->recipient_phone }} · {{ strtoupper(str_replace('_', ' ', $o->payment_method)) }}</p>
                        <p class="text-sm text-slate-600 mt-1">{{ $o->shipping_address }}</p>
                        <p class="text-sm text-slate-500 mt-2">
                            @foreach($o->items as $item)
                            {{ $item->emoji ?? '📦' }} {{ $item->product_name }} × {{ $item->quantity }}@if(! $loop->last), @endif
                            @endforeach
                        </p>
                        <p class="text-xs text-slate-400 mt-1">Kurir: {{ $o->courier?->user?->name ?? 'belum ditugaskan' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-slate-900 mb-2">Rp {{ number_format($o->total, 0, ',', '.') }}</p>
                        @if(in_array($o->status, ['pending', 'confirmed']))
                        <form action="{{ route('seller.orders.update', $o) }}" method="POST" class="flex gap-2 justify-end">
                            @csrf @method('PATCH')
                            @if($o->status === 'pending')
                            <button name="action" value="confirm" class="px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-xl hover:bg-blue-700 transition">Konfirmasi</button>
                            @endif
                            <button name="action" value="cancel" class="px-4 py-2 bg-red-50 text-red-600 text-xs font-bold rounded-xl hover:bg-red-100 transition"
                                onclick="return confirm('Batalkan pesanan ini?')">Batalkan</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-slate-500 py-6">Belum ada pesanan masuk.</p>
            @endforelse
        </div>
    </x-glass-card>

    {{-- TAMBAH PRODUK --}}
    <x-glass-card class="p-6 rounded-[32px] mb-6">
        <h3 class="font-bold text-slate-900 mb-4">Tambah Produk</h3>
        <form action="{{ route('seller.products.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama produk" required class="md:col-span-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm">
            <select name="category" required class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm">
                @foreach(\App\Models\Product::CATEGORIES as $cat)
                <option value="{{ $cat }}" @selected(old('category') === $cat)>{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
            <input type="text" name="emoji" value="{{ old('emoji') }}" placeholder="Emoji (mis. 🎧)" maxlength="16" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm">
            <input type="number" name="price" value="{{ old('price') }}" placeholder="Harga (Rp)" min="0" step="1" required class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm">
            <input type="number" name="original_price" value="{{ old('original_price') }}" placeholder="Harga coret (opsional)" min="0" step="1" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm">
            <input type="number" name="discount" value="{{ old('discount') }}" placeholder="Diskon % (opsional)" min="0" max="90" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm">
            <input type="number" name="stock" value="{{ old('stock') }}" placeholder="Stok" min="0" required class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm">
            <textarea name="description" rows="2" placeholder="Deskripsi singkat" class="md:col-span-3 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm">{{ old('description') }}</textarea>
            <button type="submit" class="px-4 py-2.5 bg-slate-900 text-white font-bold text-sm rounded-xl hover:bg-blue-600 transition">Simpan Produk</button>
        </form>
    </x-glass-card>

    {{-- DAFTAR PRODUK --}}
    <x-glass-card class="p-6 rounded-[32px]">
        <h3 class="font-bold text-slate-900 mb-4">Produk Anda</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-500 border-b border-slate-200">
                        <th class="py-2 pr-4">Produk</th>
                        <th class="py-2 pr-4">Kategori</th>
                        <th class="py-2 pr-4">Terjual</th>
                        <th class="py-2 pr-4">Harga &amp; Stok</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                    <tr class="border-b border-slate-100 align-middle">
                        <td class="py-3 pr-4 font-semibold">{{ $p->emoji ?? '📦' }} {{ $p->name }}</td>
                        <td class="py-3 pr-4 text-slate-600">{{ ucfirst($p->category ?? '-') }}</td>
                        <td class="py-3 pr-4 text-slate-600">{{ $p->sold }}</td>
                        <td class="py-3 pr-4">
                            <form action="{{ route('seller.products.update', $p) }}" method="POST" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <input type="number" name="price" value="{{ (int) $p->price }}" min="0" class="w-28 px-2 py-1 rounded-lg border border-slate-200 bg-white text-xs">
                                <input type="number" name="stock" value="{{ $p->stock }}" min="0" class="w-20 px-2 py-1 rounded-lg border border-slate-200 bg-white text-xs">
                                <button class="px-3 py-1 bg-slate-900 text-white text-xs font-bold rounded-lg hover:bg-blue-600 transition">Update</button>
                            </form>
                        </td>
                        <td class="py-3 text-right">
                            <form action="{{ route('seller.products.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1 bg-red-50 text-red-600 text-xs font-bold rounded-lg hover:bg-red-100 transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-6 text-center text-slate-500">Belum ada produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-glass-card>
</div>
@endsection
