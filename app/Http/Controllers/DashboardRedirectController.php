<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Quote; // Add this import
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
            // Get dashboard data for buyer
            $dashboardData = $this->getBuyerDashboardData();
            return view('buyer.dashboard', $dashboardData);
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

        // Get recent quotes (latest 5)
        $recentQuotes = Quote::latest()
            ->take(5)
            ->get();
        
        return [
            // 'totalSales' => $totalSales,
            // 'totalOrders' => $totalOrders,
            'newCustomers' => $newCustomers,
            'lowStockCount' => $lowStockCount,
            'recentProducts' => $recentProducts,
            'recentQuotes' => $recentQuotes,
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
        
        // Get recent quotes for this seller (latest 5)
        $recentQuotes = Quote::where('user_id', $sellerId)
            ->latest()
            ->take(5)
            ->get();
        
        return [
            // 'totalSales' => $totalSales,
            // 'totalOrders' => $totalOrders,
            'lowStockCount' => $lowStockCount,
            'recentProducts' => $recentProducts,
            'recentQuotes' => $recentQuotes
        ];
    }

    private function getBuyerDashboardData()
    {
        $buyerId = Auth::id();
        
        // Get current month data for this buyer
        $currentMonth = Carbon::now()->startOfMonth();
        
        // Uncomment and modify these as needed based on your Order model structure
        // $totalSales = Order::where('buyer_id', $buyerId)
        //     ->where('created_at', '>=', $currentMonth)
        //     ->where('status', 'completed')
        //     ->sum('total_amount');
        
        // $totalOrders = Order::where('buyer_id', $buyerId)->count();
        
        // Get low stock count for this buyer's products (if buyers can have products)
        $lowStockCount = Product::where('user_id', $buyerId)
            ->where(function($query) {
                $query->where('stock', '<=', 5)
                      ->orWhere('quantity', '<=', 5);
            })->count();
        
        // Get recent products for this buyer (latest 5)
        $recentProducts = Product::where('user_id', $buyerId)
            ->latest()
            ->take(5)
            ->get();

        // Get recent quotes for this buyer (latest 5)
        $recentQuotes = Quote::where('user_id', $buyerId)
            ->latest()
            ->take(5)
            ->get();

        // Get quote statistics for summary cards
        $totalQuotes = Quote::where('user_id', $buyerId)->count();
        $pendingQuotes = Quote::where('user_id', $buyerId)->where('status', 'pending')->count();
        $acceptedQuotes = Quote::where('user_id', $buyerId)->where('status', 'accepted')->count();
        $rejectedQuotes = Quote::where('user_id', $buyerId)->where('status', 'rejected')->count();

        // Get filtered quotes for the main table
        $selectedTab = request('tab', 'all');
        $quotesQuery = Quote::where('user_id', $buyerId)->with(['product', 'product.user', 'product.category']);
        
        if ($selectedTab !== 'all') {
            $quotesQuery->where('status', $selectedTab);
        }
        
        $quotes = $quotesQuery->latest()->get();
        
        return [
            // 'totalSales' => $totalSales,
            // 'totalOrders' => $totalOrders,
            'lowStockCount' => $lowStockCount,
            'recentProducts' => $recentProducts,
            'recentQuotes' => $recentQuotes,
            'totalQuotes' => $totalQuotes,
            'pendingQuotes' => $pendingQuotes,
            'acceptedQuotes' => $acceptedQuotes,
            'rejectedQuotes' => $rejectedQuotes,
            'quotes' => $quotes,
        ];
    }
}