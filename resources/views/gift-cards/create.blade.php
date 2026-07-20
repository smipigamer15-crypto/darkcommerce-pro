@extends('layouts.app')

@section('title', __('messages.buy_gift_card') . ' - DarkCommerce')

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 bg-indigo-500/10 rounded-2xl flex items-center justify-center">
                <i class="fa-solid fa-gift text-2xl text-indigo-400"></i>
            </div>
            <h1 class="text-3xl font-bold">{{ __('messages.gift_card') }}</h1>
            <p class="text-zinc-400 mt-2">{{ __('messages.gift_card_desc') }}</p>
        </div>

        <form action="{{ route('gift-cards.store') }}" method="POST" class="bg-[#111111] border border-white/5 rounded-2xl p-8">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-zinc-400 mb-3">{{ __('messages.amount') }} *</label>
                <div class="grid grid-cols-3 sm:grid-cols-5 gap-3">
                    @foreach([25, 50, 100, 200, 500] as $amount)
                        <label>
                            <input type="radio" name="amount" value="{{ $amount }}" class="peer hidden" {{ $amount == 50 ? 'checked' : '' }}>
                            <span class="block text-center py-3.5 bg-white/5 border border-white/10 rounded-xl cursor-pointer peer-checked:bg-indigo-500 peer-checked:border-indigo-500 peer-checked:text-white text-white font-semibold hover:border-white/20 transition-all">${{ $amount }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">{{ __('messages.from') }} *</label>
                    <input type="text" name="from_name" required value="{{ auth()->user()->name ?? '' }}" 
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                </div>
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">{{ __('messages.to') }} *</label>
                    <input type="text" name="to_name" required 
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-zinc-400 mb-2">{{ __('messages.recipient_email') }} *</label>
                <input type="email" name="to_email" required 
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all">
            </div>

            <div class="mb-6">
                <label class="block text-sm text-zinc-400 mb-2">{{ __('messages.message_optional') }}</label>
                <textarea name="message" rows="3" 
                          class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all resize-none" 
                          placeholder="{{ __('messages.gift_message_placeholder') }}"></textarea>
            </div>

            <button type="submit" class="w-full py-4 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105 hover:shadow-lg hover:shadow-indigo-500/25 flex items-center justify-center gap-2">
                <i class="fa-solid fa-credit-card"></i> {{ __('messages.purchase_gift_card') }}
            </button>
        </form>
    </div>
</div>
@endsection