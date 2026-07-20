<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ReturnModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReturnController extends Controller
{
    public function create(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($order->status, ['delivered'])) {
            return back()->with('error', 'You can only return delivered orders.');
        }

        $existingReturn = ReturnModel::where('order_id', $order->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReturn) {
            return redirect()->route('returns.show', $existingReturn);
        }

        return view('returns.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
            'return_method' => 'required|in:refund,exchange,store_credit',
        ]);

        $rma = ReturnModel::create([
            'rma_number' => 'RMA-' . strtoupper(Str::random(10)),
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'reason' => $request->reason,
            'return_method' => $request->return_method,
        ]);

        return redirect()->route('returns.show', $rma)->with('success', 'Return request submitted!');
    }

    public function show(ReturnModel $return)
    {
        if ($return->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('returns.show', compact('return'));
    }

    public function index()
    {
        $returns = ReturnModel::where('user_id', auth()->id())
            ->with('order')
            ->latest()
            ->paginate(10);

        return view('returns.index', compact('returns'));
    }
}