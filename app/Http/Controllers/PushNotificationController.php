<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'endpoint' => 'required',
            'keys.p256dh' => 'required',
            'keys.auth' => 'required',
        ]);

        $subscriptions = json_decode(file_get_contents(storage_path('app/push-subscriptions.json')), true) ?? [];
        
        $subscriptions[] = [
            'user_id' => auth()->id(),
            'endpoint' => $request->endpoint,
            'keys' => $request->keys,
            'created_at' => now()->toDateTimeString(),
        ];

        file_put_contents(
            storage_path('app/push-subscriptions.json'),
            json_encode($subscriptions, JSON_PRETTY_PRINT)
        );

        return response()->json(['success' => true]);
    }

    public function sendTest()
    {
        $subscriptions = json_decode(file_get_contents(storage_path('app/push-subscriptions.json')), true) ?? [];
        
        $sent = 0;
        foreach ($subscriptions as $sub) {
            $this->sendNotification($sub, [
                'title' => 'DarkCommerce 🛍️',
                'body' => 'This is a test notification! Everything works.',
                'url' => route('home'),
            ]);
            $sent++;
        }

        return back()->with('success', "Test notification sent to {$sent} subscribers!");
    }

    private function sendNotification($subscription, $data)
    {
        $payload = json_encode($data);

        try {
            $ch = curl_init($subscription['endpoint']);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload),
            ]);
            curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $e) {
            //
        }
    }
}