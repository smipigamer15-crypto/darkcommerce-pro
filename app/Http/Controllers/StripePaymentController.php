<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripePaymentController extends Controller
{
    public function checkout(Order $order)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];
        
        foreach ($order->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product_name,
                    ],
                    'unit_amount' => (int)($item->price * 100),
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('stripe.success', $order) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel', $order),
            'metadata' => [
                'order_id' => $order->id,
            ],
        ]);

        return redirect($session->url);
    }

    public function success(Request $request, Order $order)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        
        $session = Session::retrieve($request->session_id);
        
        if ($session->payment_status === 'paid') {
            $order->update([
                'status' => 'paid',
                'payment_status' => 'completed',
                'payment_method' => 'stripe',
                'paid_at' => now(),
            ]);
            
            return redirect()->route('checkout.success', $order)->with('success', 'Payment successful!');
        }
        
        return redirect()->route('checkout.success', $order);
    }

    public function cancel(Order $order)
    {
        $order->update([
            'status' => 'cancelled',
            'payment_status' => 'failed',
        ]);
        
        return redirect()->route('cart.index')->with('error', 'Payment was cancelled.');
    }
}