<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleProduct;
use App\Models\Order;
use App\Models\Product;
use App\Models\ReturnModel;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue' => Order::sum('total'),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'recent_orders' => Order::with('user')->latest()->take(10)->get(),
            'low_stock' => Product::where('stock', '<=', 10)->where('stock', '>', 0)->take(5)->get(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'revenue_today' => Order::whereDate('created_at', today())->sum('total'),
        ];

        return view('admin.dashboard', $stats);
    }

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        $oldStatus = $order->status;
        $order->update([
            'status' => $request->status,
            'shipped_at' => $request->status === 'shipped' ? now() : $order->shipped_at,
            'delivered_at' => $request->status === 'delivered' ? now() : $order->delivered_at,
            'cancelled_at' => $request->status === 'cancelled' ? now() : $order->cancelled_at,
        ]);

        return back()->with('success', 'Order status updated!');
    }

    public function users()
    {
        $users = User::withCount('orders')->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate(['is_admin' => 'required|boolean']);
        $user->update(['is_admin' => $request->is_admin]);
        return back()->with('success', 'User role updated!');
    }

    public function subscribers()
    {
        $subscribers = Subscriber::latest()->paginate(20);
        return view('admin.subscribers', compact('subscribers'));
    }

    public function returns()
    {
        $returns = ReturnModel::with(['order', 'user'])->latest()->paginate(20);
        return view('admin.returns', compact('returns'));
    }

    public function updateReturn(Request $request, ReturnModel $return)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
            'admin_notes' => 'nullable|string',
        ]);
        $return->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'resolved_at' => in_array($request->status, ['approved', 'rejected', 'completed']) ? now() : null,
        ]);
        if ($request->status === 'approved') {
            $return->order->update(['status' => 'refunded', 'payment_status' => 'refunded']);
        }
        return back()->with('success', 'Return updated!');
    }

    // Flash Sales
    public function flashSales()
    {
        $flashSales = FlashSale::with('products')->latest()->get();
        return view('admin.flash-sales', compact('flashSales'));
    }

    public function storeFlashSale(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'discount_percentage' => 'required|integer|min:1|max:99',
        ]);

        $flash = FlashSale::create([
            'title' => $request->title,
            'description' => $request->description,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'discount_percentage' => $request->discount_percentage,
            'is_active' => true,
        ]);

        if ($request->products) {
            foreach ($request->products as $productId) {
                $product = Product::find($productId);
                FlashSaleProduct::create([
                    'flash_sale_id' => $flash->id,
                    'product_id' => $productId,
                    'sale_price' => $product->price * (1 - $request->discount_percentage / 100),
                ]);
            }
        }

        return redirect()->route('admin.flash-sales')->with('success', 'Flash sale created!');
    }

    public function toggleFlashSale(FlashSale $flashSale)
    {
        $flashSale->update(['is_active' => !$flashSale->is_active]);
        return back()->with('success', 'Flash sale updated!');
    }

    public function deleteFlashSale(FlashSale $flashSale)
    {
        $flashSale->delete();
        return back()->with('success', 'Flash sale deleted!');
    }
}