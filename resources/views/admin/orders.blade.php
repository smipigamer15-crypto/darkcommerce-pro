@extends('layouts.admin')

@section('title', 'Orders - Admin')

@section('content')
<div class="p-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold">Orders</h1>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-[#111111] border border-white/5 rounded-2xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-zinc-400 text-sm border-b border-white/5">
                    <th class="p-4">Order #</th>
                    <th class="p-4">Customer</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Date</th>
                    <th class="p-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @foreach($orders as $order)
                    <tr class="hover:bg-white/5">
                        <td class="p-4 text-white font-mono">{{ $order->order_number }}</td>
                        <td class="p-4 text-white">{{ $order->user->name }}</td>
                        <td class="p-4 text-white font-bold">${{ number_format($order->total, 2) }}</td>
                        <td class="p-4">
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" 
                                        class="text-xs font-medium rounded-full px-3 py-1.5 cursor-pointer
                                        @switch($order->status)
                                            @case('pending') bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 @break
                                            @case('processing') bg-blue-500/10 text-blue-400 border border-blue-500/20 @break
                                            @case('shipped') bg-purple-500/10 text-purple-400 border border-purple-500/20 @break
                                            @case('delivered') bg-green-500/10 text-green-400 border border-green-500/20 @break
                                            @case('cancelled') bg-red-500/10 text-red-400 border border-red-500/20 @break
                                            @default bg-zinc-500/10 text-zinc-400 border border-zinc-500/20
                                        @endswitch">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td class="p-4 text-zinc-400 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="p-4">
                            <a href="{{ route('orders.show', $order) }}" class="text-indigo-400 hover:text-indigo-300 text-sm">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">{{ $orders->links() }}</div>
</div>
@endsection