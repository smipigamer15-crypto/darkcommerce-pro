@extends('layouts.app')

@section('title', __('messages.my_orders') . ' - DarkCommerce')

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold">{{ __('messages.my_orders') }}</h1>
            <a href="{{ route('profile.edit') }}" class="text-indigo-400 hover:text-indigo-300 transition-colors text-sm flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> {{ __('messages.back_to_profile') }}
            </a>
        </div>

        @php $orders = \App\Models\Order::where('user_id', auth()->id())->latest()->paginate(10); @endphp

        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                    <a href="{{ route('orders.show', $order) }}" class="block bg-[#111111] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition-all group">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-dark-800 rounded-xl flex items-center justify-center text-xl group-hover:bg-indigo-500/10 transition-all">
                                    <i class="fa-solid fa-box-open text-zinc-400 group-hover:text-indigo-400 transition-colors"></i>
                                </div>
                                <div>
                                    <p class="text-white font-semibold">{{ __('messages.order_number', ['number' => $order->order_number]) }}</p>
                                    <p class="text-zinc-400 text-sm">{{ $order->created_at->format('M d, Y') }} · {{ $order->items->count() }} {{ __('messages.items') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <p class="text-xl font-bold text-white">${{ number_format($order->total, 2) }}</p>
                                <span class="px-3 py-1 text-xs font-medium rounded-full 
                                    @switch($order->status)
                                        @case('delivered') bg-green-500/10 text-green-400 @break
                                        @case('shipped') bg-blue-500/10 text-blue-400 @break
                                        @case('processing') bg-purple-500/10 text-purple-400 @break
                                        @case('cancelled') bg-red-500/10 text-red-400 @break
                                        @default bg-yellow-500/10 text-yellow-400
                                    @endswitch">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-8">{{ $orders->links() }}</div>
        @else
            <div class="flex flex-col items-center justify-center py-20">
                <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mb-6">
                    <i class="fa-solid fa-box-open text-3xl text-zinc-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">{{ __('messages.no_orders_yet') }}</h3>
                <p class="text-zinc-400 mb-6">{{ __('messages.no_orders_desc') }}</p>
                <a href="{{ route('products.index') }}" class="px-8 py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105">
                    <i class="fa-solid fa-bag-shopping mr-2"></i>{{ __('messages.start_shopping') }}
                </a>
            </div>
        @endif
    </div>
</div>
@endsection