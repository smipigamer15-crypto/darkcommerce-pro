@extends('layouts.admin')

@section('title', 'Edit Product - Admin')

@section('content')
<div class="p-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold">Edit Product</h1>
        <a href="{{ route('admin.products.index') }}" class="text-zinc-400 hover:text-white transition-colors">← Back</a>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-[#111111] border border-white/5 rounded-2xl p-8 max-w-3xl">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm text-zinc-400 mb-2">Product Name</label>
                <input type="text" name="name" value="{{ $product->name }}" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500/50">
            </div>

            <div>
                <label class="block text-sm text-zinc-400 mb-2">Description</label>
                <textarea name="description" rows="4" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500/50">{{ $product->description }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Price</label>
                    <input type="number" name="price" step="0.01" value="{{ $product->price }}" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500/50">
                </div>
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Discount Price</label>
                    <input type="number" name="discount_price" step="0.01" value="{{ $product->discount_price }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500/50">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Stock</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500/50">
                </div>
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Brand</label>
                    <select name="brand_id" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500/50">
                        <option value="">No Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm text-zinc-400 mb-2">Categories</label>
                <div class="grid grid-cols-3 gap-2">
                    @foreach($categories as $category)
                        <label class="flex items-center gap-2 p-3 bg-dark-800 rounded-xl cursor-pointer">
                            <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" 
                                   {{ $product->categories->contains($category->id) ? 'checked' : '' }} class="text-indigo-500">
                            <span class="text-sm">{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm text-zinc-400 mb-2">Product Image</label>
                <input type="file" name="image" accept="image/*" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-500 file:text-white">
                @if($product->primary_image)
                    <img src="{{ $product->primary_image->url }}" class="w-32 h-32 object-cover rounded-xl mt-3 border border-white/5">
                @endif
            </div>

            <div class="flex gap-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="text-indigo-500">
                    <span class="text-sm">Active</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="text-indigo-500">
                    <span class="text-sm">Featured</span>
                </label>
            </div>

            <button type="submit" class="w-full py-4 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105">
                Update Product
            </button>
        </div>
    </form>
</div>
@endsection