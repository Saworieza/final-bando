<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Seller Dashboard
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-8">

        {{-- KPI Row --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @php
                $sellerId = auth()->id();
                $products = \App\Models\Product::where('user_id', $sellerId)->get();
                $quotes   = \App\Models\Quote::whereHas('product', fn($q) => $q->where('user_id', $sellerId));
            @endphp

            @foreach ([
                ['label'=>'Products',      'value'=>$products->count()],
                ['label'=>'Active',        'value'=>$products->where('status','Active')->count()],
                ['label'=>'Low Stock',     'value'=>$products->where('stock_qty','<',10)->count()],
                ['label'=>'Quote Requests','value'=>$quotes->count()],
                ['label'=>'Pending Quotes','value'=>$quotes->where('status','pending')->count()],
            ] as $kpi)
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-600">{{ $kpi['label'] }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $kpi['value'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Quick Actions --}}
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('products.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Add Product
            </a>
            <a href="{{ route('quotes.index') }}?filter=seller"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                View Quotes
            </a>
        </div>

        {{-- Low-Stock Alert --}}
        @if($products->where('stock_qty','<',10)->count())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <span class="text-red-800 font-medium">Low Stock:</span>
                <span class="text-red-700 ml-2">
                    {{ $products->where('stock_qty','<',10)->count() }} products below 10 units
                </span>
            </div>
        @endif

        {{-- Tables Side-by-Side --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- My Products --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b font-semibold text-gray-900">My Products</div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-left">Price</th>
                                <th class="px-4 py-2 text-left">Stock</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products->take(5) as $p)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ Str::limit($p->name, 25) }}</td>
                                    <td class="px-4 py-2">KES {{ number_format($p->price, 2) }}</td>
                                    <td class="px-4 py-2">
                                        <span class="{{ $p->stock_qty < 10 ? 'text-red-600 font-semibold' : '' }}">
                                            {{ $p->stock_qty }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('products.edit', $p) }}" class="text-indigo-600 hover:underline">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                        No products yet. <a href="{{ route('products.create') }}" class="text-blue-600 underline">Add one</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Recent Quotes --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b font-semibold text-gray-900">Recent Quote Requests</div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Product</th>
                                <th class="px-4 py-2 text-left">Qty</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($quotes->with('product')->latest()->take(5)->get() as $q)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ Str::limit($q->product->name, 25) }}</td>
                                    <td class="px-4 py-2">{{ $q->quantity }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-0.5 rounded text-xs font-semibold
                                            {{ $q->status === 'pending'  ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $q->status === 'accepted' ? 'bg-green-100 text-green-800'   : '' }}
                                            {{ $q->status === 'completed' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                            {{ $q->status === 'rejected' ? 'bg-red-100 text-red-800'       : '' }}">
                                            {{ ucfirst($q->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('quotes.show', $q) }}" class="text-indigo-600 hover:underline">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">No quote requests yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>