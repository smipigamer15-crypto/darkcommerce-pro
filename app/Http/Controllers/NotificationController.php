<?php

namespace App\Http\Controllers;

use App\Models\Order;

class NotificationController extends Controller
{
    public function check()
    {
        $lastCheck = session('last_notification_check', now()->subMinutes(5));
        
        $updatedOrders = Order::where('user_id', auth()->id())
            ->where('updated_at', '>', $lastCheck)
            ->where('status', '!=', 'pending')
            ->count();
        
        session(['last_notification_check' => now()]);

        return response()->json(['count' => $updatedOrders]);
    }
}