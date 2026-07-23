<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $wishlistItems = collect();
        
        if (auth()->check()) {
            $wishlistItems = auth()->user()->wishlist()->with(['brand', 'images'])->get();
        }
        
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function toggle(Product $product)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        if ($user->wishlist()->where('product_id', $product->id)->exists()) {
            $user->wishlist()->detach($product->id);
            $message = __('messages.removed_from_wishlist');
        } else {
            $user->wishlist()->attach($product->id);
            $message = __('messages.added_to_wishlist');
        }

        return back()->with('success', $message);
    }

    public function addToCart(Product $product)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Додаємо в кошик (БД)
        $existing = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->increment('quantity');
            $existing->update(['expires_at' => now()->addHour()]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => 1,
                'expires_at' => now()->addHour(),
            ]);
        }

        // Видаляємо з wishlist
        auth()->user()->wishlist()->detach($product->id);

        return redirect()->route('cart.index')->with('success', __('messages.moved_to_cart'));
    }
}