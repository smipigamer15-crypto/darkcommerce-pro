<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = collect();
        $total = 0;

        if (auth()->check()) {
            Cart::where('user_id', auth()->id())
                ->where('expires_at', '<', now())
                ->delete();

            $cartItems = Cart::with('product.brand', 'product.images')
                ->where('user_id', auth()->id())
                ->get()
                ->map(function ($item) use (&$total) {
                    $subtotal = $item->product->final_price * $item->quantity;
                    $total += $subtotal;
                    return [
                        'id' => $item->id,
                        'product' => $item->product,
                        'quantity' => $item->quantity,
                        'subtotal' => $subtotal,
                        'time_left' => $item->expires_at ? max(0, now()->diffInSeconds($item->expires_at)) : 0,
                    ];
                });
        } else {
     
            $sessionCart = session()->get('cart', []);
            foreach ($sessionCart as $id => $item) {
                $product = Product::find($id);
                if ($product) {
                    $subtotal = $product->final_price * $item['quantity'];
                    $total += $subtotal;
                    $cartItems->push([
                        'id' => $id,
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'subtotal' => $subtotal,
                        'time_left' => $item['expires_at'] ? max(0, $item['expires_at'] - now()->timestamp) : 0,
                    ]);
                }
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->first();

            if ($cart) {
                $cart->increment('quantity');
                $cart->update(['expires_at' => now()->addHour()]);
            } else {
                Cart::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'expires_at' => now()->addHour(),
                ]);
            }
        } else {

            $cart = session()->get('cart', []);

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity']++;
            } else {
                $cart[$product->id] = [
                    'quantity' => 1,
                    'expires_at' => now()->addHour()->timestamp,
                ];
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->where('id', $id)->first();
            if ($cart) {
                if ($request->quantity > 0) {
                    $cart->update(['quantity' => $request->quantity, 'expires_at' => now()->addHour()]);
                } else {
                    $cart->delete();
                }
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                if ($request->quantity > 0) {
                    $cart[$id]['quantity'] = $request->quantity;
                } else {
                    unset($cart[$id]);
                }
                session()->put('cart', $cart);
            }
        }

        return redirect()->route('cart.index');
    }

    public function remove($id)
    {
        if (auth()->check()) {
            Cart::where('user_id', auth()->id())->where('id', $id)->delete();
        } else {
            $cart = session()->get('cart', []);
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart');
    }
}