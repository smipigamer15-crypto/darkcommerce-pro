@extends('layouts.app')

@section('title', 'DarkCommerce - ' . __('messages.home'))

@section('content')

<div id="cursor-glow" class="fixed pointer-events-none z-[9999] w-72 h-72 rounded-full bg-indigo-500/5 blur-3xl -translate-x-1/2 -translate-y-1/2" style="transition: transform 0.1s ease-out;"></div>


<section class="relative min-h-[90vh] flex items-center overflow-hidden" data-aos="fade-in" data-aos-duration="1000">
    <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-[500px] h-[500px] bg-indigo-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-[500px] h-[500px] bg-purple-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-indigo-500/5 rounded-full blur-3xl"></div>
    </div>
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:4rem_4rem]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold tracking-tight mb-6 animate-slide-up">
                <span class="block bg-gradient-to-r from-white via-white to-zinc-400 bg-clip-text text-transparent">{{ __('messages.premium_digital') }}</span>
                <span class="block bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent mt-2">{{ __('messages.experience') }}</span>
            </h1>
            <p class="text-lg md:text-xl text-zinc-400 max-w-2xl mx-auto mb-12 animate-fade-in">{{ __('messages.hero_desc') }}</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center animate-slide-up">
                <a href="{{ route('products.index') }}" class="group inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-black font-semibold rounded-2xl hover:bg-zinc-200 transition-all hover:scale-105 hover:shadow-xl hover:shadow-white/10">
                    {{ __('messages.shop_now') }}<i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#features" class="group inline-flex items-center justify-center gap-2 px-8 py-4 border border-white/10 text-white font-semibold rounded-2xl hover:bg-white/5 transition-all hover:scale-105 backdrop-blur-xl hover:border-white/20">
                    {{ __('messages.explore_features') }}<i class="fa-solid fa-compass"></i>
                </a>
            </div>
        </div>
    </div>
</section>


<section class="py-12 border-y border-white/5 overflow-hidden bg-dark-900/30" data-aos="fade-up" data-aos-duration="800">
    <div class="max-w-7xl mx-auto px-4 mb-6"><p class="text-center text-sm text-zinc-500 uppercase tracking-widest">{{ __('messages.trusted_brands') }}</p></div>
    <div class="flex gap-12 animate-marquee whitespace-nowrap">
        @php $brands = \App\Models\Brand::all(); @endphp
        @foreach($brands as $brand)<span class="text-2xl font-bold text-zinc-600 hover:text-white transition-colors cursor-default px-8">{{ $brand->name }}</span>@endforeach
        @foreach($brands as $brand)<span class="text-2xl font-bold text-zinc-600 hover:text-white transition-colors cursor-default px-8">{{ $brand->name }}</span>@endforeach
    </div>
</section>


<section class="py-20" data-aos="fade-up" data-aos-duration="800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-12">
            <div><h2 class="text-3xl font-bold text-white">{{ __('messages.featured_products') }}</h2><p class="text-zinc-400 mt-2">{{ __('messages.handpicked_favorites') }}</p></div>
            <a href="{{ route('products.index') }}" class="text-indigo-400 hover:text-indigo-300 flex items-center gap-2 group">{{ __('messages.view_all') }}<i class="fa-solid fa-arrow-right group-hover:translate-x-1"></i></a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php $featured = \App\Models\Product::with('images')->where('is_featured',true)->where('is_active',true)->take(8)->get(); @endphp
            @foreach($featured as $product)
                <div class="group relative bg-[#111111] rounded-2xl border border-white/5 overflow-hidden hover:border-white/10 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-indigo-500/10" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                    <a href="{{ route('products.show', $product->slug) }}" class="block aspect-square relative overflow-hidden">
                        @if($product->primary_image)<img src="{{ $product->primary_image->url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">@else<div class="w-full h-full flex items-center justify-center"><i class="fa-solid fa-box-open text-6xl text-zinc-700"></i></div>@endif
                        @if($product->discount_price)<div class="absolute top-3 left-3"><span class="px-3 py-1.5 text-xs font-bold bg-red-500 text-white rounded-full shadow-lg">-{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%</span></div>@endif
                    </a>
                    <div class="p-5"><p class="text-xs font-medium text-indigo-400 uppercase tracking-wider mb-2">{{ $product->brand->name ?? '' }}</p><h3 class="text-sm font-semibold text-white mb-3 line-clamp-2">{{ $product->name }}</h3>
                        <div class="flex items-end justify-between"><div>@if($product->discount_price)<span class="text-xl font-bold text-white">${{ number_format($product->discount_price,2) }}</span><span class="ml-2 text-sm text-zinc-500 line-through">${{ number_format($product->price,2) }}</span>@else<span class="text-xl font-bold text-white">${{ number_format($product->price,2) }}</span>@endif</div>
                            <form action="{{ route('cart.add') }}" method="POST">@csrf<input type="hidden" name="product_id" value="{{ $product->id }}"><button class="p-2.5 bg-indigo-500 rounded-xl hover:scale-110 opacity-0 group-hover:opacity-100 shadow-lg transition-all"><i class="fa-solid fa-cart-shopping text-white text-sm"></i></button></form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<section class="py-20" data-aos="fade-up" data-aos-duration="800" x-data="flashSale()" x-init="startTimer()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-red-500/10 to-orange-500/10 border border-red-500/20 rounded-3xl p-8 md:p-12 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-red-500/10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-orange-500/10 rounded-full blur-2xl"></div>
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-8">
                    <div><span class="inline-block px-4 py-1.5 bg-red-500/20 text-red-400 text-xs font-bold rounded-full mb-3"><i class="fa-solid fa-bolt mr-1"></i> {{ __('messages.flash_sale') }}</span><h2 class="text-3xl md:text-4xl font-bold text-white">{{ __('messages.limited_offers') }}</h2></div>
                    <div class="flex items-center gap-4">
                        <div class="text-center"><div class="w-16 h-16 bg-[#111111] rounded-xl flex items-center justify-center text-2xl font-bold text-white" x-text="hours.toString().padStart(2,'0')">00</div><p class="text-zinc-500 text-xs mt-1">{{ __('messages.hours') }}</p></div>
                        <span class="text-2xl text-zinc-500">:</span>
                        <div class="text-center"><div class="w-16 h-16 bg-[#111111] rounded-xl flex items-center justify-center text-2xl font-bold text-white" x-text="minutes.toString().padStart(2,'0')">00</div><p class="text-zinc-500 text-xs mt-1">{{ __('messages.minutes') }}</p></div>
                        <span class="text-2xl text-zinc-500">:</span>
                        <div class="text-center"><div class="w-16 h-16 bg-[#111111] rounded-xl flex items-center justify-center text-2xl font-bold text-white" x-text="seconds.toString().padStart(2,'0')">00</div><p class="text-zinc-500 text-xs mt-1">{{ __('messages.seconds') }}</p></div>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php $saleProducts = \App\Models\Product::where('discount_price', '>', 0)->inRandomOrder()->take(4)->get(); @endphp
                    @foreach($saleProducts as $product)
                        <a href="{{ route('products.show', $product->slug) }}" class="bg-[#111111] rounded-2xl p-4 border border-white/5 hover:border-red-500/20 transition-all group">
                            <div class="aspect-square bg-dark-800 rounded-xl overflow-hidden mb-3">@if($product->primary_image)<img src="{{ $product->primary_image->url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">@else<i class="fa-solid fa-box text-4xl text-zinc-600"></i>@endif</div>
                            <p class="text-white text-sm font-medium truncate">{{ $product->name }}</p>
                            <div class="flex items-center gap-2 mt-1"><span class="text-lg font-bold text-red-400">${{ number_format($product->discount_price,2) }}</span><span class="text-xs text-zinc-500 line-through">${{ number_format($product->price,2) }}</span></div>
                            <div class="w-full bg-white/5 rounded-full h-1.5 mt-2"><div class="bg-red-500 h-1.5 rounded-full" style="width: {{ rand(20,80) }}%"></div></div>
                            <p class="text-zinc-500 text-[10px] mt-1">{{ __('messages.sold') }}: {{ rand(30,90) }}%</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-20 bg-dark-900/50" data-aos="fade-up" data-aos-duration="800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition-all" x-data="{ count:0, target:{{ \App\Models\Product::count() }} }" x-init="setTimeout(()=>{let i=0;let interval=setInterval(()=>{count=Math.ceil(i);i+=target/50;if(i>=target){count=target;clearInterval(interval)}},20)},300)"><div class="w-12 h-12 mx-auto mb-3 bg-indigo-500/10 rounded-xl flex items-center justify-center"><i class="fa-solid fa-box text-indigo-400 text-xl"></i></div><p class="text-4xl font-bold text-white mb-1" x-text="count.toLocaleString()">0</p><p class="text-zinc-400 text-sm">{{ __('messages.products') }}</p></div>
            <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition-all" x-data="{ count:0, target:{{ \App\Models\User::count() }} }" x-init="setTimeout(()=>{let i=0;let interval=setInterval(()=>{count=Math.ceil(i);i+=target/50;if(i>=target){count=target;clearInterval(interval)}},20)},400)"><div class="w-12 h-12 mx-auto mb-3 bg-green-500/10 rounded-xl flex items-center justify-center"><i class="fa-solid fa-users text-green-400 text-xl"></i></div><p class="text-4xl font-bold text-white mb-1" x-text="count.toLocaleString()">0</p><p class="text-zinc-400 text-sm">{{ __('messages.customers') }}</p></div>
            <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition-all" x-data="{ count:0, target:{{ \App\Models\Order::count() }} }" x-init="setTimeout(()=>{let i=0;let interval=setInterval(()=>{count=Math.ceil(i);i+=target/50;if(i>=target){count=target;clearInterval(interval)}},20)},500)"><div class="w-12 h-12 mx-auto mb-3 bg-blue-500/10 rounded-xl flex items-center justify-center"><i class="fa-solid fa-truck-fast text-blue-400 text-xl"></i></div><p class="text-4xl font-bold text-white mb-1" x-text="count.toLocaleString()">0</p><p class="text-zinc-400 text-sm">{{ __('messages.orders') }}</p></div>
            <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition-all" x-data="{ count:0, target:99 }" x-init="setTimeout(()=>{let i=0;let interval=setInterval(()=>{count=Math.ceil(i);i+=99/50;if(i>=99){count=99;clearInterval(interval)}},20)},600)"><div class="w-12 h-12 mx-auto mb-3 bg-purple-500/10 rounded-xl flex items-center justify-center"><i class="fa-solid fa-heart text-purple-400 text-xl"></i></div><p class="text-4xl font-bold text-white mb-1"><span x-text="count">0</span>%</p><p class="text-zinc-400 text-sm">{{ __('messages.satisfaction') }}</p></div>
        </div>
    </div>
</section>


<section class="py-20" data-aos="fade-up" data-aos-duration="800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"><h2 class="text-3xl font-bold text-white text-center mb-12"><i class="fa-solid fa-fire text-orange-500 mr-2"></i> {{ __('messages.best_sellers') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php $topProducts = \App\Models\Product::with('images')->orderBy('sales_count','desc')->take(6)->get(); @endphp
            @foreach($topProducts as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="flex items-center gap-4 bg-[#111111] rounded-2xl p-4 border border-white/5 hover:border-white/10 transition-all group hover:scale-[1.02]">
                    <span class="text-3xl font-bold text-indigo-500/30 w-8">{{ $loop->iteration }}</span><div class="w-16 h-16 bg-dark-800 rounded-xl flex items-center justify-center overflow-hidden">@if($product->primary_image)<img src="{{ $product->primary_image->url }}" class="w-full h-full object-cover">@else<i class="fa-solid fa-box-open text-zinc-600"></i>@endif</div><div class="flex-1 min-w-0"><p class="text-white font-medium truncate">{{ $product->name }}</p><p class="text-indigo-400 text-sm">{{ $product->brand->name ?? '' }}</p></div><p class="text-white font-bold">${{ number_format($product->final_price,2) }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>


<section class="py-20 bg-dark-900/50" data-aos="fade-up" data-aos-duration="800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"><h2 class="text-3xl font-bold text-white text-center mb-12">{{ __('messages.shop_by_category') }}</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @php $categories = \App\Models\Category::where('is_active',true)->take(10)->get(); $catIcons = ['fa-mobile-screen','fa-shirt','fa-house','fa-futbol','fa-book','fa-gamepad','fa-heart-pulse','fa-car','fa-utensils','fa-music']; @endphp
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category'=>$category->id]) }}" class="group relative bg-[#111111] rounded-2xl border border-white/5 p-6 text-center hover:border-indigo-500/20 transition-all hover:scale-105 hover:shadow-xl hover:shadow-indigo-500/5"><div class="w-14 h-14 mx-auto mb-4 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-indigo-500/20 transition-all"><i class="fa-solid {{ $catIcons[$loop->index] ?? 'fa-box' }} text-indigo-400"></i></div><h3 class="text-sm font-semibold text-white">{{ $category->name }}</h3><p class="text-xs text-zinc-500 mt-1">{{ $category->products_count }} {{ __('messages.products') }}</p></a>
            @endforeach
        </div>
    </div>
</section>


<section id="features" class="py-20" data-aos="fade-up" data-aos-duration="800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"><h2 class="text-3xl font-bold text-white text-center mb-12">{{ __('messages.why_choose_us') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group text-center p-8 bg-[#111111] rounded-2xl border border-white/5 hover:border-green-500/20 transition-all hover:-translate-y-1"><div class="w-16 h-16 mx-auto mb-4 bg-green-500/10 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fa-solid fa-truck-fast text-2xl text-green-400"></i></div><h3 class="text-lg font-semibold text-white mb-2">{{ __('messages.free_shipping') }}</h3><p class="text-sm text-zinc-400">{{ __('messages.on_orders_over') }}</p></div>
            <div class="group text-center p-8 bg-[#111111] rounded-2xl border border-white/5 hover:border-blue-500/20 transition-all hover:-translate-y-1"><div class="w-16 h-16 mx-auto mb-4 bg-blue-500/10 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fa-solid fa-shield-halved text-2xl text-blue-400"></i></div><h3 class="text-lg font-semibold text-white mb-2">{{ __('messages.secure_payment') }}</h3><p class="text-sm text-zinc-400">{{ __('messages.ssl_encryption') }}</p></div>
            <div class="group text-center p-8 bg-[#111111] rounded-2xl border border-white/5 hover:border-purple-500/20 transition-all hover:-translate-y-1"><div class="w-16 h-16 mx-auto mb-4 bg-purple-500/10 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fa-solid fa-rotate-left text-2xl text-purple-400"></i></div><h3 class="text-lg font-semibold text-white mb-2">{{ __('messages.money_back') }}</h3><p class="text-sm text-zinc-400">{{ __('messages.day_guarantee') }}</p></div>
        </div>
    </div>
</section>


<section class="py-20 bg-dark-900/50" data-aos="fade-up" data-aos-duration="800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-white text-center mb-12">{{ __('messages.testimonials') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php $reviews = \App\Models\Review::where('is_approved', true)->latest()->take(3)->get(); @endphp
            @foreach($reviews as $review)
                <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition-all">
                    <div class="flex items-center gap-1 mb-3">@for($i=1;$i<=5;$i++)<i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-zinc-600' }} text-sm"></i>@endfor</div>
                    <p class="text-zinc-300 text-sm mb-4">"{{ \Str::limit($review->comment, 120) }}"</p>
                    <div class="flex items-center gap-3"><div class="w-10 h-10 bg-indigo-500/20 rounded-full flex items-center justify-center text-indigo-400 font-bold text-sm">{{ substr($review->user->name, 0, 1) }}</div><div><p class="text-white text-sm font-medium">{{ $review->user->name }}</p><p class="text-zinc-500 text-xs">{{ __('messages.verified_buyer') }}</p></div></div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<section class="py-20" data-aos="fade-up" data-aos-duration="800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif
        <div class="bg-gradient-to-br from-indigo-500/20 to-purple-600/20 rounded-3xl p-12 border border-indigo-500/30 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-indigo-500/10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-purple-500/10 rounded-full blur-2xl"></div>
            <div class="relative z-10">
                <span class="inline-block px-4 py-1.5 bg-indigo-500/20 text-indigo-300 text-xs font-semibold rounded-full mb-4"><i class="fa-solid fa-envelope mr-1"></i> {{ __('messages.newsletter') }}</span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">{{ __('messages.stay_updated') }}</h2>
                <p class="text-zinc-300 mb-8 max-w-md mx-auto">{{ __('messages.get_notified') }}</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                    @csrf
                    <input type="email" name="email" placeholder="your@email.com" class="flex-1 bg-black/30 border border-white/10 rounded-xl px-4 py-3.5 text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-400/50">
                    <button type="submit" class="px-8 py-3.5 bg-white text-black font-semibold rounded-xl hover:bg-zinc-200 transition-all hover:scale-105 flex items-center gap-2">{{ __('messages.subscribe') }} <i class="fa-solid fa-paper-plane"></i></button>
                </form>
                <p class="text-zinc-500 text-xs mt-4">{{ __('messages.no_spam') }}</p>
            </div>
        </div>
    </div>
</section>


@guest
<section class="py-20" data-aos="fade-up" data-aos-duration="800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-br from-[#111111] to-[#0A0A0B] border border-white/5 rounded-3xl p-12 md:p-16 relative overflow-hidden group hover:border-indigo-500/20 transition-all">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div><div class="absolute -top-20 -right-20 w-60 h-60 bg-indigo-500/10 rounded-full blur-3xl"></div><div class="absolute -bottom-20 -left-20 w-60 h-60 bg-purple-500/10 rounded-full blur-3xl"></div>
            <div class="relative z-10"><div class="w-20 h-20 mx-auto mb-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform"><i class="fa-solid fa-rocket text-3xl text-white"></i></div><h2 class="text-3xl md:text-5xl font-bold text-white mb-4">{{ __('messages.ready_start') }}</h2><p class="text-zinc-400 text-lg mb-10 max-w-lg mx-auto">{{ __('messages.join_thousands') }}</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center"><a href="{{ route('register') }}" class="px-8 py-4 bg-indigo-500 text-white rounded-2xl hover:scale-105 flex items-center gap-2"><i class="fa-solid fa-user-plus"></i> {{ __('messages.create_account') }}</a><a href="{{ route('products.index') }}" class="px-8 py-4 border border-white/10 text-white rounded-2xl hover:bg-white/5 flex items-center gap-2"><i class="fa-solid fa-bag-shopping"></i> {{ __('messages.browse_products') }}</a></div><p class="text-zinc-600 text-sm mt-6">{{ __('messages.no_credit_card') }}</p>
            </div>
        </div>
    </div>
</section>
@endguest

<script>
    document.addEventListener('mousemove', (e) => {
        const glow = document.getElementById('cursor-glow');
        if (glow) {
            glow.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;
        }
    });

    function flashSale() {
        return {
            hours: 2,
            minutes: 45,
            seconds: 30,
            startTimer() {
                setInterval(() => {
                    if (this.seconds > 0) { this.seconds--; }
                    else if (this.minutes > 0) { this.minutes--; this.seconds = 59; }
                    else if (this.hours > 0) { this.hours--; this.minutes = 59; this.seconds = 59; }
                }, 1000);
            }
        }
    }
</script>

<style>
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    .animate-marquee { animation: marquee 30s linear infinite; }
    .animate-marquee:hover { animation-play-state: paused; }
    @keyframes fade-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fade-in 0.6s ease-out; }
    @keyframes slide-up { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .animate-slide-up { animation: slide-up 0.8s ease-out; }
</style>

@endsection