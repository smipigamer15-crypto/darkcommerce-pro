@extends('layouts.app')

@section('title', __('messages.order_number', ['number' => $order->order_number]) . ' - DarkCommerce')

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('orders.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm mb-6 inline-block">
            <i class="fa-solid fa-arrow-left mr-1"></i> {{ __('messages.back_to_orders') }}
        </a>

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">{{ __('messages.order_number', ['number' => $order->order_number]) }}</h1>
                <p class="text-zinc-400 mt-1">{{ $order->created_at->format('F d, Y') }}</p>
            </div>
            <span class="px-4 py-2 text-sm font-medium rounded-full 
                @switch($order->status)
                    @case('delivered') bg-green-500/10 text-green-400 @break
                    @case('shipped') bg-blue-500/10 text-blue-400 @break
                    @case('processing') bg-purple-500/10 text-purple-400 @break
                    @case('cancelled') bg-red-500/10 text-red-400 @break
                    @case('refunded') bg-zinc-500/10 text-zinc-400 @break
                    @default bg-yellow-500/10 text-yellow-400
                @endswitch">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        @if($order->status === 'delivered')
            <div class="mb-6">
                <a href="{{ route('returns.create', $order) }}" class="inline-flex items-center gap-2 px-4 py-2 border border-red-500/20 text-red-400 rounded-xl hover:bg-red-500/10 transition-all text-sm">
                    <i class="fa-solid fa-rotate-left"></i> {{ __('messages.return_order') }}
                </a>
            </div>
        @endif

        <!-- Progress Bar -->
        <div class="bg-[#111111] border border-white/5 rounded-2xl p-8 mb-6">
            <h2 class="text-lg font-semibold text-white mb-8">{{ __('messages.order_status') }}</h2>
            @php
                $statuses = ['pending', 'paid', 'processing', 'shipped', 'delivered'];
                $currentIndex = array_search($order->status, $statuses);
                if ($order->status === 'cancelled') $currentIndex = -1;
                if ($order->status === 'refunded') $currentIndex = -2;
            @endphp

            @if($order->status === 'cancelled')
                <div class="text-center py-6">
                    <div class="w-16 h-16 mx-auto mb-4 bg-red-500/10 rounded-full flex items-center justify-center"><i class="fa-solid fa-xmark text-2xl text-red-400"></i></div>
                    <p class="text-red-400 font-semibold text-lg">{{ __('messages.order_cancelled') }}</p>
                </div>
            @elseif($order->status === 'refunded')
                <div class="text-center py-6">
                    <div class="w-16 h-16 mx-auto mb-4 bg-zinc-500/10 rounded-full flex items-center justify-center"><i class="fa-solid fa-rotate-left text-2xl text-zinc-400"></i></div>
                    <p class="text-zinc-400 font-semibold text-lg">{{ __('messages.order_refunded') }}</p>
                </div>
            @else
                <div class="relative">
                    <div class="absolute top-5 left-0 right-0 h-0.5 bg-white/5"><div class="h-full bg-indigo-500 transition-all duration-500" style="width: {{ $currentIndex >= 0 ? ($currentIndex / (count($statuses) - 1)) * 100 : 0 }}%"></div></div>
                    <div class="relative flex justify-between">
                        @foreach($statuses as $index => $status)
                            @php $isCompleted = $index < $currentIndex; $isCurrent = $index === $currentIndex; $isPending = $index > $currentIndex; @endphp
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-all z-10 {{ $isCompleted ? 'bg-indigo-500 text-white' : '' }} {{ $isCurrent ? 'bg-indigo-500 text-white ring-4 ring-indigo-500/20 animate-pulse' : '' }} {{ $isPending ? 'bg-white/5 text-zinc-500 border border-white/10' : '' }}">
                                    @if($isCompleted)<i class="fa-solid fa-check"></i>@else{{ $index + 1 }}@endif
                                </div>
                                <span class="text-xs mt-2 font-medium {{ $isCompleted || $isCurrent ? 'text-white' : 'text-zinc-500' }}">{{ ucfirst($status) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Order Items -->
        <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 mb-6">
            <h2 class="text-lg font-semibold text-white mb-4">{{ __('messages.items') }}</h2>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 py-3 border-b border-white/5 last:border-0">
                        <div class="w-16 h-16 bg-dark-800 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                            @php $product = \App\Models\Product::find($item->product_id); @endphp
                            @if($product && $product->primary_image)<img src="{{ $product->primary_image->url }}" class="w-full h-full object-cover">@else<i class="fa-solid fa-box text-zinc-600 text-xl"></i>@endif
                        </div>
                        <div class="flex-1"><p class="text-white font-medium">{{ $item->product_name }}</p><p class="text-zinc-400 text-sm">{{ __('messages.qty') }}: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p></div>
                        <p class="text-white font-bold">${{ number_format($item->subtotal, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 mb-6">
            <h2 class="text-lg font-semibold text-white mb-4">{{ __('messages.order_summary') }}</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-zinc-400">{{ __('messages.subtotal') }}</span><span class="text-white">${{ number_format($order->subtotal, 2) }}</span></div>
                <div class="flex justify-between"><span class="text-zinc-400">{{ __('messages.shipping') }}</span><span class="text-white">{{ $order->shipping > 0 ? '$' . number_format($order->shipping, 2) : __('messages.free') }}</span></div>
                <div class="flex justify-between"><span class="text-zinc-400">{{ __('messages.tax') }}</span><span class="text-white">${{ number_format($order->tax, 2) }}</span></div>
                @if($order->discount > 0)<div class="flex justify-between text-green-400"><span>{{ __('messages.discount') }}</span><span>-${{ number_format($order->discount, 2) }}</span></div>@endif
                <hr class="border-white/5 my-2">
                <div class="flex justify-between text-lg font-bold"><span class="text-white">{{ __('messages.total') }}</span><span class="text-white">${{ number_format($order->total, 2) }}</span></div>
            </div>
        </div>

        @if($order->shipping_address)
            <div class="bg-[#111111] border border-white/5 rounded-2xl p-6">
                <h2 class="text-lg font-semibold text-white mb-4"><i class="fa-solid fa-truck-fast mr-2"></i> {{ __('messages.shipping_details') }}</h2>
                <div class="text-sm text-zinc-400 space-y-1">
                    <p class="text-white font-medium">{{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}</p>
                    <p>{{ $order->shipping_address['address'] }}</p>
                    <p>{{ $order->shipping_address['city'] }}, {{ $order->shipping_address['postal_code'] }}</p>
                    <p>{{ $order->shipping_address['country'] }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection