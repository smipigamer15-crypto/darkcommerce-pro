@extends('layouts.app')

@section('title', $query ? __('messages.search_results_for', ['query' => $query]) : __('messages.search_products') . ' - DarkCommerce')

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search Form -->
        <div class="mb-10">
            <form action="{{ route('search') }}" method="GET">
                <div class="relative max-w-2xl mx-auto">
                    <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-zinc-500 text-lg"></i>
                    <input type="text" name="q" value="{{ $query }}" 
                           placeholder="{{ __('messages.search_placeholder') }}" autofocus
                           class="w-full pl-14 pr-24 py-5 bg-white/5 border border-white/10 rounded-2xl text-white text-lg placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-8 py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105 hover:shadow-lg hover:shadow-indigo-500/25">
                        {{ __('messages.search') }}
                    </button>
                </div>
            </form>
        </div>

        @if($query)
            <div class="mb-6">
                <p class="text-zinc-400 text-sm">
                    <span class="text-white font-semibold">{{ $products->total() }}</span> {{ __('messages.results_for') }} "<span class="text-white font-semibold">{{ $query }}</span>"
                </p>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach($products as $product)
                        <div class="group bg-[#111111] rounded-2xl border border-white/5 overflow-hidden hover:border-white/10 transition-all duration-500 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-indigo-500/5">
                            <a href="{{ route('products.show', $product->slug) }}" class="block aspect-square bg-gradient-to-br from-dark-800 to-dark-900 relative overflow-hidden">
                                @if($product->primary_image)
                                    <img src="{{ $product->primary_image->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-6xl group-hover:scale-110 transition-transform">📦</div>
                                @endif
                                @if($product->discount_price)
                                    <div class="absolute top-3 left-3"><span class="px-3 py-1.5 text-xs font-bold bg-red-500 text-white rounded-full shadow-lg">-{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%</span></div>
                                @endif
                            </a>
                            <div class="p-5">
                                @if($product->brand)<p class="text-xs font-medium text-indigo-400 uppercase tracking-wider mb-2">{{ $product->brand->name }}</p>@endif
                                <h3 class="text-sm font-semibold text-white mb-3 line-clamp-2 hover:text-indigo-400 transition-colors">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>
                                <div class="flex items-center justify-between">
                                    <div>
                                        @if($product->discount_price)<span class="text-xl font-bold text-white">${{ number_format($product->discount_price, 2) }}</span><span class="ml-2 text-sm text-zinc-500 line-through">${{ number_format($product->price, 2) }}</span>
                                        @else<span class="text-xl font-bold text-white">${{ number_format($product->price, 2) }}</span>@endif
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST">@csrf<input type="hidden" name="product_id" value="{{ $product->id }}"><button class="p-2.5 bg-indigo-500 rounded-xl opacity-0 group-hover:opacity-100 hover:scale-110 transition-all"><i class="fa-solid fa-cart-plus text-white text-sm"></i></button></form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-10">{{ $products->appends(['q' => $query])->links() }}</div>
            @else
                <div class="flex flex-col items-center justify-center py-20">
                    <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-6">
                        <i class="fa-solid fa-magnifying-glass text-4xl text-zinc-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">{{ __('messages.no_results') }}</h3>
                    <p class="text-zinc-400 mb-8">{{ __('messages.no_results_desc', ['query' => $query]) }}</p>
                    <a href="{{ route('products.index') }}" class="px-8 py-3 bg-indigo-500 text-white rounded-xl hover:scale-105">{{ __('messages.browse_all') }}</a>
                </div>
            @endif
        @else
            <div class="max-w-2xl mx-auto">
                @if(count($searchHistory) > 0)
                    <div class="mb-10">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2"><i class="fa-solid fa-clock-rotate-left text-indigo-400"></i> {{ __('messages.recent_searches') }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($searchHistory as $term)
                                <a href="{{ route('search', ['q' => $term]) }}" class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-zinc-300 hover:text-white hover:border-white/20 hover:bg-white/10 transition-all">{{ $term }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2"><i class="fa-solid fa-fire text-orange-400"></i> {{ __('messages.popular_searches') }}</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($popularSearches as $term)
                            <a href="{{ route('search', ['q' => $term]) }}" class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-zinc-300 hover:text-white hover:border-white/20 hover:bg-white/10 transition-all">{{ $term }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection