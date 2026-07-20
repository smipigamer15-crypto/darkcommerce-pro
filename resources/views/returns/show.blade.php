@extends('layouts.app')

@section('title', 'Return ' . $return->rma_number)

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="max-w-2xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-2">Return #{{ $return->rma_number }}</h1>
        
        <span class="px-3 py-1 text-xs rounded-full 
            {{ $return->status === 'approved' ? 'bg-green-500/10 text-green-400' : '' }}
            {{ $return->status === 'pending' ? 'bg-yellow-500/10 text-yellow-400' : '' }}
            {{ $return->status === 'rejected' ? 'bg-red-500/10 text-red-400' : '' }}
            {{ $return->status === 'completed' ? 'bg-blue-500/10 text-blue-400' : '' }}">
            {{ ucfirst($return->status) }}
        </span>

        <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 mt-6 space-y-4">
            <div>
                <p class="text-zinc-400 text-sm">Order</p>
                <p class="text-white">#{{ $return->order->order_number }}</p>
            </div>
            <div>
                <p class="text-zinc-400 text-sm">Reason</p>
                <p class="text-white">{{ $return->reason }}</p>
            </div>
            <div>
                <p class="text-zinc-400 text-sm">Method</p>
                <p class="text-white">{{ ucfirst(str_replace('_', ' ', $return->return_method)) }}</p>
            </div>
            @if($return->admin_notes)
                <div class="bg-dark-800 rounded-xl p-4">
                    <p class="text-zinc-400 text-sm">Admin Response</p>
                    <p class="text-white">{{ $return->admin_notes }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection