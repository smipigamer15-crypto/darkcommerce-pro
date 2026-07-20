<?php

namespace App\Http\Controllers;

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
            $message = 'Removed from wishlist';
        } else {
            $user->wishlist()->attach($product->id);
            $message = 'Added to wishlist';
        }

        return back()->with('success', $message);
    }

    public function addToCart(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = ['quantity' => 1];
        }

        session()->put('cart', $cart);

        // Видаляємо з wishlist після додавання в кошик
        if (auth()->check()) {
            auth()->user()->wishlist()->detach($product->id);
        }

        return redirect()->route('cart.index')->with('success', 'Product moved to cart!');
    }
}