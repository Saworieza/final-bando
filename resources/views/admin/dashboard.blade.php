<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Admin Dashboard
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Add Product
                </a>
                
                <a href="{{ route('news.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    + New Article
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="text-gray-700 mb-6">Welcome back, {{ Auth::user()->name }}!</p>

            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Sales Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-4 gap-6 mb-8">
                {{-- Total Sales --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Sales (This Month)</p>
                            <p class="text-2xl font-semibold text-gray-900">KSh {{ number_format($totalSales ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>

                {{-- Total Quotes --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Quotes</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalOrders ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                {{-- Registered Buyers --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Registered Buyers</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $newCustomers ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                {{-- Low Stock Items --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Low Stock Alerts</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $lowStockCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pending Approvals Alert --}}
            @php
                $pendingUsers = \App\Models\User::role(['Pending Seller', 'Pending Support'])->get();
            @endphp

            @if($pendingUsers->count() > 0)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="font-semibold">You have {{ $pendingUsers->count() }} user(s) awaiting approval</p>
                    </div>
                </div>
            @endif

            {{-- Quick Actions Row --}}
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-4 gap-4 mb-8">
                <a href="{{ route('products.index') }}" class="bg-blue-50 border border-blue-200 rounded-lg p-4 hover:bg-blue-100 transition-colors">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-900">Manage Products</p>
                            <p class="text-xs text-blue-700">View all inventory</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('news.index') }}" class="bg-green-50 border border-green-200 rounded-lg p-4 hover:bg-green-100 transition-colors">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-900">Total Approved Quotes</p>
                            <p class="text-xs text-green-700">Quotations</p>
                        </div>
                    </div>
                </a>

                <a href="/" class="bg-purple-50 border border-purple-200 rounded-lg p-4 hover:bg-purple-100 transition-colors">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-purple-900">News Categories</p>
                            <p class="text-xs text-purple-700">Organize articles</p>
                        </div>
                    </div>
                </a>

                <a href="/" class="bg-orange-50 border border-orange-200 rounded-lg p-4 hover:bg-orange-100 transition-colors">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2-2z"></path>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-orange-900">Analytics</p>
                            <p class="text-xs text-orange-700">Sales reports</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Recent Activity Section --}}
            <div class="grid grid-cols-2 gap-8 mb-8">
                {{-- Recent Products --}}
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Recent Products</h3>
                            <div class="flex space-x-2">
                                <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                    + Add New
                                </a>
                                <a href="{{ route('products.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="p-0">
                        @forelse($recentProducts ?? [] as $product)
                            <div class="px-6 py-4 border-b border-gray-100 last:border-b-0">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('products.show', $product->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                                {{ $product->name ?? $product->title }}
                                            </a>
                                            <a href="{{ route('products.edit', $product->id) }}" class="text-xs text-gray-500 hover:text-gray-700 underline">
                                                Edit
                                            </a>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            {{ $product->category->name ?? 'Uncategorized' }} • {{ $product->created_at->format('M j, Y') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">KSh {{ number_format($product->price ?? 0) }}</p>
                                        <p class="text-xs text-gray-500">
                                            Stock: {{ $product->stock ?? $product->quantity ?? 0 }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-sm">No products found</p>
                                <p class="text-xs text-gray-400 mt-1">Products will appear here once added</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Last Five News Posts --}}
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Latest News Posts</h3>
                            <div class="flex space-x-2">
                                <a href="{{ route('news.create') }}" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                    + Add New
                                </a>
                                <a href="{{ route('news.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="p-0">
                        @php
                            // Fetch the last 5 news posts ordered by creation date
                            $lastFiveNews = \App\Models\News::orderBy('created_at', 'desc')->take(5)->get();
                        @endphp
                        
                        @forelse($lastFiveNews as $article)
                            <div class="px-6 py-4 border-b border-gray-100 last:border-b-0">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('news.show', $article->slug) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                                {{ Str::limit($article->title, 50) }}
                                            </a>
                                            <a href="{{ route('news.edit', $article->id) }}" class="text-xs text-gray-500 hover:text-gray-700 underline">
                                                Edit
                                            </a>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            {{ $article->category->name ?? 'Uncategorized' }} • {{ $article->created_at->format('M j, Y') }}
                                        </p>
                                        @if($article->excerpt)
                                            <p class="text-xs text-gray-400 mt-1">{{ Str::limit($article->excerpt, 60) }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                @if($article->status === 'published')
                                                    bg-green-100 text-green-800
                                                @elseif($article->status === 'draft')
                                                    bg-yellow-100 text-yellow-800
                                                @else
                                                    bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($article->status) }}
                                            </span>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Views: {{ $article->views_count ?? 0 }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ $article->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                                <p class="text-sm">No news articles found</p>
                                <p class="text-xs text-gray-400 mt-1">News articles will appear here once published</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Pending User Approvals Table --}}
            @if($pendingUsers->count() > 0)
                <div class="bg-white rounded-lg shadow mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Pending User Approvals</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requested Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($pendingUsers as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                {{ str_replace('Pending ', '', $user->getRoleNames()->first()) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <form method="POST" action="{{ route('admin.approve', $user->id) }}" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="new_role" value="{{ $user->hasRole('Pending Seller') ? 'Seller' : 'Support Agent' }}">
                                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded-md text-sm hover:bg-green-700">
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.approve', $user->id) }}" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="new_role" value="Buyer">
                                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-md text-sm hover:bg-red-700">
                                                    Decline
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- User Management Tabs --}}
            @php
                $tabs = ['Buyer', 'Seller', 'Support Agent'];
                $selectedTab = request('tab', 'Buyer');
                
                // Get user counts for each role
                $buyerCount = \App\Models\User::role('Buyer')->count();
                $sellerCount = \App\Models\User::role('Seller')->count();
                $supportCount = \App\Models\User::role('Support Agent')->count();
                
                $userCounts = [
                    'Buyer' => $buyerCount,
                    'Seller' => $sellerCount,
                    'Support Agent' => $supportCount
                ];
            @endphp

            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">User Management</h3>
                        <div class="flex space-x-1">
                            @foreach ($tabs as $tab)
                                <a href="{{ route('dashboard', ['tab' => $tab]) }}"
                                    class="px-3 py-2 rounded-md text-sm font-medium
                                    {{ $selectedTab === $tab ? 'bg-blue-600 text-white' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                                    <b>{{ $userCounts[$tab] }}</b> {{ $tab }}s
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                @php
                    $users = \App\Models\User::role($selectedTab)->get();
                @endphp

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Change Role</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ $user->getRoleNames()->first() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form method="POST" action="{{ route('admin.approve', $user->id) }}" class="flex items-center space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="new_role" class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                                                <option value="Buyer" {{ $user->hasRole('Buyer') ? 'selected' : '' }}>Buyer</option>
                                                <option value="Seller" {{ $user->hasRole('Seller') ? 'selected' : '' }}>Seller</option>
                                                <option value="Support Agent" {{ $user->hasRole('Support Agent') ? 'selected' : '' }}>Support Agent</option>
                                                <option value="Admin" {{ $user->hasRole('Admin') ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-700">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        No {{ $selectedTab }}s found.
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