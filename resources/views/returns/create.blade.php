@extends('layouts.app')

@section('title', __('messages.return_order_title', ['number' => $order->order_number]) . ' - DarkCommerce')

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="max-w-2xl mx-auto px-4 py-8">
        <a href="{{ route('orders.show', $order) }}" class="text-indigo-400 hover:text-indigo-300 text-sm mb-6 inline-block flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> {{ __('messages.back_to_order') }}
        </a>
        
        <h1 class="text-3xl font-bold mb-2">{{ __('messages.return_request') }}</h1>
        <p class="text-zinc-400 mb-8">{{ __('messages.return_request_desc') }}</p>
        
        <!-- Order Info -->
        <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-dark-800 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-zinc-400"></i>
                </div>
                <div>
                    <p class="text-white font-semibold">{{ __('messages.order_number', ['number' => $order->order_number]) }}</p>
                    <p class="text-zinc-400 text-sm">{{ __('messages.order_total') }}: <span class="text-white font-medium">${{ number_format($order->total, 2) }}</span></p>
                    <p class="text-zinc-500 text-xs mt-1">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Return Form -->
        <form action="{{ route('returns.store', $order) }}" method="POST" class="bg-[#111111] border border-white/5 rounded-2xl p-6">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-zinc-400 mb-2">
                    <i class="fa-solid fa-circle-exclamation text-red-400 mr-1"></i> {{ __('messages.return_reason') }} *
                </label>
                <textarea name="reason" rows="4" required 
                          class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all resize-none" 
                          placeholder="{{ __('messages.return_reason_placeholder') }}"></textarea>
                <p class="text-zinc-500 text-xs mt-1">{{ __('messages.return_reason_hint') }}</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-zinc-400 mb-3">{{ __('messages.return_method') }}</label>
                <div class="space-y-3">
                    <label class="flex items-center gap-4 p-4 bg-dark-800 border border-white/5 rounded-xl cursor-pointer hover:border-indigo-500/30 transition-all group">
                        <input type="radio" name="return_method" value="refund" checked class="w-5 h-5 text-indigo-500">
                        <div class="flex-1">
                            <p class="text-white font-medium">{{ __('messages.refund_payment') }}</p>
                            <p class="text-zinc-400 text-xs">{{ __('messages.refund_payment_desc') }}</p>
                        </div>
                        <i class="fa-solid fa-money-bill-wave text-green-400 text-lg"></i>
                    </label>
                    <label class="flex items-center gap-4 p-4 bg-dark-800 border border-white/5 rounded-xl cursor-pointer hover:border-indigo-500/30 transition-all group">
                        <input type="radio" name="return_method" value="exchange" class="w-5 h-5 text-indigo-500">
                        <div class="flex-1">
                            <p class="text-white font-medium">{{ __('messages.exchange_item') }}</p>
                            <p class="text-zinc-400 text-xs">{{ __('messages.exchange_item_desc') }}</p>
                        </div>
                        <i class="fa-solid fa-rotate text-blue-400 text-lg"></i>
                    </label>
                    <label class="flex items-center gap-4 p-4 bg-dark-800 border border-white/5 rounded-xl cursor-pointer hover:border-indigo-500/30 transition-all group">
                        <input type="radio" name="return_method" value="store_credit" class="w-5 h-5 text-indigo-500">
                        <div class="flex-1">
                            <p class="text-white font-medium">{{ __('messages.store_credit') }}</p>
                            <p class="text-zinc-400 text-xs">{{ __('messages.store_credit_desc') }}</p>
                        </div>
                        <i class="fa-solid fa-gift text-purple-400 text-lg"></i>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105 hover:shadow-lg hover:shadow-indigo-500/25 flex items-center justify-center gap-2">
                <i class="fa-solid fa-paper-plane"></i> {{ __('messages.submit_return') }}
            </button>
            
            <p class="text-zinc-500 text-xs text-center mt-4">{{ __('messages.return_note') }}</p>
        </form>
    </div>
</div>
@endsection