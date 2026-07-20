@extends('layouts.app')

@section('title', __('messages.products') . ' - DarkCommerce')

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <!-- Filters Bar -->
    <div class="sticky top-16 z-40 bg-[#09090B]/95 backdrop-blur-xl border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form method="GET" class="space-y-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1 group">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-zinc-500 group-focus-within:text-indigo-400 transition-colors"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search') }}..."
                               class="w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                    </div>
                    <button type="submit" class="px-6 py-3.5 bg-indigo-500 hover:bg-indigo-400 text-white font-medium rounded-xl transition-all hover:scale-105 hover:shadow-lg hover:shadow-indigo-500/25 flex items-center gap-2">
                        <i class="fa-solid fa-search"></i> {{ __('messages.search') }}
                    </button>
                    @if(request('search') || request('sort') || request('min_price') || request('max_price'))
                        <a href="{{ route('products.index') }}" class="px-6 py-3.5 bg-red-500/10 border border-red-500/20 text-red-400 hover:bg-red-500/20 rounded-xl transition-all flex items-center gap-2">
                            <i class="fa-solid fa-xmark"></i> {{ __('messages.clear') }}
                        </a>
                    @endif
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <div class="relative group">
                        <select name="sort" class="appearance-none bg-[#111111] border border-white/10 rounded-xl pl-4 pr-10 py-3 text-white text-sm focus:outline-none focus:border-indigo-500/50 cursor-pointer hover:border-white/20 transition-all">
                            <option value="newest" class="bg-[#111111] text-white">{{ __('messages.newest') }}</option>
                            <option value="price_asc" class="bg-[#111111] text-white">{{ __('messages.price_low') }}</option>
                            <option value="price_desc" class="bg-[#111111] text-white">{{ __('messages.price_high') }}</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 pointer-events-none text-xs group-hover:text-white transition-colors"></i>
                    </div>
                    <div class="flex items-center gap-2 bg-[#111111] border border-white/10 rounded-xl px-1 py-1">
                        <div class="relative">
                            <i class="fa-solid fa-dollar-sign absolute left-3 top-1/2 -translate-y-1/2 text-zinc-500 text-xs"></i>
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-24 pl-7 pr-3 py-2 bg-transparent text-white text-sm placeholder-zinc-500 focus:outline-none">
                        </div>
                        <span class="text-zinc-600">—</span>
                        <div class="relative">
                            <i class="fa-solid fa-dollar-sign absolute left-3 top-1/2 -translate-y-1/2 text-zinc-500 text-xs"></i>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-24 pl-7 pr-3 py-2 bg-transparent text-white text-sm placeholder-zinc-500 focus:outline-none">
                        </div>
                    </div>
                    <div class="relative group">
                        <select name="category" class="appearance-none bg-[#111111] border border-white/10 rounded-xl pl-4 pr-10 py-3 text-white text-sm focus:outline-none focus:border-indigo-500/50 cursor-pointer hover:border-white/20 transition-all">
                            <option value="" class="bg-[#111111] text-white">{{ __('messages.all_categories') }}</option>
                            @foreach(\App\Models\Category::all() as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }} class="bg-[#111111] text-white">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 pointer-events-none text-xs group-hover:text-white transition-colors"></i>
                    </div>
                    @if(request('search') || request('category') || request('min_price') || request('max_price'))
                        <div class="flex items-center gap-2 flex-wrap">
                            @if(request('search'))<span class="px-3 py-1.5 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs rounded-full">"{{ request('search') }}"</span>@endif
                            @if(request('category'))@php $cat = \App\Models\Category::find(request('category')); @endphp<span class="px-3 py-1.5 bg-purple-500/10 border border-purple-500/20 text-purple-400 text-xs rounded-full">{{ $cat->name ?? 'Category' }}</span>@endif
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @php
            $query = \App\Models\Product::with(['brand', 'categories', 'images'])->where('is_active', true);
            if (request('search')) $query->where('name', 'like', '%' . request('search') . '%');
            if (request('category')) $query->whereHas('categories', fn($q) => $q->where('categories.id', request('category')));
            if (request('min_price')) $query->where('price', '>=', request('min_price'));
            if (request('max_price')) $query->where('price', '<=', request('max_price'));
            switch (request('sort')) {case 'price_asc': $query->orderBy('price', 'asc'); break; case 'price_desc': $query->orderBy('price', 'desc'); break; default: $query->latest();}
            $products = $query->paginate(12);
        @endphp

        <div class="flex items-center justify-between mb-4">
            <p class="text-zinc-400 text-sm">
                @if($products->count() > 0)
                    <span class="text-white font-semibold">{{ $products->total() }}</span> {{ __('messages.products_found') }}
                @else
                    {{ __('messages.no_products') }}
                @endif
            </p>
            <div class="flex items-center gap-2">
                <span class="text-zinc-500 text-xs">{{ __('messages.sort_by') }}:</span>
                <span class="text-white text-xs font-medium">{{ request('sort') === 'price_asc' ? __('messages.price_low') : (request('sort') === 'price_desc' ? __('messages.price_high') : __('messages.newest')) }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @forelse($products as $product)
                <div class="group relative bg-[#111111] rounded-2xl border border-white/5 overflow-hidden hover:border-white/10 transition-all duration-500 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-indigo-500/5">
                    <a href="{{ route('products.show', $product->slug) }}" class="block aspect-square bg-gradient-to-br from-dark-800 to-dark-900 relative overflow-hidden">
                        @if($product->primary_image)<img src="{{ $product->primary_image->url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else<div class="w-full h-full flex items-center justify-center"><i class="fa-solid fa-box-open text-6xl text-zinc-700 group-hover:scale-110 transition-transform"></i></div>@endif
                        @if($product->discount_price)<div class="absolute top-3 left-3"><span class="px-3 py-1.5 text-xs font-bold bg-red-500 text-white rounded-full shadow-lg shadow-red-500/20 backdrop-blur-sm">-{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%</span></div>@endif
                        @if($product->stock == 0)<div class="absolute top-3 right-3"><span class="px-3 py-1.5 text-xs font-bold bg-zinc-900/80 text-zinc-400 rounded-full backdrop-blur-sm"><i class="fa-solid fa-ban mr-1"></i> {{ __('messages.sold_out') }}</span></div>
                        @elseif($product->stock <= 5)<div class="absolute top-3 right-3"><span class="px-3 py-1.5 text-xs font-bold bg-yellow-500/80 text-white rounded-full backdrop-blur-sm"><i class="fa-solid fa-bolt mr-1"></i> {{ $product->stock }} left</span></div>@endif
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center"><span class="px-6 py-3 bg-white text-black font-semibold rounded-xl transform translate-y-4 group-hover:translate-y-0 transition-all duration-300"><i class="fa-solid fa-eye mr-2"></i>{{ __('messages.quick_view') }}</span></div>
                    </a>
                    <div class="p-5">
                        @if($product->brand)<p class="text-xs font-medium text-indigo-400 uppercase tracking-wider mb-2">{{ $product->brand->name }}</p>@endif
                        <h3 class="text-sm font-semibold text-white mb-3 line-clamp-2 leading-snug group-hover:text-indigo-400 transition-colors"><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
                        @if($product->reviews_count > 0)<div class="flex items-center gap-2 mb-3"><div class="flex items-center gap-0.5">@for($i=1;$i<=5;$i++)<i class="fa-solid fa-star text-[10px] {{ $i <= round($product->rating) ? 'text-yellow-400' : 'text-zinc-600' }}"></i>@endfor</div><span class="text-zinc-500 text-[11px]">({{ $product->reviews_count }})</span></div>@endif
                        <div class="flex items-end justify-between">
                            <div>@if($product->discount_price)<span class="text-xl font-bold text-white">${{ number_format($product->discount_price,2) }}</span><span class="ml-2 text-sm text-zinc-500 line-through">${{ number_format($product->price,2) }}</span>@else<span class="text-xl font-bold text-white">${{ number_format($product->price,2) }}</span>@endif</div>
                            <form action="{{ route('cart.add') }}" method="POST">@csrf<input type="hidden" name="product_id" value="{{ $product->id }}"><button {{ $product->stock==0?'disabled':'' }} class="p-2.5 rounded-xl transition-all {{ $product->stock>0?'bg-indigo-500 hover:bg-indigo-400 text-white hover:scale-110 hover:shadow-lg hover:shadow-indigo-500/25':'bg-zinc-800 text-zinc-500 cursor-not-allowed' }}"><i class="fa-solid fa-cart-plus text-sm"></i></button></form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-20">
                    <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-6"><i class="fa-solid fa-magnifying-glass text-4xl text-zinc-600"></i></div>
                    <h3 class="text-2xl font-bold text-white mb-2">{{ __('messages.no_products') }}</h3>
                    <p class="text-zinc-400 mb-8 text-center max-w-md">{{ __('messages.try_changing') }}</p>
                    <a href="{{ route('products.index') }}" class="px-8 py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105"><i class="fa-solid fa-arrow-left mr-2"></i>{{ __('messages.view_all_products') }}</a>
                </div>
            @endforelse
        </div>
        @if($products->hasPages())<div class="mt-12">{{ $products->appends(request()->query())->links() }}</div>@endif
    </div>
</div>
@endsection