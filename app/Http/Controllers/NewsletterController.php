<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        $existing = Subscriber::where('email', $request->email)->first();
        
        if ($existing && !$existing->is_active) {
            $existing->update([
                'is_active' => true,
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
                'unsubscribe_token' => Str::random(64),
            ]);
            
            return back()->with('success', 'Welcome back! Re-subscribed! 🎉');
        }

        Subscriber::create([
            'email' => $request->email,
            'is_active' => true,
            'subscribed_at' => now(),
            'unsubscribe_token' => Str::random(64),
        ]);

        return back()->with('success', 'Subscribed! 🎉');
    }

    public function unsubscribe($token)
    {
        $subscriber = Subscriber::where('unsubscribe_token', $token)->first();
        
        if (!$subscriber) {
            return view('newsletter.unsubscribed');
        }
        
        $subscriber->update([
            'is_active' => false,
            'unsubscribed_at' => now(),
        ]);

        return view('newsletter.unsubscribed', compact('subscriber'));
    }

    public function resubscribe(Request $request)
{
    $request->validate(['email' => 'required|email']);
    
    $subscriber = Subscriber::where('email', $request->email)->first();
    
    if ($subscriber) {
        $subscriber->update([
            'is_active' => true,
            'subscribed_at' => now(),
            'unsubscribed_at' => null,
            'unsubscribe_token' => Str::random(64),
        ]);
    } else {
        $subscriber = Subscriber::create([
            'email' => $request->email,
            'is_active' => true,
            'subscribed_at' => now(),
            'unsubscribe_token' => Str::random(64),
        ]);
    }
    
    return redirect()->route('home')->with('success', 'Successfully re-subscribed! 🎉');
}
}