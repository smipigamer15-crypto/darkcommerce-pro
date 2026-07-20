@extends('layouts.app')

@section('title', __('messages.my_account') . ' - DarkCommerce')

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold">{{ __('messages.my_account') }}</h1>
            @if(session('success'))
                <div class="px-4 py-2 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-gradient-to-br from-[#111111] to-[#1a1a1a] border border-white/5 rounded-2xl p-5 hover:border-indigo-500/20 transition-all group cursor-default">
                <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center group-hover:bg-indigo-500/20 transition-all"><i class="fa-solid fa-box text-indigo-400"></i></div><span class="text-[10px] text-zinc-500 uppercase tracking-wider font-medium">{{ __('messages.orders') }}</span></div>
                <p class="text-3xl font-bold text-white tracking-tight">{{ $orders->count() }}</p><p class="text-zinc-500 text-xs mt-1 font-medium">{{ __('messages.total_purchases') }}</p>
            </div>
            <div class="bg-gradient-to-br from-[#111111] to-[#1a1a1a] border border-white/5 rounded-2xl p-5 hover:border-green-500/20 transition-all group cursor-default">
                <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 bg-green-500/10 rounded-xl flex items-center justify-center group-hover:bg-green-500/20 transition-all"><i class="fa-solid fa-coins text-green-400"></i></div><span class="text-[10px] text-zinc-500 uppercase tracking-wider font-medium">{{ __('messages.points') }}</span></div>
                <p class="text-3xl font-bold text-white tracking-tight">{{ auth()->user()->points }}</p><p class="text-green-400 text-xs mt-1 font-medium">= ${{ number_format(auth()->user()->points_value, 2) }}</p>
            </div>
            <div class="bg-gradient-to-br from-[#111111] to-[#1a1a1a] border border-white/5 rounded-2xl p-5 hover:border-red-500/20 transition-all group cursor-default">
                <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 bg-red-500/10 rounded-xl flex items-center justify-center group-hover:bg-red-500/20 transition-all"><i class="fa-solid fa-heart text-red-400"></i></div><span class="text-[10px] text-zinc-500 uppercase tracking-wider font-medium">{{ __('messages.wishlist') }}</span></div>
                <p class="text-3xl font-bold text-white tracking-tight">{{ auth()->user()->wishlist()->count() }}</p><p class="text-zinc-500 text-xs mt-1 font-medium">{{ __('messages.saved_items') }}</p>
            </div>
            <div class="bg-gradient-to-br from-[#111111] to-[#1a1a1a] border border-white/5 rounded-2xl p-5 hover:border-purple-500/20 transition-all group cursor-default">
                <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 bg-purple-500/10 rounded-xl flex items-center justify-center group-hover:bg-purple-500/20 transition-all"><i class="fa-solid fa-star text-purple-400"></i></div><span class="text-[10px] text-zinc-500 uppercase tracking-wider font-medium">{{ __('messages.reviews') }}</span></div>
                <p class="text-3xl font-bold text-white tracking-tight">{{ auth()->user()->reviews()->count() }}</p><p class="text-zinc-500 text-xs mt-1 font-medium">{{ __('messages.written_reviews') }}</p>
            </div>
            <div class="bg-gradient-to-br from-[#111111] to-[#1a1a1a] border border-white/5 rounded-2xl p-5 hover:border-cyan-500/20 transition-all group cursor-default">
                <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 bg-cyan-500/10 rounded-xl flex items-center justify-center group-hover:bg-cyan-500/20 transition-all"><i class="fa-solid fa-eye text-cyan-400"></i></div><span class="text-[10px] text-zinc-500 uppercase tracking-wider font-medium">{{ __('messages.viewed') }}</span></div>
                <p class="text-3xl font-bold text-white tracking-tight">{{ $recentlyViewed->count() ?? 0 }}</p><p class="text-zinc-500 text-xs mt-1 font-medium">{{ __('messages.recently_viewed') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-1">
                <div class="bg-[#111111] border border-white/5 rounded-2xl overflow-hidden sticky top-24 shadow-2xl">
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-6 text-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/5"></div>
                        <div class="relative">
                            <div class="w-20 h-20 mx-auto bg-white/20 rounded-full flex items-center justify-center text-2xl font-bold ring-4 ring-white/10 shadow-lg">{{ substr(auth()->user()->name, 0, 1) }}</div>
                            <h3 class="text-white font-semibold text-lg mt-3">{{ auth()->user()->name }}</h3>
                            <p class="text-white/70 text-sm">{{ auth()->user()->email }}</p>
                            @if(auth()->user()->isAdmin())<span class="inline-block mt-2 px-3 py-1 bg-white/20 text-white text-xs rounded-full backdrop-blur-sm">Admin</span>@endif
                        </div>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex justify-between py-2.5 border-b border-white/5"><span class="text-zinc-400 text-sm"><i class="fa-solid fa-coins text-indigo-400 mr-2"></i> {{ __('messages.points') }}</span><span class="text-white font-semibold">{{ auth()->user()->points }}</span></div>
                        <div class="flex justify-between py-2.5 border-b border-white/5"><span class="text-zinc-400 text-sm"><i class="fa-solid fa-box mr-2"></i> {{ __('messages.orders') }}</span><span class="text-white font-semibold">{{ auth()->user()->orders->count() }}</span></div>
                        <div class="flex justify-between py-2.5"><span class="text-zinc-400 text-sm"><i class="fa-solid fa-heart text-red-400 mr-2"></i> {{ __('messages.wishlist') }}</span><span class="text-white font-semibold">{{ auth()->user()->wishlist->count() }}</span></div>
                    </div>
                    <div class="px-5 pb-5">
                        <form method="POST" action="{{ route('logout') }}">@csrf<button class="w-full py-2.5 border border-red-500/20 text-red-400 rounded-xl hover:bg-red-500/10 transition-all text-sm font-medium"><i class="fa-solid fa-right-from-bracket mr-2"></i> {{ __('messages.logout') }}</button></form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition-all">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2"><span class="w-8 h-8 bg-indigo-500/10 rounded-lg flex items-center justify-center"><i class="fa-solid fa-user-pen text-indigo-400 text-sm"></i></span>{{ __('messages.edit_profile') }}</h2>
                        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">@csrf @method('PUT')
                            <div><label class="block text-sm font-medium text-zinc-400 mb-1.5">{{ __('messages.name') }}</label><input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all"></div>
                            <div><label class="block text-sm font-medium text-zinc-400 mb-1.5">{{ __('messages.email') }}</label><input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all"></div>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105 text-sm"><i class="fa-solid fa-floppy-disk mr-1"></i> {{ __('messages.save_changes') }}</button>
                        </form>
                    </div>
                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition-all">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2"><span class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center"><i class="fa-solid fa-lock text-orange-400 text-sm"></i></span>{{ __('messages.change_password') }}</h2>
                        <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">@csrf @method('PUT')
                            <div><label class="block text-sm font-medium text-zinc-400 mb-1.5">{{ __('messages.current_password') }}</label><input type="password" name="current_password" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all"></div>
                            <div><label class="block text-sm font-medium text-zinc-400 mb-1.5">{{ __('messages.new_password') }}</label><input type="password" name="password" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all"></div>
                            <div><label class="block text-sm font-medium text-zinc-400 mb-1.5">{{ __('messages.confirm_password') }}</label><input type="password" name="password_confirmation" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 transition-all"></div>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105 text-sm"><i class="fa-solid fa-key mr-1"></i> {{ __('messages.update_password') }}</button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition-all">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2"><span class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center"><i class="fa-solid fa-envelope text-blue-400 text-sm"></i></span>{{ __('messages.newsletter') }}</h2>
                        @if($subscription && $subscription->is_active)
                            <div class="flex items-center justify-between p-3 bg-green-500/5 rounded-xl">
                                <div><p class="text-green-400 text-sm font-medium"><i class="fa-solid fa-circle-check mr-1"></i> {{ __('messages.subscribed') }}</p><p class="text-zinc-500 text-xs mt-0.5">{{ __('messages.you_receive_updates') }}</p></div>
                                <a href="{{ route('newsletter.unsubscribe', $subscription->unsubscribe_token) }}" class="px-4 py-2 bg-red-500/10 text-red-400 rounded-xl text-xs hover:bg-red-500/20 transition-all">{{ __('messages.unsubscribe') }}</a>
                            </div>
                        @else
                            <div class="flex items-center justify-between p-3 bg-dark-800 rounded-xl">
                                <div><p class="text-zinc-400 text-sm">{{ __('messages.not_subscribed') }}</p><p class="text-zinc-500 text-xs mt-0.5">{{ __('messages.get_notified_offers') }}</p></div>
                                <form action="{{ route('newsletter.resubscribe') }}" method="POST">@csrf<input type="hidden" name="email" value="{{ auth()->user()->email }}"><button class="px-4 py-2 bg-indigo-500 text-white rounded-xl text-xs hover:bg-indigo-400 transition-all">{{ __('messages.subscribe') }}</button></form>
                            </div>
                        @endif
                    </div>
                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition-all text-center">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center justify-center gap-2"><span class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center"><i class="fa-solid fa-coins text-green-400 text-sm"></i></span>{{ __('messages.points') }}</h2>
                        <p class="text-5xl font-bold text-white tracking-tight">{{ auth()->user()->points }}</p><p class="text-zinc-400 text-sm mt-2">= ${{ number_format(auth()->user()->points_value, 2) }}</p>
                        <div class="mt-3 inline-flex items-center gap-1 px-3 py-1 bg-green-500/10 rounded-full text-green-400 text-xs"><i class="fa-solid fa-info-circle"></i> {{ __('messages.points_info') }}</div>
                    </div>
                </div>

                @if($recentlyViewed->count() > 0)
                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-6" x-data="{ scroll: 0, maxScroll: {{ ($recentlyViewed->count() - 3) * 140 }} }">
                        <div class="flex items-center justify-between mb-4"><h2 class="text-lg font-semibold text-white flex items-center gap-2"><span class="w-8 h-8 bg-cyan-500/10 rounded-lg flex items-center justify-center"><i class="fa-solid fa-clock-rotate-left text-cyan-400 text-sm"></i></span>{{ __('messages.recently_viewed') }}</h2>@if($recentlyViewed->count()>3)<div class="flex gap-2"><button @click="scroll=Math.max(0,scroll-280)" class="w-8 h-8 bg-white/5 rounded-lg" :class="scroll===0?'opacity-50':''"><i class="fa-solid fa-chevron-left text-xs"></i></button><button @click="scroll=Math.min(maxScroll,scroll+280)" class="w-8 h-8 bg-white/5 rounded-lg" :class="scroll>=maxScroll?'opacity-50':''"><i class="fa-solid fa-chevron-right text-xs"></i></button></div>@endif</div>
                        <div class="overflow-hidden"><div class="flex gap-3 transition-transform duration-300" :style="'transform:translateX(-'+scroll+'px)'">@foreach($recentlyViewed as $view)<a href="{{ route('products.show',$view->product->slug) }}" class="flex-shrink-0 w-[130px] group"><div class="aspect-square bg-dark-800 rounded-xl overflow-hidden mb-2 relative">@if($view->product->primary_image)<img src="{{ $view->product->primary_image->url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">@else<div class="w-full h-full flex items-center justify-center"><i class="fa-solid fa-box text-2xl text-zinc-600"></i></div>@endif</div><p class="text-white text-xs truncate group-hover:text-indigo-400 font-medium">{{ $view->product->name }}</p><p class="text-zinc-500 text-[11px]">${{ number_format($view->product->final_price,2) }}</p></a>@endforeach</div></div>
                    </div>
                @endif

                <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition-all">
                    <div class="flex justify-between mb-4"><h2 class="text-lg font-semibold text-white flex items-center gap-2"><span class="w-8 h-8 bg-purple-500/10 rounded-lg flex items-center justify-center"><i class="fa-solid fa-box-archive text-purple-400 text-sm"></i></span>{{ __('messages.recent_orders') }}</h2><a href="{{ route('orders.index') }}" class="text-indigo-400 text-sm font-medium">{{ __('messages.view_all') }}</a></div>
                    @if($orders->count()>0)<div class="space-y-2">@foreach($orders as $order)<a href="{{ route('orders.show',$order) }}" class="flex justify-between p-3.5 bg-dark-800 rounded-xl hover:bg-dark-700 transition-all group"><div class="flex items-center gap-3"><div class="w-10 h-10 bg-dark-700 rounded-lg flex items-center justify-center group-hover:bg-indigo-500/10 transition-all"><i class="fa-solid fa-receipt text-zinc-400 group-hover:text-indigo-400 text-sm"></i></div><div><p class="text-white text-sm font-medium">#{{ $order->order_number }}</p><p class="text-zinc-500 text-xs">{{ $order->created_at->format('M d, Y') }}</p></div></div><div class="text-right"><p class="text-white font-bold text-sm">${{ number_format($order->total,2) }}</p><span class="text-xs font-medium {{ $order->status==='delivered'?'text-green-400':'text-yellow-400' }}">{{ ucfirst($order->status) }}</span></div></a>@endforeach</div>@else<div class="text-center py-8"><div class="w-12 h-12 mx-auto mb-3 bg-white/5 rounded-full flex items-center justify-center"><i class="fa-solid fa-box-open text-zinc-600"></i></div><p class="text-zinc-400 text-sm">{{ __('messages.no_orders') }}</p><a href="{{ route('products.index') }}" class="text-indigo-400 text-xs mt-2 inline-block">{{ __('messages.start_shopping') }}</a></div>@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection