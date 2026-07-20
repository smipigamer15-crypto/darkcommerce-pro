<?php

namespace App\Http\Controllers;

use App\Models\GiftCard;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GiftCardController extends Controller
{
    public function create()
    {
        return view('gift-cards.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10|max:1000',
            'from_name' => 'required|string|max:255',
            'to_name' => 'required|string|max:255',
            'to_email' => 'required|email',
            'message' => 'nullable|string|max:500',
        ]);

        $giftCard = GiftCard::create([
            'code' => 'GIFT-' . strtoupper(Str::random(10)),
            'amount' => $request->amount,
            'balance' => $request->amount,
            'from_name' => $request->from_name,
            'to_name' => $request->to_name,
            'to_email' => $request->to_email,
            'message' => $request->message,
            'expires_at' => now()->addYear(),
        ]);

        return redirect()->route('gift-cards.show', $giftCard)
            ->with('success', 'Gift card created! Code: ' . $giftCard->code);
    }

    public function show(GiftCard $giftCard)
    {
        return view('gift-cards.show', compact('giftCard'));
    }

    public function check()
    {
        return view('gift-cards.check');
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $giftCard = GiftCard::where('code', $request->code)->first();

        if (!$giftCard) {
            return back()->with('error', 'Invalid gift card code.');
        }

        if (!$giftCard->is_active) {
            return back()->with('error', 'This gift card has been used.');
        }

        if ($giftCard->isExpired()) {
            return back()->with('error', 'This gift card has expired.');
        }

        session()->put('gift_card', [
            'code' => $giftCard->code,
            'balance' => $giftCard->balance,
        ]);

        return redirect()->route('cart.index')->with('success', 'Gift card applied! Balance: $' . number_format($giftCard->balance, 2));
    }

    public function remove()
    {
        session()->forget('gift_card');
        return back()->with('success', 'Gift card removed.');
    }
}