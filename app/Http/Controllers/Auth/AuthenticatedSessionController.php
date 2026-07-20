<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Переносимо гостьовий кошик в БД при логіні
            if (session()->has('cart')) {
                $sessionCart = session()->pull('cart');
                foreach ($sessionCart as $productId => $item) {
                    $existing = \App\Models\Cart::where('user_id', auth()->id())
                        ->where('product_id', $productId)
                        ->first();
                    if ($existing) {
                        $existing->increment('quantity', $item['quantity']);
                    } else {
                        \App\Models\Cart::create([
                            'user_id' => auth()->id(),
                            'product_id' => $productId,
                            'quantity' => $item['quantity'],
                            'expires_at' => now()->addHour(),
                        ]);
                    }
                }
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}