@extends('layouts.app')

@section('title', 'Dashboard Kurir')

@section('content')
<div class="max-w-7xl mx-auto px-6 pt-28 pb-12">

    <x-glass-card class="p-6 rounded-[32px] mb-6 flex flex-wrap gap-4 justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Halo, {{ auth()->user()->name }}!</h2>
            <p class="text-slate-500">
                Anda memiliki {{ $orders->count() }} pesanan yang harus diantar.
                Selesai hari ini: {{ $deliveredToday }}.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div id="gps-badge" class="px-4 py-2 bg-slate-50 text-slate-500 rounded-full border border-slate-200 flex items-center gap-2 text-sm font-bold">
                <span id="gps-dot" class="w-2 h-2 bg-slate-400 rounded-full"></span>
                <span id="gps-text">GPS Nonaktif</span>
            </div>

            <form action="{{ route('courier.status') }}" method="POST">
                @csrf
                @if($courier->status === 'offline')
                    <button name="status" value="available" class="px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-full hover:bg-green-700 transition">Mulai Online</button>
                @else
                    <button name="status" value="offline" class="px-4 py-2 bg-slate-900 text-white text-sm font-bold rounded-full hover:bg-red-600 transition">
                        {{ $courier->status === 'on_delivery' ? 'Sedang Mengantar' : 'Online — Klik untuk Offline' }}
                    </button>
                @endif
            </form>
        </div>
    </x-glass-card>

    <x-flash />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($orders as $o)
        <x-glass-card class="p-5 rounded-2xl border-l-4 {{ $o->status === 'shipped' ? 'border-l-blue-600' : 'border-l-amber-400' }}">
            <div class="mb-4">
                <p class="text-xs font-bold mb-1 {{ $o->status === 'shipped' ? 'text-blue-600' : 'text-amber-600' }}">
                    {{ $o->status === 'shipped' ? 'SEDANG DIKIRIM' : 'SIAP DIAMBIL' }}
                </p>
                <p class="font-bold text-slate-800">#{{ $o->order_number }}</p>
                <p class="text-sm text-slate-500">{{ $o->recipient_name }} · {{ $o->recipient_phone }}</p>
            </div>
            <p class="text-sm text-slate-600 mb-1"><span class="font-semibold">Ambil di:</span> {{ $o->seller?->store_name }}@if($o->seller?->address) — {{ $o->seller->address }}@endif</p>
            <p class="text-sm text-slate-600 mb-1"><span class="font-semibold">Antar ke:</span> {{ $o->shipping_address }}</p>
            <p class="text-sm text-slate-500 mb-4">
                {{ $o->items->sum('quantity') }} item · Rp {{ number_format($o->total, 0, ',', '.') }}
                @if($o->payment_method === 'cod') · <span class="font-bold text-red-600">COD — tagih tunai</span>@endif
            </p>

            <div class="flex gap-2">
                <a href="{{ route('tracking', $o->order_number) }}" class="flex-1 text-center py-2 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition text-sm">Buka Peta</a>

                @if($o->status === 'confirmed')
                <form action="{{ route('courier.pickup', $o) }}" method="POST" class="flex-1">
                    @csrf
                    <button class="w-full py-2 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition text-sm">Ambil Paket</button>
                </form>
                @else
                <form action="{{ route('courier.deliver', $o) }}" method="POST" class="flex-1" onsubmit="return confirm('Konfirmasi paket sudah diterima pelanggan?')">
                    @csrf
                    <button class="w-full py-2 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition text-sm">Selesai Diantar</button>
                </form>
                @endif
            </div>
        </x-glass-card>
        @empty
        <x-glass-card class="md:col-span-2 p-12 rounded-[2rem] text-center">
            <span class="text-5xl block mb-3">🛵</span>
            <p class="font-bold text-slate-800">Belum ada pesanan untuk diantar</p>
            <p class="text-sm text-slate-500">Pastikan status Anda Online agar menerima penugasan.</p>
        </x-glass-card>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        // GPS hanya aktif saat kurir online / sedang mengantar
        const shouldTrack = @json($courier->status !== 'offline');
        const url = @json(route('courier.location'));
        const csrf = @json(csrf_token());
        const dot = document.getElementById('gps-dot');
        const text = document.getElementById('gps-text');
        const badge = document.getElementById('gps-badge');

        function setState(active, label) {
            dot.className = 'w-2 h-2 rounded-full ' + (active ? 'bg-green-500 animate-pulse' : 'bg-slate-400');
            badge.className = 'px-4 py-2 rounded-full border flex items-center gap-2 text-sm font-bold ' +
                (active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-slate-50 text-slate-500 border-slate-200');
            text.textContent = label;
        }

        if (!shouldTrack) return setState(false, 'GPS Nonaktif');
        if (!('geolocation' in navigator)) return setState(false, 'GPS tidak didukung');

        let lastSent = 0;
        navigator.geolocation.watchPosition(
            pos => {
                setState(true, 'GPS Aktif');
                const now = Date.now();
                if (now - lastSent < 8000) return; // kirim maksimal tiap 8 detik
                lastSent = now;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({ latitude: pos.coords.latitude, longitude: pos.coords.longitude })
                }).catch(() => {});
            },
            () => setState(false, 'Izin GPS ditolak'),
            { enableHighAccuracy: true, maximumAge: 5000, timeout: 20000 }
        );
    })();
</script>
@endpush
