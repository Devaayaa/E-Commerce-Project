@extends('layouts.app')

@section('title', 'Dashboard Penjual')

@section('content')
@php
    // input kaca (form tambah produk) & input kecil (tabel)
    $f  = 'px-4 py-2.5 rounded-xl bg-white/50 border border-white/70 text-sm text-slate-900 placeholder-slate-500 outline-none focus:ring-2 focus:ring-sky-400/50 transition';
    $sf = 'px-2.5 py-1.5 rounded-lg bg-white/50 border border-white/70 text-xs text-slate-900 outline-none focus:ring-2 focus:ring-sky-400/50 transition';
    $badge = [
        'pending'   => 'bg-amber-100 text-amber-700',
        'confirmed' => 'bg-sky-100 text-sky-700',
        'cancelled' => 'bg-red-100 text-red-600',
        'delivered' => 'bg-emerald-100 text-emerald-700',
        'completed' => 'bg-emerald-100 text-emerald-700',
    ];
@endphp

<div class="sky" aria-hidden="true">
    <div class="cloud-pic" style="top:4%;left:-4%;--w:420px;--d:18s"></div>
    <div class="cloud-pic" style="top:22%;right:-3%;--w:520px;--d:22s;--dl:-6s"></div>
    <div class="cloud-pic" style="top:48%;left:-6%;--w:380px;--d:15s;--dl:-3s"></div>
    <div class="cloud-pic" style="top:66%;right:2%;--w:460px;--d:20s;--dl:-9s"></div>
    <div class="cloud-pic" style="top:84%;left:8%;--w:340px;--d:17s;--dl:-2s"></div>
</div>

<main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 pt-36 pb-24">
    <div class="relative rounded-[3rem]">
        <div class="lg bg-white/10 absolute inset-0 rounded-[3rem] pointer-events-none" aria-hidden="true">
            <div class="pane-glow"><i class="g1"></i><i class="g2"></i><i class="g3"></i></div>
        </div>

        <div class="relative z-10 p-5 sm:p-8 lg:p-10 space-y-6">

            {{-- HEADER TOKO --}}
            <div>
                <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[10px] font-extrabold tracking-[0.2em] uppercase text-sky-800 mb-4"><span class="text-amber-500 text-xs">✦</span> Seller dashboard</span>
                <h1 class="text-3xl md:text-4xl font-serif-display text-slate-900">{{ $seller->store_name }}</h1>
                <p class="text-slate-600 mt-1">Kelola produk dan pesanan yang masuk.</p>
            </div>

            <x-flash />

            {{-- STATISTIK --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="lg lg-soft rounded-[1.5rem] p-5">
                    <p class="text-xs font-bold tracking-wide uppercase text-slate-600 mb-1">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="lg lg-soft rounded-[1.5rem] p-5">
                    <p class="text-xs font-bold tracking-wide uppercase text-slate-600 mb-1">Pesanan Baru</p>
                    <p class="text-2xl font-bold text-sky-700">
                        @if($stats['new_orders'] > 0)<span class="inline-block w-2 h-2 rounded-full bg-amber-400 mr-2 align-middle" aria-hidden="true"></span>@endif{{ $stats['new_orders'] }}
                    </p>
                </div>
                <div class="lg lg-soft rounded-[1.5rem] p-5">
                    <p class="text-xs font-bold tracking-wide uppercase text-slate-600 mb-1">Dalam Proses</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $stats['in_process'] }}</p>
                </div>
                <div class="lg lg-soft rounded-[1.5rem] p-5">
                    <p class="text-xs font-bold tracking-wide uppercase text-slate-600 mb-1">Jumlah Produk</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $stats['products'] }}</p>
                </div>
            </div>

            {{-- GRAFIK PENJUALAN --}}
            <section class="lg lg-soft rounded-[2rem] p-5 sm:p-6">
                <div class="flex items-center gap-3 mb-5"><span class="h-5 w-1 rounded-full bg-gradient-to-b from-amber-300 to-amber-500"></span><h3 class="font-bold text-lg text-slate-900">Grafik Penjualan</h3></div>
                @if($salesChart->isEmpty())
                    <p class="text-center text-slate-600 py-6">Belum ada penjualan selesai untuk ditampilkan.</p>
                @else
                    <p class="text-xs text-slate-600 mb-3">10 produk terlaris dari pesanan yang sudah selesai.</p>
                    <div class="relative h-72"><canvas id="sales-chart" aria-label="Grafik produk terjual" role="img"></canvas></div>
                @endif
            </section>

            {{-- PESANAN MASUK --}}
            <section class="lg lg-soft rounded-[2rem] p-5 sm:p-6">
                <div class="flex items-center gap-3 mb-5"><span class="h-5 w-1 rounded-full bg-gradient-to-b from-amber-300 to-amber-500"></span><h3 class="font-bold text-lg text-slate-900">Pesanan Masuk</h3></div>
                <div class="space-y-4">
                    @forelse($orders as $o)
                    <div class="rounded-[1.5rem] p-4 sm:p-5 bg-white/40 border border-white/70">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="font-bold text-slate-900">#{{ $o->order_number }}
                                    <span class="ml-2 px-2.5 py-0.5 text-[11px] rounded-full font-bold {{ $badge[$o->status] ?? 'bg-slate-100 text-slate-600' }}">{{ $o->statusLabel() }}</span>
                                </p>
                                <p class="text-sm text-slate-600">{{ $o->recipient_name }} · {{ $o->recipient_phone }} · {{ strtoupper(str_replace('_', ' ', $o->payment_method)) }}</p>
                                <p class="text-sm text-slate-700 mt-1">{{ $o->shipping_address }}</p>
                                <p class="text-sm text-slate-600 mt-2">
                                    @foreach($o->items as $item)
                                    {{ $item->emoji ?? '📦' }} {{ $item->product_name }} × {{ $item->quantity }}@if(! $loop->last), @endif
                                    @endforeach
                                </p>
                                <p class="text-xs text-slate-500 mt-1">Kurir: {{ $o->courier?->user?->name ?? 'belum ditugaskan' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-slate-900 mb-2">Rp {{ number_format($o->total, 0, ',', '.') }}</p>
                                @if(in_array($o->status, ['pending', 'confirmed']))
                                <form action="{{ route('seller.orders.update', $o) }}" method="POST" class="flex gap-2 justify-end">
                                    @csrf @method('PATCH')
                                    @if($o->status === 'pending')
                                    <button name="action" value="confirm" class="lg lg-blue lg-btn h-9 px-4 rounded-full text-xs font-bold">Konfirmasi</button>
                                    @endif
                                    <button name="action" value="cancel" class="lg lg-soft lg-btn h-9 px-4 rounded-full text-xs font-bold text-red-600"
                                        onclick="return confirm('Batalkan pesanan ini?')">Batalkan</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-slate-600 py-6">Belum ada pesanan masuk.</p>
                    @endforelse
                </div>
            </section>

            {{-- TAMBAH PRODUK --}}
            <section class="lg lg-soft rounded-[2rem] p-5 sm:p-6">
                <div class="flex items-center gap-3 mb-5"><span class="h-5 w-1 rounded-full bg-gradient-to-b from-amber-300 to-amber-500"></span><h3 class="font-bold text-lg text-slate-900">Tambah Produk</h3></div>
                <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @csrf
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama produk" aria-label="Nama produk" required class="md:col-span-2 {{ $f }}">
                    <select name="category" required aria-label="Kategori" class="{{ $f }}">
                        @foreach(\App\Models\Product::CATEGORIES as $cat)
                        <option value="{{ $cat }}" @selected(old('category') === $cat)>{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="emoji" value="{{ old('emoji') }}" placeholder="Emoji (mis. 🎧)" aria-label="Emoji" maxlength="16" class="{{ $f }}">
                    <input type="number" name="price" value="{{ old('price') }}" placeholder="Harga (Rp)" aria-label="Harga" min="0" step="1" required class="{{ $f }}">
                    <input type="number" name="original_price" value="{{ old('original_price') }}" placeholder="Harga coret (opsional)" aria-label="Harga coret" min="0" step="1" class="{{ $f }}">
                    <input type="number" name="discount" value="{{ old('discount') }}" placeholder="Diskon % (opsional)" aria-label="Diskon" min="0" max="90" class="{{ $f }}">
                    <input type="number" name="stock" value="{{ old('stock') }}" placeholder="Stok" aria-label="Stok" min="0" required class="{{ $f }}">
                    <textarea name="description" rows="2" placeholder="Deskripsi singkat" aria-label="Deskripsi" class="md:col-span-3 resize-none {{ $f }}">{{ old('description') }}</textarea>
                    <div class="md:col-span-3">
                        <label class="block text-sm font-semibold mb-2 text-slate-800" for="product-image">Gambar Produk</label>
                        <input id="product-image" type="file" name="image" accept="image/png,image/jpeg,image/webp" class="{{ $f }} w-full">
                        <p class="text-[11px] text-slate-500 mt-1">JPG, PNG, atau WebP. Maksimal 2 MB.</p>
                        @error('image')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="lg lg-gold lg-btn h-11 self-end rounded-full text-sm font-bold">Simpan Produk</button>
                </form>
            </section>

            {{-- DAFTAR PRODUK --}}
            <section class="lg lg-soft rounded-[2rem] p-5 sm:p-6">
                <div class="flex items-center gap-3 mb-5"><span class="h-5 w-1 rounded-full bg-gradient-to-b from-amber-300 to-amber-500"></span><h3 class="font-bold text-lg text-slate-900">Produk Anda</h3></div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-[11px] font-bold tracking-wide uppercase text-slate-600 border-b border-white/70">
                                <th class="py-2 pr-4">Produk</th>
                                <th class="py-2 pr-4">Kategori</th>
                                <th class="py-2 pr-4">Terjual</th>
                                <th class="py-2 pr-4">Harga &amp; Stok</th>
                                <th class="py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $p)
                            <tr class="border-b border-white/50 align-middle">
                                <td class="py-3 pr-4 font-semibold text-slate-900">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $p->image ? (\Illuminate\Support\Str::startsWith($p->image, ['http', '/']) ? $p->image : asset('storage/'.$p->image)) : asset('images/no-product.png') }}"
                                             alt="{{ $p->name }}" class="w-14 h-14 rounded-xl object-cover bg-white/40" loading="lazy">
                                        <div>{{ $p->emoji ?? '📦' }} {{ $p->name }}</div>
                                    </div>
                                </td>
                                <td class="py-3 pr-4 text-slate-600">{{ ucfirst($p->category ?? '-') }}</td>
                                <td class="py-3 pr-4 text-slate-600">{{ $p->sold }}</td>
                                <td class="py-3 pr-4">
                                    <form action="{{ route('seller.products.update', $p) }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
                                        @csrf @method('PATCH')
                                        <input type="number" name="price" value="{{ (int) $p->price }}" min="0" aria-label="Harga" class="w-28 {{ $sf }}">
                                        <input type="number" name="stock" value="{{ $p->stock }}" min="0" aria-label="Stok" class="w-20 {{ $sf }}">
                                        <input type="file" name="image" accept="image/png,image/jpeg,image/webp" aria-label="Ganti gambar" class="text-xs w-full max-w-48">
                                        <button class="lg lg-soft lg-btn h-8 px-4 rounded-full text-xs font-bold text-sky-700">Update</button>
                                    </form>
                                </td>
                                <td class="py-3 text-right">
                                    <form action="{{ route('seller.products.destroy', $p) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ addslashes($p->name) }}? Produk yang dihapus tidak dapat dikembalikan.')">
                                        @csrf @method('DELETE')
                                        <button class="lg lg-soft lg-btn h-8 px-4 rounded-full text-xs font-bold text-red-600">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="py-6 text-center text-slate-600">Belum ada produk.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </div>
</main>

@if($salesChart->isNotEmpty())
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    (function () {
        var el = document.getElementById('sales-chart');
        if (!el || typeof Chart === 'undefined') return;
        var data = @json($salesChart);
        new Chart(el, {
            type: 'bar',
            data: {
                labels: data.map(function (d) { return d.product_name; }),
                datasets: [{
                    label: 'Jumlah terjual',
                    data: data.map(function (d) { return Number(d.total_sold); }),
                    backgroundColor: 'rgba(14, 165, 233, 0.6)',
                    borderColor: 'rgb(2, 132, 199)',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            afterLabel: function (ctx) {
                                var rev = Number(data[ctx.dataIndex].total_revenue);
                                return 'Pendapatan: Rp ' + rev.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    })();
</script>
@endpush
@endif
@endsection