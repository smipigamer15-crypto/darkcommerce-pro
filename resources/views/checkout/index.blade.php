@extends('layouts.app')

@section('title', __('messages.checkout') . ' - DarkCommerce')

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8">{{ __('messages.checkout') }}</h1>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Forms -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Contact Info -->
                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-6">
                        <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                            <span class="w-8 h-8 bg-indigo-500/10 rounded-lg flex items-center justify-center"><i class="fa-solid fa-user text-indigo-400 text-sm"></i></span>
                            {{ __('messages.contact_info') }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-zinc-400 mb-2">{{ __('messages.first_name') }} *</label>
                                <input type="text" name="first_name" required value="{{ auth()->user()->name ?? '' }}"
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm text-zinc-400 mb-2">{{ __('messages.last_name') }} *</label>
                                <input type="text" name="last_name" required 
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm text-zinc-400 mb-2">{{ __('messages.email') }} *</label>
                                <input type="email" name="email" required value="{{ auth()->user()->email ?? '' }}"
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm text-zinc-400 mb-2">{{ __('messages.phone') }} *</label>
                                <input type="tel" name="phone" required 
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-6">
                        <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                            <span class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center"><i class="fa-solid fa-truck-fast text-green-400 text-sm"></i></span>
                            {{ __('messages.shipping_address') }}
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-zinc-400 mb-2">{{ __('messages.address') }} *</label>
                                <input type="text" name="address" required 
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm text-zinc-400 mb-2">{{ __('messages.city') }} *</label>
                                    <input type="text" name="city" required 
                                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm text-zinc-400 mb-2">{{ __('messages.postal_code') }} *</label>
                                    <input type="text" name="postal_code" required 
                                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm text-zinc-400 mb-2">{{ __('messages.country') }} *</label>
                                    <input type="text" name="country" required 
                                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-6">
                        <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                            <span class="w-8 h-8 bg-purple-500/10 rounded-lg flex items-center justify-center"><i class="fa-solid fa-credit-card text-purple-400 text-sm"></i></span>
                            {{ __('messages.payment_method') }}
                        </h2>
                        <div class="space-y-3">
                            <label class="flex items-center gap-4 p-4 bg-dark-800 border border-white/5 rounded-xl cursor-pointer hover:border-indigo-500/30 transition-all group">
                                <input type="radio" name="payment_method" value="card" checked class="w-5 h-5 text-indigo-500 bg-white/5 border-white/10 focus:ring-indigo-500/20">
                                <div class="flex-1">
                                    <p class="text-white font-medium flex items-center gap-2"><i class="fa-regular fa-credit-card text-indigo-400"></i> {{ __('messages.cash_delivery') }}</p>
                                    <p class="text-zinc-400 text-xs mt-0.5">Pay when you receive your order</p>
                                </div>
                                <i class="fa-solid fa-check-circle text-indigo-500 opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></i>
                            </label>
                            <label class="flex items-center gap-4 p-4 bg-dark-800 border border-white/5 rounded-xl cursor-pointer hover:border-indigo-500/30 transition-all group">
                                <input type="radio" name="payment_method" value="stripe" class="w-5 h-5 text-indigo-500 bg-white/5 border-white/10 focus:ring-indigo-500/20">
                                <div class="flex-1">
                                    <p class="text-white font-medium flex items-center gap-2"><i class="fa-brands fa-stripe text-indigo-400"></i> {{ __('messages.pay_stripe') }}</p>
                                    <p class="text-zinc-400 text-xs mt-0.5">Secure payment via Stripe</p>
                                </div>
                                <i class="fa-solid fa-check-circle text-indigo-500 opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></i>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 sticky top-24">
                        <h3 class="text-lg font-semibold text-white mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-receipt text-indigo-400"></i> {{ __('messages.order_summary') }}
                        </h3>
                        
                        <!-- Cart Items -->
                        <div class="space-y-3 mb-6">
                            @foreach($cartItems as $item)
                                <div class="flex gap-3 p-2 bg-dark-800 rounded-xl">
                                    <div class="w-12 h-12 bg-dark-700 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                        @if($item['product']->primary_image)
                                            <img src="{{ $item['product']->primary_image->url }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-box text-zinc-600"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-white truncate">{{ $item['product']->name }}</p>
                                        <p class="text-xs text-zinc-400">Qty: {{ $item['quantity'] }}</p>
                                    </div>
                                    <p class="text-sm text-white font-medium">${{ number_format($item['product']->final_price * $item['quantity'], 2) }}</p>
                                </div>
                            @endforeach
                        </div>

                        <hr class="border-white/5 mb-4">

                        <!-- Totals -->
                        <div class="space-y-2 text-sm mb-4">
                            <div class="flex justify-between">
                                <span class="text-zinc-400">{{ __('messages.subtotal') }}</span>
                                <span class="text-white font-medium">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-zinc-400">{{ __('messages.shipping') }}</span>
                                <span class="{{ $shipping == 0 ? 'text-green-400' : 'text-white' }} font-medium">
                                    {{ $shipping == 0 ? __('messages.free') : '$' . number_format($shipping, 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-zinc-400">{{ __('messages.tax') }}</span>
                                <span class="text-white font-medium">${{ number_format($tax, 2) }}</span>
                            </div>
                            @if(session('coupon'))
                                <div class="flex justify-between text-green-400">
                                    <span>{{ __('messages.coupon') }}</span>
                                    <span class="font-medium">-${{ number_format(session('coupon')['discount'], 2) }}</span>
                                </div>
                            @endif
                            @if(session('gift_card'))
                                <div class="flex justify-between text-indigo-400">
                                    <span>{{ __('messages.gift_card') }}</span>
                                    <span class="font-medium">-${{ number_format(min(session('gift_card')['balance'], $subtotal), 2) }}</span>
                                </div>
                            @endif
                        </div>

                                              <!-- Use Points Checkbox -->
                        @auth
                            @if(auth()->user()->points > 0)
                                <div class="mb-4 p-4 bg-gradient-to-r from-indigo-500/5 to-purple-500/5 border border-indigo-500/10 rounded-xl">
                                    <label class="flex items-center justify-between cursor-pointer">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 bg-indigo-500/10 rounded-lg flex items-center justify-center">
                                                <i class="fa-solid fa-coins text-indigo-400 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-white text-sm font-medium">{{ __('messages.use_points') }}</p>
                                                <p class="text-zinc-500 text-xs">{{ auth()->user()->points }} {{ __('messages.points') }} = <span class="text-indigo-400">${{ number_format(auth()->user()->points_value, 2) }}</span></p>
                                            </div>
                                        </div>
                                        <input type="checkbox" name="use_points" value="1" class="w-5 h-5 rounded bg-white/5 border-white/10 text-indigo-500 focus:ring-indigo-500/20">
                                    </label>
                                </div>
                            @endif
                        @endauth

                        <hr class="border-white/5 my-4">

                        <!-- Total -->
                        <div class="flex justify-between mb-6 p-4 bg-white/[0.02] rounded-xl">
                            <span class="text-lg font-semibold text-white">{{ __('messages.total') }}</span>
                            <span class="text-2xl font-bold text-white">${{ number_format($total, 2) }}</span>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="w-full py-4 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105 hover:shadow-lg hover:shadow-indigo-500/25 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-lock"></i> {{ __('messages.place_order') }} — ${{ number_format($total, 2) }}
                        </button>
                        
                        <p class="text-center text-xs text-zinc-500 mt-3 flex items-center justify-center gap-1">
                            <i class="fa-solid fa-shield-halved"></i> {{ __('messages.secured_checkout') }}
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection