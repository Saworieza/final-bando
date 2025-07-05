<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Seller Dashboard
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <p class="text-gray-700 text-lg">Welcome back, {{ Auth::user()->name }}!</p>
            <div class="text-sm text-gray-500">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>

        @php
            $products = Auth::user()->products()->latest()->get();
            $totalProducts = $products->count();
            $activeProducts = $products->where('status', 'active')->count();
            $inactiveProducts = $products->where('status', 'inactive')->count();
            $lowStockProducts = $products->where('stock_quantity', '<', 10)->count();
            $totalValue = $products->sum('price');
            
            // Mock data for quotes and orders (replace with actual queries when models are created)
            $totalQuotes = 15; // Replace with actual quote count
            $pendingQuotes = 8; // Replace with actual pending quote count
            $totalOrders = 25; // Replace with actual order count
            $pendingOrders = 5; // Replace with actual pending order count
            $totalSales = 45000; // Replace with actual sales sum
        @endphp

        <!-- Dashboard Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Products Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-600">Total Products</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $activeProducts }} active, {{ $inactiveProducts }} inactive
                        </p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Quotes Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-600">Quote Requests</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalQuotes }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $pendingQuotes }} pending responses
                        </p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-600">Orders Received</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $pendingOrders }} pending fulfillment
                        </p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Sales Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-600">Total Sales</h3>
                        <p class="text-2xl font-bold text-gray-900">KES {{ number_format($totalSales, 2) }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            Portfolio value: KES {{ number_format($totalValue, 2) }}
                        </p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('products.create') }}"
               class="inline-flex items-center bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200 shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Product
            </a>
            
            <a href="#" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                View Quotes
            </a>
            
            <a href="#" class="inline-flex items-center bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-200 shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Manage Orders
            </a>
        </div>

        <!-- Stock Status Alert -->
        @if($lowStockProducts > 0)
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <span class="text-red-800 font-medium">Low Stock Alert:</span>
                    <span class="text-red-700 ml-2">{{ $lowStockProducts }} products have low stock (less than 10 units)</span>
                </div>
            </div>
        @endif

        @php
            // Mock quote data (replace with actual queries when quote model is created)
            $quotes = [
                (object) [
                    'id' => 1,
                    'item_name' => 'iPhone 15 Pro',
                    'requester' => 'John Doe',
                    'email' => 'john.doe@example.com',
                    'date_requested' => '2024-01-15',
                    'status' => 'read',
                    'message' => 'Looking for bulk pricing on iPhone 15 Pro models'
                ],
                (object) [
                    'id' => 2,
                    'item_name' => 'Samsung Galaxy S24',
                    'requester' => 'Jane Smith',
                    'email' => 'jane.smith@example.com',
                    'date_requested' => '2024-01-14',
                    'status' => 'replied',
                    'message' => 'Need quote for 50 units with warranty'
                ],
                (object) [
                    'id' => 3,
                    'item_name' => 'MacBook Air M2',
                    'requester' => 'Peter Johnson',
                    'email' => 'peter.j@example.com',
                    'date_requested' => '2024-01-13',
                    'status' => 'fulfilled',
                    'message' => 'Corporate purchase inquiry'
                ],
                (object) [
                    'id' => 4,
                    'item_name' => 'Dell XPS 13',
                    'requester' => 'Sarah Wilson',
                    'email' => 'sarah.w@example.com',
                    'date_requested' => '2024-01-12',
                    'status' => 'read',
                    'message' => 'Educational discount inquiry'
                ],
                (object) [
                    'id' => 5,
                    'item_name' => 'iPad Pro 12.9',
                    'requester' => 'Michael Brown',
                    'email' => 'michael.b@example.com',
                    'date_requested' => '2024-01-11',
                    'status' => 'replied',
                    'message' => 'Bulk order for design agency'
                ]
            ];
        @endphp

        <!-- Products & Quotes Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Products Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">My Products</h3>
                    <p class="text-sm text-gray-600">Manage your product inventory</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="{{ route('products.edit', $product) }}" class="hover:text-blue-600">
                                                        {{ $product->name }}
                                                    </a>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ Str::limit($product->description ?? 'No description', 30) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">KES {{ number_format($product->price, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $product->stock_quantity ?? 'N/A' }}
                                            @if(($product->stock_quantity ?? 0) < 10)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">
                                                    Low
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ ($product->status ?? 'active') === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($product->status ?? 'active') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <p class="text-sm">No products yet</p>
                                            <a href="{{ route('products.create') }}" class="text-sm text-blue-600 hover:text-blue-800 mt-1">Add your first product</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quotes Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Quote Requests</h3>
                    <p class="text-sm text-gray-600">Manage customer quote requests</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requester</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($quotes as $quote)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <div class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $quote->item_name }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($quote->message, 30) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $quote->requester }}</div>
                                        <div class="text-sm text-gray-500">{{ $quote->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($quote->date_requested)->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($quote->status === 'read') bg-blue-100 text-blue-800
                                            @elseif($quote->status === 'replied') bg-yellow-100 text-yellow-800
                                            @elseif($quote->status === 'fulfilled') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($quote->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($quote->status === 'read')
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Reply</a>
                                        @elseif($quote->status === 'replied')
                                            <a href="#" class="text-green-600 hover:text-green-900">Follow Up</a>
                                        @else
                                            <a href="#" class="text-gray-600 hover:text-gray-900">View</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-sm">No quote requests yet</p>
                                            <p class="text-sm text-gray-400 mt-1">Customer quote requests will appear here</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>