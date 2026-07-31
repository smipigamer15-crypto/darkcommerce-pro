<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $coupon = Coupon::where('code', strtoupper($request->code))->where('is_active', true)->first();

        if (!$coupon) return back()->with('error', 'Invalid coupon code.');
        if ($coupon->expires_at && now()->gt($coupon->expires_at)) return back()->with('error', 'Coupon expired.');
        if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) return back()->with('error', 'Limit reached.');

        $subtotal = 0;
        if (auth()->check()) {
            $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
            foreach ($cartItems as $item) {
                $subtotal += $item->product->final_price * $item->quantity;
            }
        }

        if ($subtotal == 0) return back()->with('error', 'Your cart is empty.');

        if ($coupon->min_amount && $subtotal < $coupon->min_amount) {
            return back()->with('error', 'Minimum order $' . number_format($coupon->min_amount, 2) . '. Your cart: $' . number_format($subtotal, 2));
        }

        $discount = $coupon->type === 'percentage' ? $subtotal * ($coupon->value / 100) : min($coupon->value, $subtotal);

        session()->put('coupon', [
            'code' => $coupon->code,
            'discount' => $discount,
            'type' => $coupon->type,
            'value' => $coupon->value,
        ]);

        return back()->with('success', 'Coupon applied! You saved $' . number_format($discount, 2));
    }

    public function remove()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed.');
    }
}