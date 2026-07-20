<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DarkCommerce')</title>
    <meta name="description" content="@yield('meta_description', 'Premium Dark Theme E-commerce Platform')">
    <meta name="keywords" content="@yield('meta_keywords', 'ecommerce, shop, dark theme, premium products')">
    <meta name="author" content="DarkCommerce">

    <meta property="og:title" content="@yield('title', 'DarkCommerce')">
    <meta property="og:description" content="@yield('meta_description', 'Premium Dark Theme E-commerce Platform')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="DarkCommerce">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'DarkCommerce')">
    <meta name="twitter:description" content="@yield('meta_description', 'Premium Dark Theme E-commerce Platform')">

    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>[x-cloak] { display: none !important; }</style>
</head>

<body class="bg-[#09090B] text-white font-sans antialiased">

    <nav class="sticky top-0 z-50 bg-[#09090B]/80 backdrop-blur-xl border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Left: Logo + Nav -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <svg class="w-8 h-8 text-indigo-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        <span class="text-xl font-bold bg-gradient-to-r from-indigo-400 to-indigo-600 bg-clip-text text-transparent">DarkCommerce</span>
                    </a>
                    <div class="hidden lg:flex items-center gap-6">
                        <a href="{{ route('home') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">{{ __('messages.home') }}</a>
                        <a href="{{ route('products.index') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">{{ __('messages.products') }}</a>
                        <a href="{{ route('gift-cards.create') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">{{ __('messages.gift_cards') }}</a>
                        <a href="{{ route('search') }}" class="text-sm text-zinc-400 hover:text-white transition-colors"><i class="fa-solid fa-search mr-1"></i> {{ __('messages.search') }}</a>
                    </div>
                </div>

                <!-- Right: Language + Icons + User -->
                <div class="flex items-center gap-3">
                    <!-- Language Switcher -->
                    <div class="flex items-center gap-0.5 bg-white/5 border border-white/10 rounded-lg p-0.5">
                        <a href="{{ route('language.switch', 'en') }}" class="px-2 py-1 text-[11px] font-medium rounded-md transition-all {{ app()->getLocale() === 'en' ? 'bg-indigo-500 text-white' : 'text-zinc-400 hover:text-white' }}">EN</a>
                        <a href="{{ route('language.switch', 'uk') }}" class="px-2 py-1 text-[11px] font-medium rounded-md transition-all {{ app()->getLocale() === 'uk' ? 'bg-indigo-500 text-white' : 'text-zinc-400 hover:text-white' }}">UA</a>
                        <a href="{{ route('language.switch', 'pl') }}" class="px-2 py-1 text-[11px] font-medium rounded-md transition-all {{ app()->getLocale() === 'pl' ? 'bg-indigo-500 text-white' : 'text-zinc-400 hover:text-white' }}">PL</a>
                    </div>

                    <!-- Wishlist -->
                    <a href="{{ route('wishlist.index') }}" class="relative p-2 text-zinc-400 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        @auth
                            @php $wishlistCount = auth()->user()->wishlist()->count(); @endphp
                            @if($wishlistCount > 0)<span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-[10px] flex items-center justify-center">{{ $wishlistCount }}</span>@endif
                        @endauth
                    </a>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-zinc-400 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        @php
                            $cartCount = 0;
                            if (auth()->check()) {
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                            } else {
                                $cartCount = count(session()->get('cart', []));
                            }
                        @endphp
                        @if($cartCount > 0)<span class="absolute -top-1 -right-1 w-4 h-4 bg-indigo-500 rounded-full text-[10px] flex items-center justify-center">{{ $cartCount }}</span>@endif
                    </a>

                    <!-- User Menu -->
                    @auth
                        <div class="relative ml-2" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2"><div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center text-sm font-bold">{{ substr(auth()->user()->name, 0, 1) }}</div></button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 bg-[#111111] border border-white/10 rounded-xl shadow-2xl py-2">
                                <div class="px-4 py-3 border-b border-white/5"><p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p><p class="text-xs text-zinc-500">{{ auth()->user()->email }}</p><p class="text-xs text-indigo-400 mt-1"><i class="fa-solid fa-coins mr-1"></i> {{ auth()->user()->points }} {{ __('messages.points') }}</p></div>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-400 hover:text-white hover:bg-white/5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg> {{ __('messages.profile') }}</a>
                                <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-400 hover:text-white hover:bg-white/5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg> {{ __('messages.orders') }}</a>
                                <a href="{{ route('returns.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-400 hover:text-white hover:bg-white/5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/></svg> {{ __('messages.returns') }}</a>
                                <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-400 hover:text-white hover:bg-white/5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg> {{ __('messages.wishlist') }}</a>
                                @if(auth()->user()->isAdmin())<a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-indigo-400 hover:bg-white/5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg> {{ __('messages.admin') }}</a>@endif
                                <hr class="border-white/5 my-2">
                                <form method="POST" action="{{ route('logout') }}">@csrf<button class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-400 hover:bg-white/5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg> {{ __('messages.logout') }}</button></form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm text-zinc-400 hover:text-white transition-colors">{{ __('messages.sign_in') }}</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-400 rounded-xl transition-all">{{ __('messages.sign_up') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen">@yield('content')</main>

    <footer class="bg-[#0A0A0B] border-t border-white/5 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                <div class="lg:col-span-2"><a href="{{ route('home') }}" class="flex items-center gap-2 mb-4"><div class="w-10 h-10 bg-indigo-500 rounded-xl flex items-center justify-center"><i class="fa-solid fa-layer-group text-white text-lg"></i></div><span class="text-xl font-bold bg-gradient-to-r from-indigo-400 to-indigo-600 bg-clip-text text-transparent">DarkCommerce</span></a><p class="text-sm text-zinc-400 max-w-sm mb-6">{{ __('messages.footer_text') }}</p><div class="flex items-center gap-3"><a href="#" class="w-10 h-10 bg-white/5 border border-white/5 rounded-xl flex items-center justify-center text-zinc-400 hover:text-white hover:bg-indigo-500/20 transition-all"><i class="fa-brands fa-x-twitter"></i></a><a href="#" class="w-10 h-10 bg-white/5 border border-white/5 rounded-xl flex items-center justify-center text-zinc-400 hover:text-white hover:bg-indigo-500/20 transition-all"><i class="fa-brands fa-instagram"></i></a><a href="#" class="w-10 h-10 bg-white/5 border border-white/5 rounded-xl flex items-center justify-center text-zinc-400 hover:text-white hover:bg-indigo-500/20 transition-all"><i class="fa-brands fa-github"></i></a></div></div>
                <div><h4 class="text-sm font-semibold text-white mb-4 uppercase tracking-wider">{{ __('messages.products') }}</h4><ul class="space-y-3"><li><a href="{{ route('products.index') }}" class="text-sm text-zinc-400 hover:text-white">{{ __('messages.all_products') }}</a></li><li><a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('messages.new_arrivals') }}</a></li><li><a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('messages.best_deals') }}</a></li><li><a href="{{ route('search') }}" class="text-sm text-zinc-400 hover:text-white">{{ __('messages.search') }}</a></li></ul></div>
                <div><h4 class="text-sm font-semibold text-white mb-4 uppercase tracking-wider">{{ __('messages.profile') }}</h4><ul class="space-y-3">@auth<li><a href="{{ route('profile.edit') }}" class="text-sm text-zinc-400 hover:text-white">{{ __('messages.profile') }}</a></li><li><a href="{{ route('orders.index') }}" class="text-sm text-zinc-400 hover:text-white">{{ __('messages.orders') }}</a></li>@else<li><a href="{{ route('login') }}" class="text-sm text-zinc-400 hover:text-white">{{ __('messages.sign_in') }}</a></li><li><a href="{{ route('register') }}" class="text-sm text-zinc-400 hover:text-white">{{ __('messages.sign_up') }}</a></li>@endauth</ul></div>
                <div><h4 class="text-sm font-semibold text-white mb-4 uppercase tracking-wider">{{ __('messages.help_center') }}</h4><ul class="space-y-3"><li><a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('messages.help_center') }}</a></li><li><a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('messages.shipping') }}</a></li><li><a href="{{ route('returns.index') }}" class="text-sm text-zinc-400 hover:text-white">{{ __('messages.returns') }}</a></li><li><a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('messages.contact') }}</a></li></ul></div>
            </div>
            <div class="border-t border-white/5 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4"><p class="text-sm text-zinc-500">© {{ date('Y') }} DarkCommerce Pro. {{ __('messages.all_rights') }}</p><div class="flex items-center gap-6"><a href="#" class="text-xs text-zinc-500 hover:text-zinc-400">{{ __('messages.privacy') }}</a><a href="#" class="text-xs text-zinc-500 hover:text-zinc-400">{{ __('messages.terms') }}</a><a href="#" class="text-xs text-zinc-500 hover:text-zinc-400">{{ __('messages.cookies') }}</a></div></div>
        </div>
    </footer>

    @livewireScripts
    @auth
        <livewire:chat-support />
    @endauth

    @if(session('success'))
        <div id="toast" class="fixed bottom-6 right-6 z-50 bg-green-500/10 border border-green-500/20 text-green-400 rounded-xl px-5 py-3 shadow-2xl flex items-center gap-3 text-sm cursor-pointer" onclick="this.remove()">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
        <script>setTimeout(() => document.getElementById('toast')?.remove(), 4000);</script>
    @endif

    @if(session('error'))
        <div id="toast-error" class="fixed bottom-6 right-6 z-50 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl px-5 py-3 shadow-2xl flex items-center gap-3 text-sm cursor-pointer" onclick="this.remove()">
            <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
        </div>
        <script>setTimeout(() => document.getElementById('toast-error')?.remove(), 4000);</script>
    @endif
</body>
</html>