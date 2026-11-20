@extends('layouts.app')
@section('title', 'Lacak Pesanan')

@section('content')
<main class="max-w-6xl mx-auto px-6 pt-28 pb-16">

    <x-flash />

    @if(! $order)
    {{-- ============ DAFTAR PESANAN ============ --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Pesanan Saya</h1>
        <p class="text-slate-500">Pilih pesanan untuk melihat status dan lokasi kurir.</p>
    </div>

    @forelse($orders as $o)
    <x-glass-card class="p-5 rounded-2xl mb-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="font-bold text-slate-900">#{{ $o->order_number }}</p>
                <p class="text-sm text-slate-500">
                    {{ $o->created_at->format('d M Y H:i') }} ·
                    {{ $o->items->sum('quantity') }} item ·
                    Rp {{ number_format($o->total, 0, ',', '.') }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 rounded-full text-xs font-bold
                    {{ $o->status === 'delivered' ? 'bg-green-100 text-green-700' : ($o->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                    {{ $o->statusLabel() }}
                </span>
                <a href="{{ route('tracking', $o->order_number) }}" class="px-4 py-2 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-blue-600 transition">Lacak</a>
            </div>
        </div>
    </x-glass-card>
    @empty
    <x-glass-card class="p-12 rounded-[2rem] text-center">
        <span class="text-5xl block mb-3">📦</span>
        <p class="font-bold text-slate-800 mb-1">Belum ada pesanan</p>
        <a href="{{ route('shop') }}" class="text-sm font-semibold text-blue-600 hover:underline">Mulai belanja &rarr;</a>
    </x-glass-card>
    @endforelse

    @else
    {{-- ============ DETAIL + PETA ============ --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Lacak Pesanan <span class="text-blue-600">#{{ $order->order_number }}</span></h1>
        <p class="text-slate-500" id="status-label">{{ $order->statusLabel() }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <x-glass-card class="lg:col-span-2 p-3 rounded-[32px] relative">
            <div id="map" style="height: 500px; border-radius: 24px; z-index: 0;"></div>

            <x-glass-card class="absolute bottom-8 left-8 right-8 p-4 rounded-[24px] flex items-center gap-4 z-[400]">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">🛵</div>
                <div class="flex-1">
                    <p class="text-xs text-slate-500">Kurir</p>
                    <p class="font-bold text-slate-800" id="courier-name">{{ $order->courier?->user?->name ?? 'Belum ditugaskan' }}</p>
                    <p class="text-[11px] text-slate-400" id="courier-updated"></p>
                </div>
                @if($order->courier?->phone)
                <a href="tel:{{ $order->courier->phone }}" class="text-xs font-bold text-blue-600 hover:underline">{{ $order->courier->phone }}</a>
                @endif
            </x-glass-card>
        </x-glass-card>

        <div class="space-y-6">
            <x-glass-card class="p-6 rounded-[32px]">
                <p class="text-slate-500 text-sm mb-1">Estimasi Tiba</p>
                <p class="text-4xl font-bold text-slate-900 mb-4" id="eta">
                    @if($order->status === 'delivered') Selesai
                    @elseif($order->status === 'cancelled') Dibatalkan
                    @elseif($order->etaMinutes()) {{ $order->etaMinutes() }} menit
                    @else — @endif
                </p>
                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-600 rounded-full transition-all duration-700" id="progress" style="width: {{ $order->progressPercent() }}%"></div>
                </div>
            </x-glass-card>

            <x-glass-card class="p-6 rounded-[32px]">
                <p class="font-bold text-slate-900 mb-3">Rincian Pesanan</p>
                <div class="space-y-2 mb-4">
                    @foreach($order->items as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">{{ $item->emoji ?? '📦' }} {{ $item->product_name }} × {{ $item->quantity }}</span>
                        <span class="font-semibold text-slate-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="flex justify-between border-t border-slate-100 pt-3 text-sm">
                    <span class="font-bold text-slate-900">Total</span>
                    <span class="font-bold text-blue-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
                <p class="text-xs text-slate-500 mt-4">Dikirim ke: {{ $order->recipient_name }} — {{ $order->shipping_address }}</p>
                <p class="text-xs text-slate-400 mt-1">Toko: {{ $order->seller?->store_name }}</p>
            </x-glass-card>
        </div>
    </div>
    @endif
</main>
@endsection

@if($order)
@push('scripts')
<script>
    (function () {
        const locationUrl = @json(route('tracking.location', $order->order_number));
        const dest = @json(['lat' => $order->shipping_latitude, 'lng' => $order->shipping_longitude]);
        const origin = @json(['lat' => $order->seller?->latitude, 'lng' => $order->seller?->longitude]);
        const courier = @json(['lat' => $order->courier?->current_latitude, 'lng' => $order->courier?->current_longitude]);
        const finalStatuses = ['delivered', 'cancelled'];

        const has = p => p && p.lat !== null && p.lng !== null;
        const start = has(courier) ? courier : (has(dest) ? dest : (has(origin) ? origin : { lat: -6.2088, lng: 106.8456 }));

        const map = L.map('map', { zoomControl: false }).setView([start.lat, start.lng], 14);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap &copy; CARTO'
        }).addTo(map);

        const icon = emoji => L.divIcon({
            html: '<div style="font-size:28px;line-height:28px">' + emoji + '</div>',
            className: '', iconSize: [28, 28], iconAnchor: [14, 14]
        });

        let destMarker = null, originMarker = null, courierMarker = null;

        function render(d) {
            if (has(d.destination)) {
                if (!destMarker) destMarker = L.marker([d.destination.lat, d.destination.lng], { icon: icon('🏠') }).addTo(map).bindPopup('Alamat tujuan');
            }
            if (has(d.origin)) {
                if (!originMarker) originMarker = L.marker([d.origin.lat, d.origin.lng], { icon: icon('🏬') }).addTo(map).bindPopup('Toko');
            }
            if (d.courier && has(d.courier)) {
                const pos = [d.courier.lat, d.courier.lng];
                if (!courierMarker) {
                    courierMarker = L.marker(pos, { icon: icon('🛵'), zIndexOffset: 1000 }).addTo(map);
                    const pts = [pos];
                    if (has(d.destination)) pts.push([d.destination.lat, d.destination.lng]);
                    map.fitBounds(pts, { padding: [60, 60], maxZoom: 16 });
                } else {
                    courierMarker.setLatLng(pos);
                }
                document.getElementById('courier-updated').textContent = d.courier.updated_at ? 'Diperbarui ' + d.courier.updated_at : '';
            }
            if (d.courier) document.getElementById('courier-name').textContent = d.courier.name || 'Kurir';

            document.getElementById('status-label').textContent = d.status_label;
            document.getElementById('progress').style.width = d.progress + '%';
            document.getElementById('eta').textContent =
                d.status === 'delivered' ? 'Selesai' :
                d.status === 'cancelled' ? 'Dibatalkan' :
                d.eta_minutes ? d.eta_minutes + ' menit' : '—';
        }

        async function poll() {
            try {
                const res = await fetch(locationUrl, { headers: { 'Accept': 'application/json' } });
                if (!res.ok) return;
                const data = await res.json();
                render(data);
                if (finalStatuses.includes(data.status)) clearInterval(timer);
            } catch (e) { /* abaikan, coba lagi di polling berikutnya */ }
        }

        poll();
        const timer = setInterval(poll, 8000);
    })();
</script>
@endpush
@endif
