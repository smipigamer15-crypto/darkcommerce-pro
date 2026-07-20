<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; background: #09090B; color: #fff; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 40px 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #6366F1; font-size: 28px; }
        .card { background: #111111; border-radius: 16px; padding: 24px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.05); }
        .order-number { color: #6366F1; font-size: 18px; font-weight: bold; }
        .total { font-size: 24px; font-weight: bold; color: #fff; }
        .item { padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .item:last-child { border: none; }
        .label { color: #9CA3AF; font-size: 14px; }
        .value { color: #fff; font-size: 16px; font-weight: bold; }
        .btn { display: inline-block; background: #6366F1; color: #fff; padding: 12px 32px; border-radius: 12px; text-decoration: none; font-weight: bold; margin-top: 20px; }
        .footer { text-align: center; color: #6B7280; font-size: 12px; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Order Confirmed!</h1>
            <p style="color: #9CA3AF;">Thank you for your purchase</p>
        </div>

        <div class="card">
            <p class="order-number">Order #{{ $order->order_number }}</p>
            <p style="color: #9CA3AF; margin-top: 4px;">{{ $order->created_at->format('F d, Y') }}</p>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 16px;">Order Details</h3>
            @foreach($order->items as $item)
                <div class="item">
                    <table width="100%">
                        <tr>
                            <td><span class="value">{{ $item->product_name }}</span></td>
                            <td align="right"><span class="label">x{{ $item->quantity }}</span></td>
                            <td align="right" width="100"><span class="value">${{ number_format($item->subtotal, 2) }}</span></td>
                        </tr>
                    </table>
                </div>
            @endforeach

            <table width="100%" style="margin-top: 16px;">
                <tr>
                    <td><span class="label">Subtotal</span></td>
                    <td align="right"><span class="value">${{ number_format($order->subtotal, 2) }}</span></td>
                </tr>
                <tr>
                    <td><span class="label">Shipping</span></td>
                    <td align="right"><span class="value">{{ $order->shipping > 0 ? '$' . number_format($order->shipping, 2) : 'Free' }}</span></td>
                </tr>
                <tr>
                    <td><span class="label">Tax</span></td>
                    <td align="right"><span class="value">${{ number_format($order->tax, 2) }}</span></td>
                </tr>
                @if($order->discount > 0)
                    <tr>
                        <td><span style="color: #22C55E;">Discount</span></td>
                        <td align="right"><span style="color: #22C55E;">-${{ number_format($order->discount, 2) }}</span></td>
                    </tr>
                @endif
                <tr>
                    <td colspan="2"><hr style="border-color: rgba(255,255,255,0.05); margin: 12px 0;"></td>
                </tr>
                <tr>
                    <td><span class="total">Total</span></td>
                    <td align="right"><span class="total">${{ number_format($order->total, 2) }}</span></td>
                </tr>
            </table>
        </div>

        @if($order->shipping_address)
            <div class="card">
                <h3 style="margin-bottom: 16px;">Shipping Address</h3>
                <p class="value">{{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}</p>
                <p class="label">{{ $order->shipping_address['address'] }}</p>
                <p class="label">{{ $order->shipping_address['city'] }}, {{ $order->shipping_address['postal_code'] }}</p>
                <p class="label">{{ $order->shipping_address['country'] }}</p>
            </div>
        @endif

        <div style="text-align: center;">
            <a href="{{ url('/orders/' . $order->id) }}" class="btn">Track Your Order</a>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} DarkCommerce Pro. All rights reserved.</p>
            <p>This is an automated email, please do not reply.</p>
        </div>
    </div>
</body>
</html>