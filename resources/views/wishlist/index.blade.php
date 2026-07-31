@extends('layouts.app')

@section('title', __('messages.wishlist') . ' - DarkCommerce')

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">{{ __('messages.wishlist') }}</h1>
                <p class="text-zinc-400 text-sm mt-1">{{ $wishlistItems->count() }} {{ __('messages.saved_items') }}</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm flex items-center gap-1 group">
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> {{ __('messages.continue_shopping') }}
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @if($wishlistItems->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($wishlistItems as $product)
                    <div class="group bg-[#111111] rounded-2xl border border-white/5 overflow-hidden hover:border-white/10 transition-all duration-500 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-indigo-500/5">
                        <a href="{{ route('products.show', $product->slug) }}" class="block aspect-square bg-gradient-to-br from-dark-800 to-dark-900 relative overflow-hidden">
                            @if($product->primary_image)
                                <img src="{{ $product->primary_image->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-6xl group-hover:scale-110 transition-transform"><i class="fa-solid fa-box-open"></i></div>
                            @endif
                            
                            @if($product->discount_price)
                                <div class="absolute top-3 left-3 z-10">
                                    <span class="px-3 py-1.5 text-xs font-bold bg-red-500 text-white rounded-full shadow-lg shadow-red-500/20">
                                        -{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                    </span>
                                </div>
                            @endif

                            @if($product->stock == 0)
                                <div class="absolute top-3 right-3 z-10">
                                    <span class="px-3 py-1.5 text-xs font-bold bg-zinc-900/80 text-zinc-400 rounded-full backdrop-blur-sm">
                                        {{ __('messages.sold_out') }}
                                    </span>
                                </div>
                            @endif

       
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="px-6 py-3 bg-white text-black font-semibold rounded-xl transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                    <i class="fa-solid fa-eye mr-2"></i>{{ __('messages.quick_view') }}
                                </span>
                            </div>
                        </a>

               
                        <div class="p-5">
                            @if($product->brand)
                                <p class="text-xs font-medium text-indigo-400 uppercase tracking-wider mb-2">{{ $product->brand->name }}</p>
                            @endif

                            <h3 class="text-sm font-semibold text-white mb-3 line-clamp-2 leading-snug group-hover:text-indigo-400 transition-colors">
                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>

        
                            @if($product->reviews_count > 0)
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star text-[10px] {{ $i <= round($product->rating) ? 'text-yellow-400' : 'text-zinc-600' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-zinc-500 text-[11px]">({{ $product->reviews_count }})</span>
                                </div>
                            @endif

          
                            <div class="flex items-end justify-between mb-4">
                                <div>
                                    @if($product->discount_price)
                                        <span class="text-xl font-bold text-white">${{ number_format($product->discount_price, 2) }}</span>
                                        <span class="ml-2 text-sm text-zinc-500 line-through">${{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="text-xl font-bold text-white">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                                @if($product->stock == 0)
                                    <span class="text-xs text-red-400 font-medium">{{ __('messages.out_of_stock') }}</span>
                                @elseif($product->stock <= 5)
                                    <span class="text-xs text-yellow-400 font-medium"><i class="fa-solid fa-bolt mr-1"></i> {{ $product->stock }} {{ __('messages.left') }}</span>
                                @endif
                            </div>

                  
                        
<div class="flex items-center gap-2">
    <form action="{{ route('wishlist.addToCart', $product) }}" method="POST" class="flex-1">
        @csrf
        <button {{ $product->stock == 0 ? 'disabled' : '' }}
                class="w-full h-11 rounded-xl text-sm font-semibold transition-all duration-300 flex items-center justify-center gap-2
                {{ $product->stock > 0 
                    ? 'bg-indigo-500 hover:bg-indigo-400 text-white hover:scale-105 hover:shadow-lg hover:shadow-indigo-500/25' 
                    : 'bg-zinc-800 text-zinc-500 cursor-not-allowed' }}">
            <i class="fa-solid fa-cart-plus text-sm"></i> {{ $product->stock > 0 ? __('messages.add_to_cart') : __('messages.out_of_stock') }}
        </button>
    </form>
    
    <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="flex-shrink-0">
        @csrf
        <button class="w-11 h-11 border border-white/10 rounded-xl hover:border-red-500/50 hover:bg-red-500/10 transition-all group flex items-center justify-center" title="{{ __('messages.remove_from_wishlist') }}">
            <i class="fa-solid fa-heart text-red-400 group-hover:scale-110 transition-transform"></i>
        </button>
    </form>
</div>


                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20">
                <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-6">
                    <i class="fa-regular fa-heart text-4xl text-zinc-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">{{ __('messages.empty_wishlist') }}</h3>
                <p class="text-zinc-400 mb-8">{{ __('messages.empty_wishlist_desc') }}</p>
                <a href="{{ route('products.index') }}" 
                   class="px-8 py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105 hover:shadow-lg hover:shadow-indigo-500/25">
                    <i class="fa-solid fa-bag-shopping mr-2"></i> {{ __('messages.browse_products') }}
                </a>
            </div>
        @endif
    </div>
</div>
@endsection