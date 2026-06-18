<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Orders\Order;
use App\Models\Customer\Wishlist;
use App\Models\Products\Category;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Stats
        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'pending_orders' => Order::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'processing'])
                ->count(),
            'total_spent' => Order::where('user_id', $user->id)
                ->where('status', 'delivered')
                ->sum('total_amount'),
            'wishlist_count' => Wishlist::where('user_id', $user->id)->count(),
        ];

        //Categories
        $category=[
            'total_categories' =>Category::where('user-id',$user->id)->count(),

        ];

        // Recent Orders
        $recentOrders = Order::where('user_id', $user->id)
            ->with(['items', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return Inertia::render('Customers/Dashboard', [
            'user' => $user,
            'stats' => $stats,
            'recentOrders' => $recentOrders,
        ]);
    }
}
