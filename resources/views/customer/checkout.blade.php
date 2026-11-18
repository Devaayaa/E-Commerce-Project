@extends('layouts.app')

@section('title', 'Loka — Checkout')

@section('content')
<main class="max-w-6xl mx-auto px-6 pt-32 pb-32 relative">
    
    <!-- Background Glow Effect -->
    <div class="absolute top-20 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-blue-200/50 rounded-full blur-[120px] pointer-events-none -z-10"></div>

    <!-- Header -->
    <div class="text-center mb-12 checkout-anim">
        <h1 class="text-4xl md:text-5xl font-serif-display text-slate-900 mb-4">Checkout</h1>
        <p class="text-slate-500">Complete your order safely and quickly.</p>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: Address & Payment -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- 1. Shipping Details -->
                <div class="checkout-anim bg-white/70 backdrop-blur-xl border border-white rounded-[2rem] p-8 shadow-xl shadow-blue-900/5">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">1</div>
                        <h2 class="text-xl font-bold text-slate-900">Shipping Details</h2>
                    </div>
                    
                    <div class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Recipient Name</label>
                                <input type="text" name="name" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all text-sm" placeholder="Full name" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Phone Number</label>
                                <input type="tel" name="phone" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all text-sm" placeholder="0812xxxxxx" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Full Address</label>
                            <textarea name="address" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all text-sm" placeholder="Street, RT/RW, District, City, Postal Code" required></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. Payment Method -->
                <div class="checkout-anim bg-white/70 backdrop-blur-xl border border-white rounded-[2rem] p-8 shadow-xl shadow-blue-900/5">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">2</div>
                        <h2 class="text-xl font-bold text-slate-900">Payment Method</h2>
                    </div>

                    <div class="space-y-3">
                        <!-- Bank Transfer -->
                        <label class="relative flex items-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 hover:border-slate-300 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/50 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                            <input type="radio" name="payment_method" value="bank_transfer" class="w-5 h-5 text-blue-600 border-slate-300 focus:ring-blue-500" checked>
                            <div class="ml-4 flex items-center gap-3">
                                <span class="text-2xl">🏦</span>
                                <div>
                                    <span class="block text-sm font-bold text-slate-900">Bank Transfer</span>
                                    <span class="block text-xs text-slate-500">BCA, Mandiri, BNI, BRI</span>
                                </div>
                            </div>
                        </label>

                        <!-- E-Wallet -->
                        <label class="relative flex items-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 hover:border-slate-300 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/50 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                            <input type="radio" name="payment_method" value="e_wallet" class="w-5 h-5 text-blue-600 border-slate-300 focus:ring-blue-500">
                            <div class="ml-4 flex items-center gap-3">
                                <span class="text-2xl">📱</span>
                                <div>
                                    <span class="block text-sm font-bold text-slate-900">E-Wallet</span>
                                    <span class="block text-xs text-slate-500">GoPay, OVO, Dana, ShopeePay</span>
                                </div>
                            </div>
                        </label>

                        <!-- Credit Card -->
                        <label class="relative flex items-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 hover:border-slate-300 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/50 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                            <input type="radio" name="payment_method" value="credit_card" class="w-5 h-5 text-blue-600 border-slate-300 focus:ring-blue-500">
                            <div class="ml-4 flex items-center gap-3">
                                <span class="text-2xl">💳</span>
                                <div>
                                    <span class="block text-sm font-bold text-slate-900">Credit / Debit Card</span>
                                    <span class="block text-xs text-slate-500">Visa, Mastercard, JCB</span>
                                </div>
                            </div>
                        </label>

                        <!-- COD -->
                        <label class="relative flex items-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 hover:border-slate-300 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/50 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                            <input type="radio" name="payment_method" value="cod" class="w-5 h-5 text-blue-600 border-slate-300 focus:ring-blue-500">
                            <div class="ml-4 flex items-center gap-3">
                                <span class="text-2xl">🚚</span>
                                <div>
                                    <span class="block text-sm font-bold text-slate-900">Cash on Delivery (COD)</span>
                                    <span class="block text-xs text-slate-500">Pay cash when the package arrives</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Order Summary -->
            <div class="lg:col-span-5 relative">
                <div class="checkout-anim bg-gradient-to-br from-white/90 to-blue-50/80 backdrop-blur-2xl border border-white rounded-[2rem] p-8 shadow-2xl shadow-blue-900/10 sticky top-32 overflow-hidden">
                    
                    <h2 class="text-xl font-bold text-slate-900 mb-6 border-b border-blue-100 pb-4">Order Summary</h2>
                    
                    <!-- Product List -->
                    <div class="space-y-4 mb-6 max-h-[40vh] overflow-y-auto hide-scrollbar">
                        @php $subtotal = 0; @endphp
                        @foreach($cart as $details)
                            @php $subtotal += $details['price'] * $details['quantity']; @endphp
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded-xl border border-slate-100 flex items-center justify-center text-2xl shadow-sm">
                                    {{ $details['emoji'] ?? '📦' }}
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-sm text-slate-800 line-clamp-1">{{ $details['name'] }}</p>
                                    <p class="text-xs text-slate-500">Qty: {{ $details['quantity'] }}</p>
                                </div>
                                <p class="font-semibold text-sm text-slate-800">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Cost Breakdown -->
                    <div class="space-y-3 text-sm border-t border-blue-100 pt-4">
                        <div class="flex justify-between text-slate-500">
                            <span>Subtotal</span>
                            <span class="text-slate-800 font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Shipping</span>
                            <span class="text-emerald-500 font-bold bg-emerald-50 px-2 py-0.5 rounded-md">Free</span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Tax (0%)</span>
                            <span class="text-slate-800 font-medium">Rp 0</span>
                        </div>
                    </div>

                    <!-- Final Total -->
                    <div class="mt-6 pt-6 border-t border-blue-100">
                        <div class="flex justify-between items-end mb-6">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Total Payment</p>
                                <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Pay Button -->
                        <button type="submit" class="w-full py-4 bg-gradient-to-r from-blue-600 to-blue-500 text-white font-bold rounded-xl hover:from-blue-700 hover:to-blue-600 transition-all shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2 hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Pay Now
                        </button>
                        
                        <div class="flex items-center justify-center gap-2 mt-4 text-xs text-slate-400">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Secure & Encrypted Transaction
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof gsap !== 'undefined') {
            gsap.from(".checkout-anim", {
                y: 40,
                opacity: 0,
                duration: 0.8,
                stagger: 0.15,
                ease: "power3.out",
                clearProps: "all"
            });
        }
    });
</script>
@endpush