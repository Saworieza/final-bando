<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
// use App\Models\BlogPost;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;

class DashboardRedirectController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            // Get dashboard data for admin
            $dashboardData = $this->getAdminDashboardData();
            return view('admin.dashboard', $dashboardData);
        } elseif ($user->hasRole('Seller')) {
            // Get dashboard data for seller
            $dashboardData = $this->getSellerDashboardData();
            return view('seller.dashboard', $dashboardData);
        } elseif ($user->hasRole('Buyer')) {
            return view('buyer.dashboard');
        } elseif ($user->hasRole('Support Agent')) {
            return view('support.dashboard');
        } else {
            abort(403, 'Unauthorized.');
        }
    }

    private function getAdminDashboardData()
    {
        // Get current month sales data
        $currentMonth = Carbon::now()->startOfMonth();
        // $totalSales = Order::where('created_at', '>=', $currentMonth)
        //     ->where('status', 'completed')
        //     ->sum('total_amount');
        
        // Get total orders
        // $totalOrders = Order::count();
        
        // Get new customers this month
        $newCustomers = User::where('created_at', '>=', $currentMonth)
            ->role('Buyer')
            ->count();
        
        // Get low stock count (products with quantity/stock <= 5)
        $lowStockCount = Product::where(function($query) {
            $query->where('stock', '<=', 5)
                  ->orWhere('quantity', '<=', 5);
        })->count();
        
        // Get recent products (latest 5)
        $recentProducts = Product::latest()
            ->take(5)
            ->get();
        
        // Get recent blog posts (latest 5)
        // $recentPosts = BlogPost::latest()
        //     ->take(5)
        //     ->get();
        
        return [
            // 'totalSales' => $totalSales,
            // 'totalOrders' => $totalOrders,
            'newCustomers' => $newCustomers,
            'lowStockCount' => $lowStockCount,
            'recentProducts' => $recentProducts,
            // 'recentPosts' => $recentPosts
        ];
    }

    private function getSellerDashboardData()
    {
        $sellerId = Auth::id();
        
        // Get current month sales data for this seller
        $currentMonth = Carbon::now()->startOfMonth();
        // $totalSales = Order::whereHas('items', function($query) use ($sellerId) {
        //     $query->whereHas('product', function($q) use ($sellerId) {
        //         $q->where('user_id', $sellerId);
        //     });
        // })->where('created_at', '>=', $currentMonth)
        // ->where('status', 'completed')
        // ->sum('total_amount');
        
        // Get total orders for this seller
        // $totalOrders = Order::whereHas('items', function($query) use ($sellerId) {
        //     $query->whereHas('product', function($q) use ($sellerId) {
        //         $q->where('user_id', $sellerId);
        //     });
        // })->count();
        
        // Get low stock count for this seller's products
        $lowStockCount = Product::where('user_id', $sellerId)
            ->where(function($query) {
                $query->where('stock', '<=', 5)
                      ->orWhere('quantity', '<=', 5);
            })->count();
        
        // Get recent products for this seller (latest 5)
        $recentProducts = Product::where('user_id', $sellerId)
            ->latest()
            ->take(5)
            ->get();
        
        return [
            // 'totalSales' => $totalSales,
            // 'totalOrders' => $totalOrders,
            'lowStockCount' => $lowStockCount,
            'recentProducts' => $recentProducts
        ];
    }
}