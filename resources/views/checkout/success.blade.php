@extends('layouts.app')

@section('title', __('messages.order_confirmed') . ' - DarkCommerce')

@section('content')
<div class="min-h-screen bg-[#09090B] py-20">
    <div class="max-w-3xl mx-auto px-4">
        
        <div class="text-center mb-12">
            <div class="relative inline-flex">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full shadow-2xl shadow-green-500/20 mb-6 animate-bounce">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="absolute -top-2 -right-2 text-3xl"></span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-3">{{ __('messages.order_confirmed') }}</h1>
            <p class="text-zinc-400 text-lg">{{ __('messages.thank_you') }}</p>
            <div class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-[#111111] border border-white/5 rounded-full">
                <span class="text-zinc-400 text-sm">{{ __('messages.order_number', ['number' => '']) }}</span>
                <span class="text-white font-mono font-bold">{{ $order->order_number }}</span>
            </div>
        </div>


        @if(session('points_earned'))
            <div class="bg-gradient-to-r from-indigo-500/10 to-purple-500/10 border border-indigo-500/20 rounded-2xl p-6 mb-6 flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-coins text-indigo-400 text-xl"></i>
                </div>
                <div>
                    <p class="text-white font-semibold">+{{ session('points_earned') }} {{ __('messages.points_earned') }}</p>
                    <p class="text-zinc-400 text-sm">{{ __('messages.points_worth') }} ${{ number_format(session('points_earned') / 100, 2) }} {{ __('messages.on_next_order') }}</p>
                </div>
            </div>
        @endif


        <div class="bg-[#111111] border border-white/5 rounded-3xl overflow-hidden mb-6">

            <div class="p-6 md:p-8">
                <h3 class="text-white font-semibold text-lg mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-indigo-500/10 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-box-open text-indigo-400 text-sm"></i>
                    </span>
                    {{ __('messages.items') }} ({{ $order->items->count() }})
                </h3>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 p-3 bg-dark-800 rounded-xl hover:bg-dark-700 transition-colors">
                            <div class="w-12 h-12 bg-dark-700 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                                @php $product = \App\Models\Product::find($item->product_id); @endphp
                                @if($product && $product->primary_image)
                                    <img src="{{ $product->primary_image->url }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-box text-zinc-600"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white text-sm font-medium truncate">{{ $item->product_name }}</p>
                                <p class="text-zinc-500 text-xs">{{ __('messages.qty') }}: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                            </div>
                            <p class="text-white font-bold">${{ number_format($item->subtotal, 2) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-white/5 p-6 md:p-8 bg-white/[0.02]">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-zinc-400">{{ __('messages.subtotal') }}</span>
                        <span class="text-white font-medium">${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-zinc-400">{{ __('messages.shipping') }}</span>
                        <span class="text-white font-medium">{{ $order->shipping > 0 ? '$' . number_format($order->shipping, 2) : __('messages.free') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-zinc-400">{{ __('messages.tax') }}</span>
                        <span class="text-white font-medium">${{ number_format($order->tax, 2) }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between text-green-400">
                            <span>{{ __('messages.discount') }} @if($order->coupon_code)({{ $order->coupon_code }})@endif</span>
                            <span class="font-medium">-${{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif
                </div>
                <div class="flex justify-between items-center mt-4 pt-4 border-t border-white/5">
                    <span class="text-white font-semibold text-lg">{{ __('messages.total') }}</span>
                    <span class="text-3xl font-bold text-white">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            @if($order->shipping_address)
                <div class="bg-[#111111] border border-white/5 rounded-2xl p-6">
                    <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center"><i class="fa-solid fa-truck-fast text-blue-400 text-sm"></i></span>
                        {{ __('messages.shipping_details') }}
                    </h3>
                    <div class="text-sm text-zinc-400 space-y-1">
                        <p class="text-white font-medium">{{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}</p>
                        <p>{{ $order->shipping_address['address'] }}</p>
                        <p>{{ $order->shipping_address['city'] }}, {{ $order->shipping_address['postal_code'] }}</p>
                        <p>{{ $order->shipping_address['country'] }}</p>
                        <p class="text-zinc-500 mt-1">{{ $order->shipping_address['phone'] }}</p>
                    </div>
                </div>
            @endif
            <div class="bg-[#111111] border border-white/5 rounded-2xl p-6">
                <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 bg-yellow-500/10 rounded-lg flex items-center justify-center"><i class="fa-solid fa-clock text-yellow-400 text-sm"></i></span>
                    {{ __('messages.order_status') }}
                </h3>
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-500/10 border border-yellow-500/20 rounded-full text-yellow-400 text-sm font-medium">
                    <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></span> {{ ucfirst($order->status) }}
                </span>
                <p class="text-zinc-500 text-xs mt-3">{{ __('messages.updates_email') }}</p>
                @if($order->status === 'pending')
                    <p class="text-zinc-500 text-xs mt-1">{{ __('messages.estimated_processing') }}</p>
                @endif
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('orders.show', $order) }}" class="px-8 py-4 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-2xl transition-all hover:scale-105 hover:shadow-lg hover:shadow-indigo-500/25 flex items-center justify-center gap-2">
                <i class="fa-solid fa-magnifying-glass"></i> {{ __('messages.track_order') }}
            </a>
            <a href="{{ route('products.index') }}" class="px-8 py-4 border border-white/10 text-white font-semibold rounded-2xl hover:bg-white/5 transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-bag-shopping"></i> {{ __('messages.continue_shopping') }}
            </a>
        </div>

    </div>
</div>
@endsection