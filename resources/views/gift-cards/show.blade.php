@extends('layouts.app')

@section('title', 'Gift Card - DarkCommerce')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center bg-[#09090B]">
    <div class="text-center max-w-lg mx-auto px-4">
        <div class="w-24 h-24 mx-auto mb-6 bg-indigo-500/10 rounded-full flex items-center justify-center">
            <i class="fa-solid fa-gift text-4xl text-indigo-400"></i>
        </div>
        <h1 class="text-3xl font-bold text-white mb-4">Gift Card Created!</h1>
        <p class="text-zinc-400 mb-8">Your gift card has been sent to {{ $giftCard->to_email }}</p>
        
        <div class="bg-[#111111] border border-white/5 rounded-2xl p-8 mb-8">
            <p class="text-zinc-400 text-sm mb-2">Gift Card Code</p>
            <p class="text-3xl font-mono font-bold text-indigo-400 mb-4">{{ $giftCard->code }}</p>
            <p class="text-white text-2xl font-bold">${{ number_format($giftCard->amount, 2) }}</p>
            <p class="text-zinc-500 text-sm mt-2">Expires: {{ $giftCard->expires_at->format('M d, Y') }}</p>
        </div>
        
        <a href="{{ route('home') }}" class="px-8 py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all">Back to Home</a>
    </div>
</div>
@endsection