<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:150',
        ], [
            'comment.min' => __('messages.review_min_error'),
            'comment.max' => __('messages.review_max_error'),
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true,
        ]);

        $avgRating = $product->reviews()->where('is_approved', true)->avg('rating') ?? 0;
        $reviewsCount = $product->reviews()->where('is_approved', true)->count();
        
        $product->update([
            'rating' => round($avgRating, 1),
            'reviews_count' => $reviewsCount,
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}