<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Cart;
use App\Models\GiftCard;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = collect();
        $subtotal = 0;

        if (auth()->check()) {
            Cart::where('user_id', auth()->id())
                ->where('expires_at', '<', now())
                ->delete();

            $cartItems = Cart::with('product.brand', 'product.images')
                ->where('user_id', auth()->id())
                ->get()
                ->map(function ($item) use (&$subtotal) {
                    $itemSubtotal = $item->product->final_price * $item->quantity;
                    $subtotal += $itemSubtotal;
                    return ['id' => $item->id, 'product' => $item->product, 'quantity' => $item->quantity];
                });
        } else {
            $sessionCart = session()->get('cart', []);
            foreach ($sessionCart as $id => $item) {
                $product = Product::find($id);
                if ($product) {
                    $subtotal += $product->final_price * $item['quantity'];
                    $cartItems->push(['id' => $id, 'product' => $product, 'quantity' => $item['quantity']]);
                }
            }
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $shipping = $subtotal > 100 ? 0 : 10;
        $tax = $subtotal * 0.1;
        $couponDiscount = session('coupon') ? session('coupon')['discount'] : 0;
        $giftCardDiscount = session('gift_card') ? min(session('gift_card')['balance'], $subtotal) : 0;
        $pointsDiscount = 0;

        if (session('use_points') && auth()->check()) {
            $userPoints = auth()->user()->points;
            $maxDiscount = $subtotal + $shipping + $tax - $couponDiscount - $giftCardDiscount;
            $pointsToUse = min($userPoints, (int)($maxDiscount * 100));
            $pointsDiscount = $pointsToUse / 100;
        }

        $total = $subtotal + $shipping + $tax - $couponDiscount - $giftCardDiscount - $pointsDiscount;
        $userPoints = auth()->user()->points ?? 0;

        return view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'couponDiscount', 'giftCardDiscount', 'pointsDiscount', 'userPoints'));
    }

    public function togglePoints()
    {
        session()->put('use_points', !session('use_points'));
        return back();
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ]);

        $subtotal = 0;
        $orderItems = [];

        if (auth()->check()) {
            $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
            foreach ($cartItems as $item) {
                $subtotal += $item->product->final_price * $item->quantity;
                $orderItems[] = ['product' => $item->product, 'quantity' => $item->quantity];
            }
        } else {
            $sessionCart = session()->get('cart', []);
            foreach ($sessionCart as $id => $item) {
                $product = Product::find($id);
                if ($product) {
                    $subtotal += $product->final_price * $item['quantity'];
                    $orderItems[] = ['product' => $product, 'quantity' => $item['quantity']];
                }
            }
        }

        if (empty($orderItems)) {
            return redirect()->route('cart.index');
        }

        $shipping = $subtotal > 100 ? 0 : 10;
        $tax = $subtotal * 0.1;
        $couponDiscount = session('coupon') ? session('coupon')['discount'] : 0;
        $couponCode = session('coupon') ? session('coupon')['code'] : null;
        $giftCardDiscount = session('gift_card') ? min(session('gift_card')['balance'], $subtotal) : 0;
        $totalBeforePoints = $subtotal + $shipping + $tax - $couponDiscount - $giftCardDiscount;
        $pointsDiscount = 0;

        if (session('use_points') && auth()->check()) {
            $userPoints = auth()->user()->points;
            $maxDiscount = min($userPoints, (int)($totalBeforePoints * 100));
            $pointsDiscount = $maxDiscount / 100;
        }

        $total = $totalBeforePoints - $pointsDiscount;
        $totalDiscount = $couponDiscount + $giftCardDiscount + $pointsDiscount;

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'user_id' => auth()->id() ?? 1,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method ?? 'card',
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'discount' => $totalDiscount,
            'total' => $total,
            'coupon_code' => $couponCode,
            'shipping_address' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
            ],
        ]);

        foreach ($orderItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'price' => $item['product']->final_price,
                'quantity' => $item['quantity'],
                'subtotal' => $item['product']->final_price * $item['quantity'],
            ]);
            $item['product']->decrement('stock', $item['quantity']);
            $item['product']->increment('sales_count', $item['quantity']);
        }

        if ($pointsDiscount > 0 && auth()->check()) {
            auth()->user()->redeemPoints((int)($pointsDiscount * 100));
        }

        if (auth()->check()) {
            $pointsEarned = (int)($total * 5);
            auth()->user()->addPoints($pointsEarned);
            session()->flash('points_earned', $pointsEarned);
            Cart::where('user_id', auth()->id())->delete();
        }

        session()->forget('cart');
        session()->forget('coupon');
        session()->forget('gift_card');
        session()->forget('use_points');

        Mail::to($request->email)->send(new OrderConfirmation($order));

        if ($request->payment_method === 'stripe') {
            return redirect()->route('stripe.checkout', $order);
        }

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }
}