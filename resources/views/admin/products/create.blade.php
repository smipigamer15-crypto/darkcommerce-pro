@extends('layouts.admin')

@section('title', 'Add Product - Admin')

@section('content')
<div class="min-h-screen bg-[#09090B] text-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8">Add New Product</h1>

        <form action="{{ route('admin.products.store') }}" enctype="multipart/form-data" method="POST" class="bg-[#111111] border border-white/5 rounded-2xl p-8">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Product Name</label>
                    <input type="text" name="name" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500/50">
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Description</label>
                    <textarea name="description" rows="4" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500/50"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Price</label>
                        <input type="number" name="price" step="0.01" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500/50">
                    </div>
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Discount Price</label>
                        <input type="number" name="discount_price" step="0.01" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500/50">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Stock</label>
                        <input type="number" name="stock" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500/50">
                    </div>
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Product Image</label>
                        <input type="file" name="image" accept="image/*"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-500 file:text-white file:hover:bg-indigo-400 file:cursor-pointer">
                        <p class="text-xs text-zinc-500 mt-1">JPG, PNG or WebP. Max 2MB.</p>
                    </div>
                    <div>
                        <label class="block text-sm text-zinc-400 mb-2">Brand</label>
                        <select name="brand_id" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500/50">
                            <option value="">No Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Categories</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($categories as $category)
                            <label class="flex items-center gap-2 p-3 bg-dark-800 rounded-xl cursor-pointer">
                                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" class="text-indigo-500">
                                <span class="text-sm">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" checked class="text-indigo-500">
                        <span class="text-sm">Active</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_featured" value="1" class="text-indigo-500">
                        <span class="text-sm">Featured</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-4 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105">
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection