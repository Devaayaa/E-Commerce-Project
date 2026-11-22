@extends('layouts.app')

@section('title', 'Loka — Courier Dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/courier.css') }}">

<!-- ☁️ BACKGROUND — sama dengan Home, Shop & About -->
<div class="sky" aria-hidden="true">
    <div class="cloud-pic" style="top:4%;left:-4%;--w:420px;--d:18s"></div>
    <div class="cloud-pic" style="top:22%;right:-3%;--w:520px;--d:22s;--dl:-6s"></div>
    <div class="cloud-pic" style="top:48%;left:-6%;--w:380px;--d:15s;--dl:-3s"></div>
    <div class="cloud-pic" style="top:66%;right:2%;--w:460px;--d:20s;--dl:-9s"></div>
    <div class="cloud-pic" style="top:84%;left:8%;--w:340px;--d:17s;--dl:-2s"></div>
</div>

<main id="courier-app"
    data-route-location="{{ route('courier.location') }}"
    data-route-status="{{ route('courier.status') }}"
    data-route-withdraw="{{ route('courier.withdraw') }}"
    data-route-profile="{{ route('courier.profile.update') }}"
    data-balance="{{ $courier->balance ?? 0 }}"
    data-csrf="{{ csrf_token() }}"
    data-initial-status="{{ $courier->status }}"
    data-created-at="{{ $courier->created_at ?? now() }}"
    class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 pt-32 pb-40 min-h-screen">

    <div class="relative rounded-[3rem]">
        <div class="lg bg-white/10 absolute inset-0 rounded-[3rem] pointer-events-none" aria-hidden="true"><div class="pane-glow"><i class="g1"></i><i class="g2"></i><i class="g3"></i></div></div>
        <div class="relative z-10 p-5 sm:p-8 lg:p-12">

            <!-- PROFIL KURIR -->
            <div class="cd-reveal absolute top-5 right-5 md:top-8 md:right-8 z-20 lg lg-soft rounded-full flex items-center gap-3 p-2">
                <div class="relative"><img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=0D8ABC&color=fff' }}" alt="" class="w-10 h-10 rounded-full border-2 border-white object-cover"><span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></span></div>
                <div class="hidden md:block pr-1"><p class="text-sm font-bold text-slate-900 leading-tight">{{ auth()->user()->name }}</p><p class="text-[11px] text-amber-600 font-bold">⭐ {{ $courier->rating ?? '5.0' }} <span class="text-slate-500 font-normal">({{ $courier->review_count ?? 0 }} reviews)</span></p></div>
                <button onclick="openProfileModal()" class="lg lg-gold w-9 h-9 rounded-full grid place-items-center" title="Edit Profile" aria-label="Edit profile"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
            </div>

            <!-- HEADER -->
            <header class="cd-reveal relative text-center max-w-3xl mx-auto mb-12 mt-14 md:mt-0">
                <span class="sparkle twinkle hidden sm:block" style="top:30%;left:4%;font-size:28px" aria-hidden="true">✦</span>
                <span class="sparkle twinkle d2 hidden sm:block" style="top:10%;right:12%;font-size:16px" aria-hidden="true">✦</span>
                <span class="sparkle twinkle d3 hidden sm:block" style="top:64%;right:2%;font-size:12px" aria-hidden="true">✦</span>
                <span class="lg lg-soft inline-flex items-center gap-2 px-4 py-2 rounded-full text-[10px] font-extrabold tracking-[0.2em] uppercase text-sky-800 mb-6"><span class="text-amber-500 text-xs">✦</span> Courier</span>
                <h1 class="text-5xl md:text-7xl font-serif-display text-slate-900 mb-5 leading-[1.15]">Courier<br><span class="italic text-sky-700 text-shimmer">Dashboard.</span></h1>
                <p class="text-lg text-slate-700 leading-relaxed font-medium">Hello, <span class="font-bold text-slate-900">{{ auth()->user()->name }}</span>. You have full access to today’s delivery routes.</p>
            </header>

            <!-- STATUS -->
            <section class="cd-reveal cd-touch lg lg-spot rounded-[2rem] p-6 md:p-8 mb-6 flex flex-col lg:flex-row items-center justify-between gap-6">
                <div class="flex flex-col lg:flex-row items-center gap-6 w-full lg:w-auto">
                    <div id="gps-badge" class="lg lg-soft cd-gps"><span id="gps-dot" class="cd-dot"></span><span id="gps-text" class="text-[11px] font-bold tracking-wider uppercase truncate">Location Inactive</span></div>
                    <div class="grid grid-cols-3 gap-4 md:gap-8 text-center lg:text-left lg:border-l lg:border-white/70 lg:pl-8">
                        <div><p class="cd-cap">Completed Today</p><p class="text-xl font-bold text-slate-900"><span data-count="{{ $deliveredToday }}">{{ $deliveredToday }}</span> <span class="text-xs font-medium text-slate-500">Packages</span></p></div>
                        <div><p class="cd-cap">Today’s Earnings</p><p class="text-xl font-bold text-emerald-600" data-count="{{ (int) ($courier->today_earnings ?? 0) }}" data-prefix="Rp ">Rp {{ number_format($courier->today_earnings ?? 0, 0, ',', '.') }}</p></div>
                        <div><p class="cd-cap">Total Balance</p><div class="flex items-center justify-center lg:justify-start gap-2 flex-wrap"><p class="text-xl font-bold text-sky-700" data-count="{{ (int) ($courier->balance ?? 0) }}" data-prefix="Rp ">Rp {{ number_format($courier->balance ?? 0, 0, ',', '.') }}</p><button onclick="handleWithdrawClick()" class="lg lg-gold lg-btn auto-shine text-[11px] font-bold px-4 py-1.5 rounded-full">Withdraw</button></div></div>
                    </div>
                </div>
                <div class="w-full lg:w-auto flex justify-center">@if($courier->status === 'offline')
                <button id="btn-status" data-status="offline" class="cd-status lg lg-soft lg-btn "><span id="btn-text">Start Working</span><svg id="btn-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg><svg id="btn-spinner" class="hidden w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></button>
                @elseif($courier->status === 'on_delivery')
                <button type="button" disabled class="cd-status lg lg-soft"><svg class="w-5 h-5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>On Delivery</button>
                @else
                <button id="btn-status" data-status="available" class="cd-status lg lg-soft lg-btn is-online"><span id="btn-text">Go Offline</span><svg id="btn-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg><svg id="btn-spinner" class="hidden w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></button>
                @endif</div>
            </section>

            <!-- TARGET HARIAN -->
            <section id="goal" data-goal="{{ (int) ($courier->daily_goal ?? 500000) }}" data-earned="{{ (int) ($courier->today_earnings ?? 0) }}" class="cd-reveal cd-touch lg lg-soft rounded-[2rem] px-6 py-5 mb-8">
                <div class="flex items-center justify-between gap-3 mb-3 flex-wrap">
                    <div class="flex items-center gap-3"><span class="lg lg-gold w-9 h-9 rounded-full grid place-items-center text-base">🎯</span><div><p class="cd-cap">Daily Goal</p><p class="text-sm font-bold text-slate-900">Rp {{ number_format($courier->today_earnings ?? 0, 0, ',', '.') }} <span class="text-slate-500 font-medium">of Rp {{ number_format($courier->daily_goal ?? 500000, 0, ',', '.') }}</span></p></div></div>
                    <span id="goal-pct" class="lg lg-gold px-3 py-1 rounded-full text-xs font-bold">0%</span>
                </div>
                <div class="cd-bar"><i id="goal-fill"></i></div>
                <p id="goal-note" class="text-xs text-slate-500 mt-2"></p>
            </section>

            <!-- TUGAS -->
            <div class="cd-reveal mb-8 flex items-end justify-between border-b border-white/60 pb-4">
                <div><h2 class="text-3xl md:text-4xl font-serif-display text-slate-900">Active <span class="italic text-sky-700">Tasks.</span></h2><p class="text-slate-700 mt-1">List of orders you need to pick up or deliver.</p></div>
                <span class="lg lg-gold px-4 py-2 rounded-full text-sm font-bold">{{ $orders->count() }} Tasks</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 mb-12">
            @forelse($orders as $o)
            <article class="cd-reveal cd-touch cd-lift lg lg-spot rounded-[2rem] p-5 md:p-6 flex flex-col">
                <div class="flex items-center justify-between gap-3 mb-5">
                    <span class="lg {{ $o->status === 'shipped' ? 'lg-blue' : 'lg-gold' }} inline-flex items-center gap-2 px-4 py-2 rounded-full text-[10px] font-bold tracking-wider uppercase"><span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>{{ $o->status === 'shipped' ? 'On Delivery' : 'Ready for Pickup' }}</span>
                    <span class="lg lg-soft px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700">#{{ $o->order_number }}</span>
                </div>
                @if($o->payment_method === 'cod')
                <div class="lg lg-soft mb-4 px-4 py-2 rounded-2xl text-center text-xs font-bold text-red-600 tracking-wider">💵 CASH ON DELIVERY</div>
                @endif
                <div class="cd-route space-y-6 flex-1 mb-6">
                    <div class="relative"><span class="cd-pin cd-pin-gold"></span><p class="cd-cap mb-1">Pickup From</p><p class="text-lg font-bold text-slate-900 leading-tight">{{ $o->seller?->store_name }}</p><p class="text-sm text-slate-600 line-clamp-2">{{ $o->seller?->address }}</p></div>
                    <div class="relative"><span class="cd-pin cd-pin-sky"></span><p class="cd-cap mb-1">Deliver To</p><p class="text-lg font-bold text-slate-900 leading-tight">{{ $o->recipient_name }}</p><p class="text-sm text-slate-600 line-clamp-2 mb-2">{{ $o->shipping_address }}</p><a href="tel:{{ $o->recipient_phone }}" class="inline-flex items-center gap-1 text-xs font-bold text-sky-700 hover:underline">📞 {{ $o->recipient_phone }}</a></div>
                </div>
                <div class="flex gap-3 pt-4 border-t border-white/70">
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($o->shipping_address) }}" target="_blank" rel="noopener" class="lg lg-soft lg-btn flex-1 py-3 rounded-2xl font-bold text-center text-sm text-slate-900 flex items-center justify-center gap-2">🗺️ MAP</a>
                    @if($o->status === 'confirmed')
                    <form action="{{ route('courier.pickup', $o) }}" method="POST" class="flex-[2]">@csrf<button type="submit" class="lg lg-gold lg-btn w-full py-3 rounded-2xl font-bold text-sm">📦 PICKUP PACKAGE</button></form>
                    @else
                    <form action="{{ route('courier.deliver', $o) }}" method="POST" class="flex-[2]" onsubmit="return confirm('Make sure the package has been received. Continue?')">@csrf<button type="submit" class="lg lg-green lg-btn w-full py-3 rounded-2xl font-bold text-sm">✅ DELIVERED</button></form>
                    @endif
                </div>
            </article>
            @empty
            <div class="cd-reveal lg lg-spot md:col-span-2 rounded-[2rem] text-center py-16 px-6">
                <div class="float-y lg lg-soft w-20 h-20 rounded-full mx-auto grid place-items-center mb-5 text-3xl">🛵</div>
                <h3 class="text-2xl font-serif-display text-slate-900 mb-2">No Tasks Yet</h3>
                <p class="text-slate-600 mb-5">Take a short break. New tasks will appear here when the Admin assigns you.</p>
                <p id="offline-warning" class="lg lg-gold inline-block px-4 py-2 rounded-full text-sm font-bold {{ $courier->status !== 'offline' ? 'hidden' : '' }}">⚠️ You are Offline. Click “Start Working” above.</p>
            </div>
            @endforelse
            </div>

            <!-- LEADERBOARD + RATING -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <section class="cd-reveal lg lg-spot rounded-[2rem] p-6 md:col-span-2">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2"><span class="text-amber-500">✦</span> Top Couriers Today</h3>
                    <div class="space-y-3"><div class="cd-touch lg lg-soft rounded-2xl p-3 flex items-center justify-between"><div class="flex items-center gap-3"><span class="cd-rank lg lg-gold">1</span><span class="cd-av">A</span><div><p class="text-sm font-bold text-slate-900">Andi Wijaya</p><p class="text-xs text-slate-500">45 Packages</p></div></div><span class="text-sm font-bold text-emerald-600">⭐ 4.9</span></div><div class="cd-touch lg lg-soft rounded-2xl p-3 flex items-center justify-between ring-2 ring-sky-300/70"><div class="flex items-center gap-3"><span class="cd-rank lg lg-soft text-slate-500">2</span><span class="cd-av">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span><div><p class="text-sm font-bold text-slate-900">{{ auth()->user()->name }} (You)</p><p class="text-xs text-slate-500">{{ $deliveredToday }} Packages</p></div></div><span class="text-sm font-bold text-emerald-600">⭐ {{ $courier->rating ?? '5.0' }}</span></div><div class="cd-touch lg lg-soft rounded-2xl p-3 flex items-center justify-between"><div class="flex items-center gap-3"><span class="cd-rank lg lg-soft text-amber-700">3</span><span class="cd-av">C</span><div><p class="text-sm font-bold text-slate-900">Citra Dewi</p><p class="text-xs text-slate-500">38 Packages</p></div></div><span class="text-sm font-bold text-emerald-600">⭐ 4.8</span></div></div>
                </section>
                <section class="cd-reveal cd-touch lg lg-spot rounded-[2rem] p-6 flex flex-col items-center justify-center text-center">
                    <p class="cd-cap">Your Rating</p>
                    <div class="font-serif-display text-6xl text-slate-900 my-1">{{ $courier->rating ?? '5.0' }}</div>
                    <div class="float-y text-amber-500 text-xl tracking-widest mb-2">★★★★★</div>
                    <p class="text-xs text-slate-600">Based on {{ $courier->review_count ?? 0 }} customer reviews.</p><div class="grid grid-cols-2 gap-2 w-full mt-4"><div class="lg lg-soft rounded-2xl py-2"><p class="cd-cap">Acceptance</p><p class="font-bold text-slate-900">{{ isset($courier->acceptance_rate) ? $courier->acceptance_rate.'%' : '—' }}</p></div><div class="lg lg-soft rounded-2xl py-2"><p class="cd-cap">Completion</p><p class="font-bold text-slate-900">{{ isset($courier->completion_rate) ? $courier->completion_rate.'%' : '—' }}</p></div></div>
                </section>
            </div>

            <!-- GRAFIK -->
            <section class="cd-reveal lg lg-spot rounded-[2rem] p-6 md:p-8 mb-0">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div class="flex items-center gap-3">
                        <span class="lg lg-gold w-11 h-11 rounded-2xl grid place-items-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 17l6-6 4 4 8-8M14 7h7v7"></path></svg></span>
                        <div><h3 class="text-lg font-bold text-slate-900">Monthly Earnings</h3><p class="text-xs text-slate-500">Your income history since registration</p></div>
                    </div>
                    <select class="cd-select lg lg-soft"><option>Last 6 Months</option></select>
                </div>
                <div class="grid grid-cols-3 gap-3 mb-6 text-center">
                    <div class="lg lg-soft rounded-2xl py-3"><p class="cd-cap">Gross today</p><p class="font-bold text-slate-900">Rp {{ number_format($courier->today_gross ?? $courier->today_earnings ?? 0, 0, ',', '.') }}</p></div>
                    <div class="lg lg-soft rounded-2xl py-3"><p class="cd-cap">App fee</p><p class="font-bold text-rose-500">− Rp {{ number_format($courier->today_fee ?? 0, 0, ',', '.') }}</p></div>
                    <div class="lg lg-gold rounded-2xl py-3"><p class="cd-cap !text-amber-800">Net today</p><p class="font-bold">Rp {{ number_format($courier->today_earnings ?? 0, 0, ',', '.') }}</p></div>
                </div>
                <div class="w-full h-64 md:h-72 relative"><canvas id="earningsChart"></canvas></div>
            </section>
        </div>
    </div>
</main>

@if($orders->count())
@php $nx = $orders->first(); @endphp
<div class="md:hidden fixed bottom-4 inset-x-4 z-40 lg lg-soft rounded-full p-2 flex items-center gap-2">
    <div class="pl-3 min-w-0 flex-1"><p class="cd-cap">Next task</p><p class="text-sm font-bold text-slate-900 truncate">#{{ $nx->order_number }} · {{ $nx->recipient_name }}</p></div>
    <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($nx->shipping_address) }}" target="_blank" rel="noopener" class="lg lg-soft lg-btn w-11 h-11 rounded-full grid place-items-center" aria-label="Open map">🗺️</a>
    @if($nx->status === 'confirmed')
    <form action="{{ route('courier.pickup', $nx) }}" method="POST">@csrf<button type="submit" class="lg lg-gold lg-btn h-11 px-5 rounded-full font-bold text-sm">📦 Pickup</button></form>
    @else
    <form action="{{ route('courier.deliver', $nx) }}" method="POST" onsubmit="return confirm('Make sure the package has been received. Continue?')">@csrf<button type="submit" class="lg lg-green lg-btn h-11 px-5 rounded-full font-bold text-sm">✅ Delivered</button></form>
    @endif
</div>
@endif

<!-- MODAL WITHDRAW -->
<div id="withdraw-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/30 backdrop-blur-sm">
    <div class="cd-panel lg rounded-[2rem] p-6 md:p-8 w-full max-w-md mx-4 transform scale-95 transition-transform duration-300" id="withdraw-modal-content">
        <div class="flex justify-between items-center mb-6"><h3 class="text-2xl font-serif-display text-slate-900">Withdraw <span class="italic text-sky-700">Funds</span></h3><button onclick="closeWithdrawModal()" class="text-slate-400 hover:text-slate-700 transition" aria-label="Close"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button></div>
        <form id="withdraw-form" onsubmit="submitWithdrawal(event)">
            @csrf
            <div class="space-y-4">
                <div><label class="cd-label">Amount (Min. Rp 50,000)</label><input type="number" name="amount" min="50000" required class="cd-input text-lg font-bold" placeholder="100000"></div>
                <div><label class="cd-label">Payment Method</label><select name="bank_name" required class="cd-input cursor-pointer"><option value="" disabled selected>Select Bank / E-Wallet</option><optgroup label="Bank Transfer"><option value="BCA">BCA</option><option value="Mandiri">Mandiri</option><option value="BNI">BNI</option><option value="BRI">BRI</option></optgroup><optgroup label="E-Wallet"><option value="GoPay">GoPay</option><option value="OVO">OVO</option><option value="DANA">DANA</option><option value="ShopeePay">ShopeePay</option></optgroup></select></div>
                <div><label class="cd-label">Account Number</label><input type="text" name="account_number" required class="cd-input" placeholder="1234567890"></div>
                <div><label class="cd-label">Account Holder Name</label><input type="text" name="account_name" required class="cd-input" placeholder="John Doe"></div>
            </div>
            <button type="submit" id="btn-withdraw-submit" class="lg lg-gold lg-btn auto-shine w-full mt-6 py-4 rounded-2xl font-bold text-lg flex justify-center items-center gap-2"><span id="withdraw-btn-text">Process Withdrawal</span><svg id="withdraw-spinner" class="hidden w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></button>
        </form>
    </div>
</div>

<!-- MODAL EDIT PROFILE -->
<div id="profile-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/30 backdrop-blur-sm">
    <div class="cd-panel lg rounded-[2rem] p-6 md:p-8 w-full max-w-md mx-4 transform scale-95 transition-transform duration-300" id="profile-modal-content">
        <div class="flex justify-between items-center mb-6"><h3 class="text-2xl font-serif-display text-slate-900">Edit <span class="italic text-sky-700">Profile</span></h3><button onclick="closeProfileModal()" class="text-slate-400 hover:text-slate-700 transition" aria-label="Close"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button></div>
        <form id="profile-form" onsubmit="submitProfileUpdate(event)">
            @csrf
            <div class="space-y-4">
                <div><label class="cd-label">Full Name</label><input type="text" name="name" value="{{ auth()->user()->name }}" required class="cd-input"></div>
                <div><label class="cd-label">Phone Number</label><input type="text" name="phone" value="{{ $courier->phone ?? '' }}" required class="cd-input"></div>
                <div><label class="cd-label">Vehicle Type</label><input type="text" name="vehicle_type" value="{{ $courier->vehicle_type ?? '' }}" required class="cd-input" placeholder="Motorcycle, Car, etc."></div>
                <div><label class="cd-label">License Plate</label><input type="text" name="vehicle_plate" value="{{ $courier->vehicle_plate ?? '' }}" required class="cd-input" placeholder="B 1234 XYZ"></div>
            </div>
            <button type="submit" id="btn-profile-submit" class="lg lg-blue lg-btn w-full mt-6 py-4 rounded-2xl font-bold text-lg"><span id="profile-btn-text">Save Changes</span></button>
        </form>
    </div>
</div>

<!-- TOAST -->
<div id="toast" class="fixed bottom-24 md:bottom-10 left-1/2 -translate-x-1/2 z-[60] transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
    <div class="lg lg-soft rounded-full px-6 py-3 flex items-center gap-3"><span class="lg lg-green w-6 h-6 rounded-full grid place-items-center text-xs">✓</span><span id="toast-message" class="font-bold text-sm text-slate-900">Success!</span></div>
</div>

@endsection