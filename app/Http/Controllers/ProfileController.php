<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductView;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->latest()->take(5)->get();
        $subscription = Subscriber::where('email', $user->email)->first();
        
        $recentlyViewed = ProductView::with('product.images')
            ->where('user_id', auth()->id())
            ->latest('viewed_at')
            ->take(20)
            ->get()
            ->unique('product_id');

        return view('profile.edit', compact('user', 'orders', 'subscription', 'recentlyViewed'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update($request->only('name', 'email'));

        return back()->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully');
    }
}