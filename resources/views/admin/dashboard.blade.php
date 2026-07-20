@extends('layouts.admin')

@section('title', 'Admin Dashboard - DarkCommerce')

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">Admin Dashboard</h1>
                <p class="text-zinc-400 mt-1">Welcome back, {{ auth()->user()->name }}</p>
            </div>
            <div class="flex items-center gap-3">
                <form action="{{ route('push.test') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2.5 bg-indigo-500 hover:bg-indigo-400 text-white rounded-xl text-sm font-medium transition-all hover:scale-105 flex items-center gap-2">
                        <i class="fa-solid fa-bell"></i> Send Test Push
                    </button>
                </form>
                <a href="{{ route('admin.products.create') }}" class="px-6 py-3 bg-green-500 hover:bg-green-400 text-white font-semibold rounded-xl transition-all hover:scale-105">
                    + Add Product
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-[#111111] border border-white/5 rounded-2xl p-6">
                <p class="text-zinc-400 text-sm mb-2">Total Revenue</p>
                <p class="text-3xl font-bold text-white">${{ number_format($total_revenue, 2) }}</p>
                <p class="text-green-400 text-sm mt-2">+${{ number_format($revenue_today, 2) }} today</p>
            </div>
            <div class="bg-[#111111] border border-white/5 rounded-2xl p-6">
                <p class="text-zinc-400 text-sm mb-2">Orders</p>
                <p class="text-3xl font-bold text-white">{{ $total_orders }}</p>
                <p class="text-blue-400 text-sm mt-2">{{ $orders_today }} today</p>
            </div>
            <div class="bg-[#111111] border border-white/5 rounded-2xl p-6">
                <p class="text-zinc-400 text-sm mb-2">Products</p>
                <p class="text-3xl font-bold text-white">{{ $total_products }}</p>
                <p class="text-red-400 text-sm mt-2">{{ $out_of_stock }} out of stock</p>
            </div>
            <div class="bg-[#111111] border border-white/5 rounded-2xl p-6">
                <p class="text-zinc-400 text-sm mb-2">Customers</p>
                <p class="text-3xl font-bold text-white">{{ $total_users }}</p>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 mb-8">
            <h2 class="text-xl font-semibold text-white mb-6">Recent Orders</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-zinc-400 text-sm">
                            <th class="pb-4">Order #</th>
                            <th class="pb-4">Customer</th>
                            <th class="pb-4">Total</th>
                            <th class="pb-4">Status</th>
                            <th class="pb-4">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($recent_orders as $order)
                            <tr>
                                <td class="py-4 text-white font-medium">{{ $order->order_number }}</td>
                                <td class="py-4 text-white">{{ $order->user->name }}</td>
                                <td class="py-4 text-white">${{ number_format($order->total, 2) }}</td>
                                <td class="py-4">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $order->status === 'delivered' ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-4 text-zinc-400">{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock Alert -->
        @if($low_stock->count() > 0)
            <div class="bg-[#111111] border border-red-500/20 rounded-2xl p-6">
                <h2 class="text-xl font-semibold text-red-400 mb-4">⚠️ Low Stock Alert</h2>
                <div class="space-y-3">
                    @foreach($low_stock as $product)
                        <div class="flex items-center justify-between p-3 bg-red-500/5 rounded-xl">
                            <div>
                                <p class="text-white font-medium">{{ $product->name }}</p>
                                <p class="text-zinc-400 text-sm">SKU: {{ $product->sku }}</p>
                            </div>
                            <span class="px-3 py-1 bg-red-500/10 text-red-400 text-sm rounded-full">
                                {{ $product->stock }} left
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection