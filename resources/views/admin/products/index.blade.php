@extends('layouts.admin')

@section('title', 'Products - Admin')

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold">Products</h1>
            <a href="{{ route('admin.products.create') }}" class="px-6 py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105">
                + Add Product
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-[#111111] border border-white/5 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-zinc-400 text-sm border-b border-white/5">
                        <th class="p-4">Product</th>
                        <th class="p-4">Price</th>
                        <th class="p-4">Stock</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($products as $product)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-dark-800 rounded-lg flex items-center justify-center">📦</div>
                                    <div>
                                        <p class="text-white font-medium">{{ $product->name }}</p>
                                        <p class="text-zinc-400 text-xs">{{ $product->sku }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                @if($product->discount_price)
                                    <span class="text-white">${{ number_format($product->discount_price, 2) }}</span>
                                    <span class="text-zinc-500 line-through text-sm ml-2">${{ number_format($product->price, 2) }}</span>
                                @else
                                    <span class="text-white">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($product->stock > 10)
                                    <span class="text-green-400">{{ $product->stock }}</span>
                                @elseif($product->stock > 0)
                                    <span class="text-yellow-400">{{ $product->stock }}</span>
                                @else
                                    <span class="text-red-400">Out of stock</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $product->is_active ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-400 hover:text-indigo-300">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-400 hover:text-red-300">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection