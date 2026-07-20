@extends('layouts.app')

@section('title', 'Sign In - DarkCommerce')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white">Welcome Back</h1>
            <p class="text-zinc-400 mt-2">Sign in to your account</p>
        </div>

        <div class="bg-dark-900 border border-white/5 rounded-2xl p-8">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-primary-500/50 transition-all">
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-primary-500/50 transition-all">
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 text-sm text-zinc-400 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded bg-white/5 border-white/10 text-primary-500 focus:ring-primary-500/20">
                        Remember me
                    </label>
                    
                    <a href="{{ route('password.request') }}" class="text-sm text-primary-400 hover:text-primary-300 transition-colors">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit" 
                        class="w-full bg-primary-500 hover:bg-primary-400 text-white font-semibold rounded-xl px-4 py-3 transition-all hover:scale-[1.02]">
                    Sign In
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-zinc-400">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-primary-400 hover:text-primary-300 transition-colors">
                        Create one
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
