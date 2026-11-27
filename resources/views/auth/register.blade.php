@extends('layouts.app')

@section('title', 'Loka — Sign Up')

@section('content')
@php
    $field = 'w-full bg-white/50 border border-white/70 rounded-2xl px-4 py-3 text-slate-900 placeholder-slate-500 outline-none focus:ring-2 focus:ring-sky-400/50 transition';
    $label = 'block text-xs font-bold tracking-wide uppercase text-slate-600 mb-1.5';
@endphp

{{-- transisi halaman halus (aman bila sudah ada di layout) --}}

<div class="sky" aria-hidden="true">
    <div class="cloud-pic" style="top:4%;left:-4%;--w:420px;--d:18s"></div>
    <div class="cloud-pic" style="top:22%;right:-3%;--w:520px;--d:22s;--dl:-6s"></div>
    <div class="cloud-pic" style="top:48%;left:-6%;--w:380px;--d:15s;--dl:-3s"></div>
    <div class="cloud-pic" style="top:66%;right:2%;--w:460px;--d:20s;--dl:-9s"></div>
    <div class="cloud-pic" style="top:84%;left:8%;--w:340px;--d:17s;--dl:-2s"></div>
</div>

<main class="relative z-10 min-h-screen flex items-center justify-center px-4 sm:px-6 py-12">
    <div class="relative w-full max-w-lg rounded-[3rem]">
        <div class="lg bg-white/10 absolute inset-0 rounded-[3rem] pointer-events-none" aria-hidden="true">
            <div class="pane-glow"><i class="g1"></i><i class="g2"></i><i class="g3"></i></div>
        </div>

        <div class="relative z-10 p-8 md:p-10">

            <div class="text-center mb-8">
                <a href="{{ url('/') }}" data-instant class="font-serif-display text-2xl text-slate-900">Loka</a>
                <h1 class="text-4xl md:text-5xl font-serif-display text-slate-900 mt-5 mb-3 leading-tight">
                    Join<br><span class="italic text-sky-700">Loka.</span>
                </h1>
                <p class="text-slate-700 text-sm">Create an account to discover exceptional items.</p>
            </div>

            <x-flash />

            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf

                @php $type = old('account_type', 'customer'); @endphp
                <div>
                    <label class="{{ $label }}" for="account_type">Account Type</label>
                    <select id="account_type" name="account_type" class="{{ $field }}" required>
                        <option value="customer" @selected($type === 'customer')>Customer — I want to shop</option>
                        <option value="seller" @selected($type === 'seller')>Seller — I want to sell products</option>
                        <option value="courier" @selected($type === 'courier')>Courier — I want to deliver orders</option>
                    </select>
                    @error('account_type')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="{{ $label }}" for="name">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Your name" autocomplete="name" class="{{ $field }}" required>
                    @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="{{ $label }}" for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" class="{{ $field }}" required>
                    @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="{{ $label }}" for="password">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" placeholder="Minimum 8 characters" autocomplete="new-password" minlength="8" class="{{ $field }} pr-12" required>
                        <button type="button" data-toggle-pw aria-label="Show password" class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 grid place-items-center rounded-full text-slate-500 hover:text-slate-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>
                    </div>
                    @error('password')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Field khusus Seller --}}
                <div data-role-fields="seller" class="space-y-4 hidden">
                    <div>
                        <label class="{{ $label }}" for="store_name">Store Name</label>
                        <input id="store_name" type="text" name="store_name" value="{{ old('store_name') }}" placeholder="Your store name" class="{{ $field }}">
                        @error('store_name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="{{ $label }}" for="store_address">Store Address</label>
                        <textarea id="store_address" name="store_address" rows="2" placeholder="Store address" class="{{ $field }} resize-none">{{ old('store_address') }}</textarea>
                        @error('store_address')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Field khusus Courier --}}
                <div data-role-fields="courier" class="space-y-4 hidden">
                    <div>
                        <label class="{{ $label }}" for="vehicle_type">Vehicle Type</label>
                        <select id="vehicle_type" name="vehicle_type" class="{{ $field }}">
                            <option value="motor" @selected(old('vehicle_type', 'motor') === 'motor')>Motorcycle</option>
                            <option value="mobil" @selected(old('vehicle_type') === 'mobil')>Car</option>
                        </select>
                        @error('vehicle_type')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="{{ $label }}" for="vehicle_plate">License Plate</label>
                        <input id="vehicle_plate" type="text" name="vehicle_plate" value="{{ old('vehicle_plate') }}" placeholder="e.g., BM 1234 AB" class="{{ $field }}">
                        @error('vehicle_plate')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Nomor HP: Seller & Courier --}}
                <div data-role-fields="seller courier" class="hidden">
                    <label class="{{ $label }}" for="phone">Phone Number</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="081234567890" autocomplete="tel" class="{{ $field }}">
                    @error('phone')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="lg lg-gold lg-btn w-full h-12 rounded-full text-sm font-bold mt-2">Create Account</button>
            </form>

            <p class="text-center text-sm text-slate-700 mt-7 font-medium">
                Already have an account?
                <a href="{{ route('login') }}" data-instant class="font-bold text-sky-700 hover:underline">Sign In</a>
            </p>

        </div>
    </div>
</main>

@push('scripts')
<script>
    (function () {
        var select = document.getElementById('account_type');
        if (!select) return;
        var groups = document.querySelectorAll('[data-role-fields]');

        function sync() {
            groups.forEach(function (g) {
                var show = g.dataset.roleFields.split(' ').indexOf(select.value) !== -1;
                g.classList.toggle('hidden', !show);
                // field tersembunyi dinonaktifkan agar tidak ikut tervalidasi/terkirim
                g.querySelectorAll('input, select, textarea').forEach(function (el) {
                    el.disabled = !show;
                    el.required = show && el.name !== 'vehicle_type';
                });
            });
        }
        select.addEventListener('change', sync);
        sync();
    })();
</script>
@endpush
@endsection