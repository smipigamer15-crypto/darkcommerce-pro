@extends('layouts.admin')

@section('title', 'Flash Sales - Admin')

@section('content')
<div class="p-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-white">Flash Sales</h1>
        <button onclick="document.getElementById('create-form').classList.toggle('hidden')" class="px-4 py-2.5 bg-indigo-500 text-white rounded-xl text-sm">+ New Flash Sale</button>
    </div>

    @if(session('success'))<div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>@endif

    <!-- Create Form -->
    <div id="create-form" class="hidden mb-8 bg-[#111111] border border-white/5 rounded-2xl p-6">
        <h2 class="text-lg font-semibold text-white mb-4">Create Flash Sale</h2>
        <form action="{{ route('admin.flash-sales.store') }}" method="POST" class="space-y-4">@csrf
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm text-zinc-400 mb-1">Title</label><input type="text" name="title" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white"></div>
                <div><label class="block text-sm text-zinc-400 mb-1">Discount %</label><input type="number" name="discount_percentage" value="20" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white"></div>
                <div><label class="block text-sm text-zinc-400 mb-1">Starts At</label><input type="datetime-local" name="starts_at" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white"></div>
                <div><label class="block text-sm text-zinc-400 mb-1">Ends At</label><input type="datetime-local" name="ends_at" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white"></div>
            </div>
            <div><label class="block text-sm text-zinc-400 mb-1">Products</label><div class="grid grid-cols-3 gap-2 max-h-40 overflow-y-auto">@foreach(\App\Models\Product::where('is_active',true)->get() as $product)<label class="flex items-center gap-2 p-2 bg-dark-800 rounded-lg"><input type="checkbox" name="products[]" value="{{ $product->id }}" class="text-indigo-500">{{ $product->name }}</label>@endforeach</div></div>
            <button type="submit" class="px-6 py-3 bg-indigo-500 text-white rounded-xl">Create Flash Sale</button>
        </form>
    </div>

    <!-- Active Flash Sales -->
    <div class="space-y-4">
        @foreach($flashSales as $flash)
            <div class="bg-[#111111] border {{ $flash->is_active ? 'border-red-500/20' : 'border-white/5' }} rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div><h3 class="text-white font-semibold text-lg">{{ $flash->title }}</h3><p class="text-zinc-400 text-sm">{{ $flash->starts_at->format('M d, H:i') }} - {{ $flash->ends_at->format('M d, H:i') }}</p></div>
                    <div class="flex items-center gap-2">
                        <form action="{{ route('admin.flash-sales.toggle', $flash) }}" method="POST">@csrf @method('PUT')<button class="px-3 py-1.5 text-xs rounded-full {{ $flash->is_active ? 'bg-green-500/10 text-green-400' : 'bg-zinc-500/10 text-zinc-400' }}">{{ $flash->is_active ? 'Active' : 'Inactive' }}</button></form>
                        <form action="{{ route('admin.flash-sales.delete', $flash) }}" method="POST">@csrf @method('DELETE')<button class="text-red-400 text-sm">Delete</button></form>
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-3">
                    @foreach($flash->products as $product)
                        <div class="bg-dark-800 rounded-xl p-3 text-center">
                            <p class="text-white text-sm truncate">{{ $product->name }}</p>
                            <p class="text-red-400 font-bold">${{ number_format($product->pivot->sale_price, 2) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection