@extends('layouts.app')

@section('title', $product->name . ' - DarkCommerce')
@section('meta_description', \Str::limit($product->description, 160))
@section('meta_keywords', $product->meta_keywords ?? strtolower($product->name))

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-sm text-zinc-400">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors"><i class="fa-solid fa-house mr-1"></i> {{ __('messages.home') }}</a>
                <span>/</span>
                <a href="{{ route('products.index') }}" class="hover:text-white transition-colors">{{ __('messages.products') }}</a>
                <span>/</span>
                @if($product->categories->first())
                    <a href="{{ route('products.index', ['category' => $product->categories->first()->id]) }}" class="hover:text-white transition-colors">{{ $product->categories->first()->name }}</a>
                    <span>/</span>
                @endif
                <span class="text-white font-medium">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="space-y-4">
                <div class="aspect-square bg-gradient-to-br from-dark-800 to-dark-900 rounded-2xl flex items-center justify-center relative overflow-hidden border border-white/5 group cursor-zoom-in">
                    @if($product->primary_image)
                        <img src="{{ $product->primary_image->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-150 transition-transform duration-700">
                    @else
                        <div class="text-[150px] group-hover:scale-110 transition-transform"><i class="fa-solid fa-box-open text-zinc-700"></i></div>
                    @endif

                    @if($product->discount_price)
                        <div class="absolute top-4 left-4 z-10">
                            <span class="px-4 py-2 text-sm font-bold bg-red-500 text-white rounded-full shadow-lg shadow-red-500/20 animate-pulse">
                                -{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                            </span>
                        </div>
                    @endif

                    @if($product->stock <= 5 && $product->stock > 0)
                        <div class="absolute top-4 right-4 z-10">
                            <span class="px-4 py-2 text-sm font-bold bg-yellow-500/20 text-yellow-400 rounded-full border border-yellow-500/30 backdrop-blur-sm">
                                <i class="fa-solid fa-bolt mr-1"></i> {{ __('messages.only_left', ['count' => $product->stock]) }}
                            </span>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-4 gap-3">
                    @for($i = 0; $i < 4; $i++)
                        <div class="aspect-square bg-dark-800 rounded-xl border border-white/5 flex items-center justify-center text-2xl cursor-pointer hover:border-indigo-500/50 transition-all hover:scale-105">
                            @if($product->primary_image && $i == 0)
                                <img src="{{ $product->primary_image->url }}" class="w-full h-full object-cover rounded-xl">
                            @else
                                <div class="w-full h-full bg-dark-700 rounded-xl flex items-center justify-center text-zinc-600">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>

            <div>
                @if($product->brand)
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-indigo-500/10 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-tag text-indigo-400 text-xs"></i>
                        </div>
                        <p class="text-sm font-medium text-indigo-400 uppercase tracking-wider">{{ $product->brand->name }}</p>
                    </div>
                @endif

                <h1 class="text-3xl lg:text-4xl font-bold text-white mb-4 leading-tight">{{ $product->name }}</h1>

                <div class="flex items-center gap-4 mb-6 p-4 bg-[#111111] rounded-2xl border border-white/5">
                    <div class="flex items-center gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= round($product->rating) ? 'text-yellow-400' : 'text-zinc-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-lg font-bold text-white">{{ number_format($product->rating, 1) }}</span>
                    <span class="text-zinc-400 text-sm">· {{ $product->reviews_count }} {{ __('messages.reviews') }}</span>
                </div>

                <div class="flex items-baseline gap-3 mb-6 bg-[#111111] rounded-2xl p-5 border border-white/5">
                    @if($product->discount_price)
                        <span class="text-4xl font-bold text-white">${{ number_format($product->discount_price, 2) }}</span>
                        <span class="text-xl text-zinc-500 line-through">${{ number_format($product->price, 2) }}</span>
                        <span class="text-sm font-semibold text-green-400 ml-auto">Save ${{ number_format($product->price - $product->discount_price, 2) }}</span>
                    @else
                        <span class="text-4xl font-bold text-white">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <div class="prose prose-invert max-w-none mb-8">
                    <p class="text-zinc-300 leading-relaxed">{{ $product->description }}</p>
                </div>

                <div class="flex items-center gap-3 mb-6">
                    @if($product->stock > 10)
                        <div class="flex items-center gap-2 px-4 py-2 bg-green-500/10 rounded-xl">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-green-400">{{ __('messages.in_stock') }}</span>
                        </div>
                    @elseif($product->stock > 0)
                        <div class="flex items-center gap-2 px-4 py-2 bg-yellow-500/10 rounded-xl">
                            <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-yellow-400">{{ __('messages.only_left', ['count' => $product->stock]) }}</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 px-4 py-2 bg-red-500/10 rounded-xl">
                            <div class="w-2 h-2 bg-red-400 rounded-full"></div>
                            <span class="text-sm font-medium text-red-400">{{ __('messages.out_of_stock') }}</span>
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button {{ $product->stock == 0 ? 'disabled' : '' }}
                                class="w-full py-4 px-8 rounded-2xl font-semibold text-lg transition-all duration-300 flex items-center justify-center gap-2
                                {{ $product->stock > 0 
                                    ? 'bg-indigo-500 hover:bg-indigo-400 text-white hover:scale-105 hover:shadow-xl hover:shadow-indigo-500/25' 
                                    : 'bg-zinc-800 text-zinc-500 cursor-not-allowed' }}">
                            <i class="fa-solid fa-cart-plus"></i> {{ $product->stock > 0 ? __('messages.add_to_cart') : __('messages.out_of_stock') }}
                        </button>
                    </form>
                    
                    <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                        @csrf
                        <button class="p-4 border border-white/10 rounded-2xl hover:border-red-500/50 hover:bg-red-500/10 transition-all group">
                            <svg class="w-6 h-6 text-zinc-400 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="mt-6 pt-6 border-t border-white/5 space-y-3">
                    <div class="flex items-center gap-2 text-sm">
                        <span class="text-zinc-500">{{ __('messages.sku') }}:</span>
                        <span class="text-zinc-300 font-mono">{{ $product->sku }}</span>
                    </div>
                    @if($product->categories->count() > 0)
                        <div class="flex items-center gap-2 text-sm">
                            <span class="text-zinc-500">{{ __('messages.categories') }}:</span>
                            <div class="flex gap-1.5">
                                @foreach($product->categories as $cat)
                                    <span class="px-3 py-1 bg-indigo-500/10 text-indigo-400 text-xs rounded-full">{{ $cat->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-20">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ __('messages.customer_reviews') }}</h2>
                    <div class="flex items-center gap-3 mt-2">
                        <div class="flex items-center gap-0.5">
                            @for($i=1;$i<=5;$i++)
                                <svg class="w-5 h-5 {{ $i <= round($product->rating) ? 'text-yellow-400' : 'text-zinc-600' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="text-lg font-bold text-white">{{ number_format($product->rating, 1) }}</span>
                        <span class="text-zinc-400">· {{ $product->reviews_count }} {{ __('messages.reviews') }}</span>
                    </div>
                </div>
            </div>

            <button onclick="document.getElementById('review-form').classList.toggle('hidden')" class="mb-8 px-6 py-3 border border-white/10 text-white rounded-xl hover:bg-white/5 transition-all flex items-center gap-2 hover:border-white/20">
                <i class="fa-solid fa-pen-to-square"></i> {{ __('messages.write_review') }}
            </button>

            @auth
                <div id="review-form" class="hidden mb-8">
                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-6">
                        <h3 class="text-lg font-semibold text-white mb-6">{{ __('messages.write_your_review') }}</h3>
                        <form action="{{ route('reviews.store', $product) }}" method="POST">@csrf
                            <div class="mb-6">
                                <label class="block text-sm text-zinc-400 mb-3">{{ __('messages.your_rating') }}</label>
                                <div class="flex items-center gap-1" x-data="{ rating: 0 }">
                                    @for($i=1;$i<=5;$i++)
                                        <button type="button" @click="rating = {{ $i }}" class="group">
                                            <svg class="w-10 h-10 transition-all" :class="rating >= {{ $i }} ? 'text-yellow-400 scale-110' : 'text-zinc-600 hover:text-yellow-400/50'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        </button>
                                    @endfor
                                    <span class="ml-3 text-sm text-zinc-400" x-text="rating ? rating + ' star' + (rating > 1 ? 's' : '') : '{{ __('messages.click_to_rate') }}'"></span>
                                    <input type="hidden" name="rating" x-model="rating">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm text-zinc-400 mb-2">{{ __('messages.your_review') }}</label>
                                <textarea name="comment" id="review-textarea" rows="4" required 
                                        placeholder="{{ __('messages.share_experience') }}"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 transition-all resize-none"
                                        minlength="10"
                                        oninput="updateCharCount()"></textarea>
                                <div class="flex items-center justify-between mt-1">
                                    <p class="text-zinc-500 text-xs">{{ __('messages.min_chars', ['count' => 10]) }}</p>
                                    <p class="text-xs" id="char-count-text">0/10</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <button type="submit" class="px-8 py-3 bg-indigo-500 text-white rounded-xl hover:bg-indigo-400 transition-all"><i class="fa-solid fa-paper-plane mr-1"></i> {{ __('messages.submit_review') }}</button>
                                <button type="button" onclick="document.getElementById('review-form').classList.add('hidden')" class="px-8 py-3 border border-white/10 text-white rounded-xl hover:bg-white/5">{{ __('messages.cancel') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="mb-8 bg-[#111111] rounded-2xl p-6 text-center border border-white/5">
                    <p class="text-zinc-400">{{ __('messages.please_login') }} <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-medium">{{ __('messages.sign_in') }}</a> {{ __('messages.to_write_review') }}</p>
                </div>
            @endauth

            @if($reviews->count() > 0)
                <div class="space-y-4">
                    @foreach($reviews as $review)
                        <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition-all">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-indigo-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-indigo-400 font-bold text-sm">{{ substr($review->user->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <p class="text-white font-semibold">{{ $review->user->name }}</p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <div class="flex items-center gap-0.5">@for($i=1;$i<=5;$i++)<svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-zinc-600' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor</div>
                                                <span class="text-xs text-zinc-500">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <span class="px-2 py-1 bg-green-500/10 text-green-400 text-xs rounded-full flex items-center gap-1"><i class="fa-solid fa-check-circle text-[10px]"></i> {{ __('messages.verified') }}</span>
                                    </div>
                                    <p class="text-zinc-300 mt-3 leading-relaxed">{{ $review->comment }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-[#111111] rounded-2xl border border-white/5">
                    <div class="text-5xl mb-4"><i class="fa-solid fa-star text-zinc-600"></i></div>
                    <p class="text-zinc-400 text-lg">{{ __('messages.no_reviews_yet') }}</p>
                </div>
            @endif
        </div>

        @if($relatedProducts->count() > 0)
            <div class="mt-20">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-white">{{ __('messages.related_products') }}</h2>
                    <a href="{{ route('products.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm flex items-center gap-1 group">
                        {{ __('messages.view_all') }} <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($relatedProducts as $related)
                        <div class="group bg-[#111111] rounded-2xl border border-white/5 overflow-hidden hover:border-white/10 transition-all duration-500 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-indigo-500/5">
                            <a href="{{ route('products.show', $related->slug) }}" class="block aspect-square bg-gradient-to-br from-dark-800 to-dark-900 relative overflow-hidden">
                                @if($related->primary_image)
                                    <img src="{{ $related->primary_image->url }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"><i class="fa-solid fa-box-open text-6xl text-zinc-700 group-hover:scale-110 transition-transform"></i></div>
                                @endif
                                @if($related->discount_price)
                                    <div class="absolute top-3 left-3">
                                        <span class="px-3 py-1.5 text-xs font-bold bg-red-500 text-white rounded-full shadow-lg shadow-red-500/20">-{{ round((($related->price - $related->discount_price) / $related->price) * 100) }}%</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="px-6 py-3 bg-white text-black font-semibold rounded-xl transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                        <i class="fa-solid fa-eye mr-2"></i>{{ __('messages.quick_view') }}
                                    </span>
                                </div>
                            </a>
                            <div class="p-4">
                                @if($related->brand)
                                    <p class="text-xs font-medium text-indigo-400 uppercase tracking-wider mb-2">{{ $related->brand->name }}</p>
                                @endif
                                <h3 class="text-sm font-semibold text-white mb-3 line-clamp-2 leading-snug group-hover:text-indigo-400 transition-colors">
                                    <a href="{{ route('products.show', $related->slug) }}">{{ $related->name }}</a>
                                </h3>
                                <div class="flex items-end justify-between">
                                    <div>
                                        @if($related->discount_price)
                                            <span class="text-lg font-bold text-white">${{ number_format($related->discount_price, 2) }}</span>
                                            <span class="ml-2 text-sm text-zinc-500 line-through">${{ number_format($related->price, 2) }}</span>
                                        @else
                                            <span class="text-lg font-bold text-white">${{ number_format($related->price, 2) }}</span>
                                        @endif
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $related->id }}">
                                        <button class="p-2 bg-indigo-500 hover:bg-indigo-400 rounded-lg transition-all hover:scale-110 opacity-0 group-hover:opacity-100">
                                            <i class="fa-solid fa-cart-plus text-white text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
<script>
    function updateCharCount() {
        const textarea = document.getElementById('review-textarea');
        const counter = document.getElementById('char-count-text');
        const count = textarea.value.length;
        
        counter.textContent = count + '/10';
        
        if (count < 10) {
            counter.className = 'text-xs text-red-400';
        } else {
            counter.className = 'text-xs text-green-400';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateCharCount();
    });
</script>
@endsection