@extends('layouts.app')

@section('title', 'Create Account - DarkCommerce')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white">Create Account</h1>
            <p class="text-zinc-400 mt-2">Join DarkCommerce today</p>
        </div>

        <div class="bg-dark-900 border border-white/5 rounded-2xl p-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-primary-500/50 transition-all">
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
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

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-primary-500/50 transition-all">
                </div>

                <!-- Submit -->
                <button type="submit" 
                        class="w-full bg-primary-500 hover:bg-primary-400 text-white font-semibold rounded-xl px-4 py-3 transition-all hover:scale-[1.02]">
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-zinc-400">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-primary-400 hover:text-primary-300 transition-colors">
                        Sign in
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
