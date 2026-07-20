@extends('layouts.app')

@section('title', __('messages.shopping_cart') . ' - DarkCommerce')

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">{{ __('messages.shopping_cart') }}</h1>
                @if(count($cartItems) > 0)
                    <p class="text-zinc-400 text-sm mt-1">{{ count($cartItems) }} {{ __('messages.items') }}</p>
                @endif
            </div>
            <a href="{{ route('products.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm flex items-center gap-1 group">
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> {{ __('messages.continue_shopping') }}
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        @if(count($cartItems) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="cart-item bg-[#111111] border border-white/5 rounded-2xl p-5 hover:border-white/10 transition-all duration-300 group">
                            <div class="flex gap-5">
                                <!-- Product Image -->
                                <a href="{{ route('products.show', $item['product']->slug) }}" class="w-24 h-24 bg-dark-800 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden group-hover:ring-2 ring-indigo-500/20 transition-all">
                                    @if($item['product']->primary_image)
                                        <img src="{{ $item['product']->primary_image->url }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <i class="fa-solid fa-box-open text-3xl text-zinc-600"></i>
                                    @endif
                                </a>

                                <!-- Product Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start gap-4">
                                        <div class="min-w-0">
                                            <a href="{{ route('products.show', $item['product']->slug) }}" class="text-lg font-semibold text-white hover:text-indigo-400 transition-colors line-clamp-1">{{ $item['product']->name }}</a>
                                            @if($item['product']->brand)
                                                <p class="text-sm text-indigo-400 mt-0.5">{{ $item['product']->brand->name }}</p>
                                            @endif
                                        </div>
                                        <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="flex-shrink-0">
                                            @csrf @method('DELETE')
                                            <button class="p-2 text-zinc-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-all">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Timer -->
                                    @if(isset($item['time_left']) && $item['time_left'] > 0)
                                        <div class="mt-2 flex items-center gap-1.5 text-xs"
                                             x-data="{ timeLeft: Math.floor({{ $item['time_left'] }}), expired: false }"
                                             x-init="setInterval(() => { if (timeLeft > 0) timeLeft--; else expired = true }, 1000)">
                                            <template x-if="!expired">
                                                <span class="flex items-center gap-1.5" :class="timeLeft < 300 ? 'text-red-400' : timeLeft < 900 ? 'text-yellow-400' : 'text-zinc-500'">
                                                    <i class="fa-regular fa-clock"></i>
                                                    <span x-text="Math.floor(timeLeft / 60) + ':' + String(timeLeft % 60).padStart(2, '0')"></span>
                                                    {{ __('messages.left') }}
                                                </span>
                                            </template>
                                            <template x-if="expired">
                                                <span class="text-red-400 flex items-center gap-1">
                                                    <i class="fa-solid fa-circle-exclamation"></i> {{ __('messages.expired') }}
                                                </span>
                                            </template>
                                        </div>
                                    @endif

                                    <!-- Quantity & Price -->
                                    <div class="flex items-center justify-between mt-4">
                                        <div class="flex items-center gap-1 bg-white/5 rounded-xl p-1">
                                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="flex items-center">
                                                @csrf @method('PUT')
                                                <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" 
                                                        class="w-9 h-9 flex items-center justify-center rounded-lg text-white hover:bg-white/10 transition-all">
                                                    <i class="fa-solid fa-minus text-xs"></i>
                                                </button>
                                            </form>
                                            <span class="w-10 text-center text-white font-semibold text-sm">{{ $item['quantity'] }}</span>
                                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="flex items-center">
                                                @csrf @method('PUT')
                                                <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" 
                                                        class="w-9 h-9 flex items-center justify-center rounded-lg text-white hover:bg-white/10 transition-all">
                                                    <i class="fa-solid fa-plus text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xl font-bold text-white">${{ number_format($item['subtotal'], 2) }}</p>
                                            @if($item['quantity'] > 1)
                                                <p class="text-xs text-zinc-500">${{ number_format($item['product']->final_price, 2) }} {{ __('messages.each') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 sticky top-24">
                        <h3 class="text-lg font-semibold text-white mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-receipt text-indigo-400"></i> {{ __('messages.order_summary') }}
                        </h3>
                        
                        <div class="space-y-3 mb-6 text-sm">
                            <div class="flex justify-between">
                                <span class="text-zinc-400">{{ __('messages.subtotal') }}</span>
                                <span class="text-white font-medium">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-zinc-400">{{ __('messages.shipping') }}</span>
                                <span class="{{ $total > 100 ? 'text-green-400' : 'text-white' }} font-medium">
                                    {{ $total > 100 ? __('messages.free') : '$10.00' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-zinc-400">{{ __('messages.tax') }}</span>
                                <span class="text-white font-medium">${{ number_format($total * 0.1, 2) }}</span>
                            </div>
                            @if(session('coupon'))
                                <div class="flex justify-between text-green-400">
                                    <span>{{ __('messages.coupon') }} ({{ session('coupon')['code'] }})</span>
                                    <span class="font-medium">-${{ number_format(session('coupon')['discount'], 2) }}</span>
                                </div>
                            @endif
                            @if(session('gift_card'))
                                <div class="flex justify-between text-indigo-400">
                                    <span>{{ __('messages.gift_card') }}</span>
                                    <span class="font-medium">-${{ number_format(min(session('gift_card')['balance'], $total), 2) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <hr class="border-white/5 mb-4">

                        <!-- Coupon Code -->
                        <div class="mb-4">
                            @if(session('coupon'))
                                <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4 mb-3">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-green-400 font-semibold text-sm">{{ session('coupon')['code'] }}</p>
                                            <p class="text-green-400/70 text-xs mt-0.5">
                                                @if(session('coupon')['type']==='percentage'){{ session('coupon')['value'] }}% {{ __('messages.off') }}@else${{ number_format(session('coupon')['value'],2) }} {{ __('messages.off') }}@endif
                                            </p>
                                        </div>
                                        <form action="{{ route('cart.coupon.remove') }}" method="POST">@csrf @method('DELETE')
                                            <button class="p-1.5 text-red-400 hover:bg-red-500/10 rounded-lg transition-all"><i class="fa-solid fa-xmark"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('cart.coupon.apply') }}" method="POST" class="flex gap-2 mb-3">
                                    @csrf
                                    <input type="text" name="code" placeholder="{{ __('messages.coupon_code') }}" 
                                           class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white text-sm placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 transition-all">
                                    <button type="submit" class="px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm hover:bg-white/10 transition-all">{{ __('messages.apply') }}</button>
                                </form>
                            @endif
                        </div>

                        <!-- Gift Card -->
                        <div class="mb-6">
                            @if(session('gift_card'))
                                <div class="bg-indigo-500/10 border border-indigo-500/20 rounded-xl p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-indigo-400 font-semibold text-sm">{{ session('gift_card')['code'] }}</p>
                                            <p class="text-indigo-400/70 text-xs">{{ __('messages.balance') }}: ${{ number_format(session('gift_card')['balance'],2) }}</p>
                                        </div>
                                        <form action="{{ route('gift-cards.remove') }}" method="POST">@csrf
                                            <button class="p-1.5 text-red-400 hover:bg-red-500/10 rounded-lg transition-all"><i class="fa-solid fa-xmark"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('gift-cards.verify') }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <input type="text" name="code" placeholder="{{ __('messages.gift_card_code') }}" 
                                           class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white text-sm placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 transition-all">
                                    <button type="submit" class="px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm hover:bg-white/10 transition-all">{{ __('messages.apply') }}</button>
                                </form>
                            @endif
                        </div>
                        
                        @php 
                            $shipping = $total > 100 ? 0 : 10; 
                            $tax = $total * 0.1; 
                            $couponDiscount = session('coupon') ? session('coupon')['discount'] : 0; 
                            $giftCardDiscount = session('gift_card') ? min(session('gift_card')['balance'], $total) : 0; 
                            $grandTotal = $total + $shipping + $tax - $couponDiscount - $giftCardDiscount; 
                        @endphp

                        <div class="flex justify-between mb-6 p-4 bg-white/[0.02] rounded-xl">
                            <span class="text-lg font-semibold text-white">{{ __('messages.total') }}</span>
                            <span class="text-2xl font-bold text-white">${{ number_format($grandTotal, 2) }}</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" 
                           class="block w-full text-center py-4 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105 hover:shadow-lg hover:shadow-indigo-500/25">
                            <i class="fa-solid fa-lock mr-2"></i> {{ __('messages.proceed_checkout') }}
                        </a>
                        
                        <p class="text-center text-xs text-zinc-500 mt-3 flex items-center justify-center gap-1">
                            <i class="fa-solid fa-clock"></i> {{ __('messages.items_reserved') }}
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20">
                <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-6">
                    <i class="fa-solid fa-cart-shopping text-4xl text-zinc-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">{{ __('messages.empty_cart') }}</h3>
                <p class="text-zinc-400 mb-8">{{ __('messages.empty_cart_desc') }}</p>
                <a href="{{ route('products.index') }}" 
                   class="px-8 py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105 hover:shadow-lg hover:shadow-indigo-500/25">
                    <i class="fa-solid fa-bag-shopping mr-2"></i> {{ __('messages.start_shopping') }}
                </a>
            </div>
        @endif
    </div>
</div>
@endsection