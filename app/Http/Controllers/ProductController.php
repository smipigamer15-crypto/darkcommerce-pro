<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductView;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('products.index');
    }

    public function show(string $slug): View
    {
        $product = Product::with(['brand', 'categories', 'images', 'reviews.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        if (auth()->check()) {
            $existingView = ProductView::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->first();

            if ($existingView) {
                $existingView->update(['viewed_at' => now()]);
            } else {
                ProductView::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'session_id' => session()->getId(),
                    'viewed_at' => now(),
                ]);
            }

            $oldViews = ProductView::where('user_id', auth()->id())
                ->latest('viewed_at')
                ->skip(50)
                ->take(100)
                ->pluck('id');

            if ($oldViews->count() > 0) {
                ProductView::whereIn('id', $oldViews)->delete();
            }
        }

        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', $product->categories->pluck('id')))
            ->inRandomOrder()->take(4)->get();

        $reviews = $product->reviews()->where('is_approved', true)->latest()->get();

        return view('products.show', compact('product', 'relatedProducts', 'reviews'));
    }
}