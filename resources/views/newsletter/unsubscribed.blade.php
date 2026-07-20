@extends('layouts.app')

@section('title', 'Unsubscribed - DarkCommerce')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
    <div class="text-center max-w-md mx-auto px-4">
        @if(isset($subscriber) && $subscriber)
            <div class="w-20 h-20 mx-auto mb-6 bg-zinc-800 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-envelope-circle-check text-3xl text-zinc-400"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-4">Unsubscribed</h1>
            <p class="text-zinc-400 mb-2">{{ $subscriber->email }}</p>
            <p class="text-zinc-500 text-sm mb-8">You've been unsubscribed from our newsletter.</p>
            
            <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 mb-8">
                <h3 class="text-white font-semibold mb-3">Changed your mind?</h3>
                <form action="{{ route('newsletter.resubscribe') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ $subscriber->email }}">
                    <button type="submit" class="w-full py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all">
                        <i class="fa-solid fa-rotate-left mr-1"></i> Re-subscribe
                    </button>
                </form>
            </div>
        @else
            <div class="w-20 h-20 mx-auto mb-6 bg-red-500/10 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-link-slash text-3xl text-red-400"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-4">Invalid Link</h1>
            <p class="text-zinc-400 mb-8">This unsubscribe link is invalid or expired.</p>
        @endif
        
        <a href="{{ route('home') }}" class="px-8 py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all inline-block">
            <i class="fa-solid fa-house mr-1"></i> Back to Home
        </a>
    </div>
</div>
@endsection