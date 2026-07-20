<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand', 'categories'])->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'discount_price' => 'nullable|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'brand_id' => 'nullable|exists:brands,id',
        'category_ids' => 'required|array',
        'category_ids.*' => 'exists:categories,id',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $product = Product::create([
        'name' => $validated['name'],
        'slug' => \Str::slug($validated['name']),
        'sku' => 'SKU-' . \Str::random(8),
        'description' => $validated['description'],
        'short_description' => \Str::limit($validated['description'], 100),
        'price' => $validated['price'],
        'discount_price' => $validated['discount_price'] ?? null,
        'stock' => $validated['stock'],
        'brand_id' => $validated['brand_id'] ?? null,
        'is_active' => $validated['is_active'] ?? true,
        'is_featured' => $validated['is_featured'] ?? false,
    ]);

    $product->categories()->attach($validated['category_ids']);

    
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $product->images()->create([
            'url' => asset('storage/' . $path),
            'alt_text' => $product->name,
            'is_primary' => true,
            'sort_order' => 0,
        ]);
    }

    return redirect()->route('admin.products.index')->with('success', 'Product created!');
}

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'brand_id' => 'nullable|exists:brands,id',
            'category_ids' => 'required|array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'discount_price' => $validated['discount_price'] ?? null,
            'stock' => $validated['stock'],
            'brand_id' => $validated['brand_id'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
            'is_featured' => $validated['is_featured'] ?? false,
        ]);

        $product->categories()->sync($validated['category_ids']);

        return redirect()->route('admin.products.index')->with('success', 'Product updated!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted!');
    }
}