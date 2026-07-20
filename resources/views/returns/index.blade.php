@extends('layouts.app')

@section('title', __('messages.my_returns') . ' - DarkCommerce')

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold">{{ __('messages.my_returns') }}</h1>
            <a href="{{ route('orders.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm flex items-center gap-1 group">
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> {{ __('messages.back_to_orders') }}
            </a>
        </div>

        @if($returns->count() > 0)
            <div class="space-y-4">
                @foreach($returns as $return)
                    <a href="{{ route('returns.show', $return) }}" class="block bg-[#111111] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition-all group">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-dark-800 rounded-xl flex items-center justify-center group-hover:bg-indigo-500/10 transition-all">
                                    <i class="fa-solid fa-rotate-left text-zinc-400 group-hover:text-indigo-400 transition-colors"></i>
                                </div>
                                <div>
                                    <p class="text-white font-semibold">RMA #{{ $return->rma_number }}</p>
                                    <p class="text-zinc-400 text-sm">{{ __('messages.order_number', ['number' => $return->order->order_number]) }}</p>
                                    <p class="text-zinc-500 text-xs mt-1">{{ $return->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1.5 text-xs font-medium rounded-full flex-shrink-0
                                {{ $return->status === 'approved' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : '' }}
                                {{ $return->status === 'pending' ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20' : '' }}
                                {{ $return->status === 'rejected' ? 'bg-red-500/10 text-red-400 border border-red-500/20' : '' }}
                                {{ $return->status === 'completed' ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20' : '' }}">
                                {{ ucfirst($return->status) }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-8">{{ $returns->links() }}</div>
        @else
            <div class="flex flex-col items-center justify-center py-20">
                <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-6">
                    <i class="fa-solid fa-box-open text-4xl text-zinc-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">{{ __('messages.no_returns') }}</h3>
                <p class="text-zinc-400 mb-8">{{ __('messages.no_returns_desc') }}</p>
                <a href="{{ route('orders.index') }}" class="px-8 py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105">
                    <i class="fa-solid fa-list-check mr-2"></i>{{ __('messages.view_orders') }}
                </a>
            </div>
        @endif
    </div>
</div>
@endsection