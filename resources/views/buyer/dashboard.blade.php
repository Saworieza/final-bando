<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Buyer Dashboard</h2>
            <a href="{{ route('products.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Browse Products
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- KPI Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ([
                    ['label' => 'Total Quotes',   'value' => $totalQuotes,        'color' => 'blue'],
                    ['label' => 'Pending',        'value' => $pendingQuotes,      'color' => 'yellow'],
                    ['label' => 'Accepted',       'value' => $acceptedQuotes,     'color' => 'green'],
                    ['label' => 'Completed',      'value' => $completedQuotes,    'color' => 'indigo'],
                    ['label' => 'Rejected',       'value' => $rejectedQuotes,     'color' => 'red'],
                    ['label' => 'Total Spent',    'value' => 'KES '.number_format($totalSpent), 'color' => 'purple'],
                ] as $kpi)
                    <div class="bg-white rounded-lg shadow p-4">
                        <p class="text-sm font-medium text-gray-600">{{ $kpi['label'] }}</p>
                        <p class="text-2xl font-bold text-{{ $kpi['color'] }}-600">{{ $kpi['value'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('products.index') }}" class="bg-blue-50 border border-blue-200 rounded-lg p-4 hover:bg-blue-100 transition">
                    <p class="font-semibold text-blue-900">Browse Products</p>
                    <p class="text-xs text-blue-700">Find new items</p>
                </a>
                <a href="{{ route('quotes.index') }}" class="bg-green-50 border border-green-200 rounded-lg p-4 hover:bg-green-100 transition">
                    <p class="font-semibold text-green-900">My Quotes</p>
                    <p class="text-xs text-green-700">View all requests</p>
                </a>
                <a href="{{ route('profile.edit') }}" class="bg-purple-50 border border-purple-200 rounded-lg p-4 hover:bg-purple-100 transition">
                    <p class="font-semibold text-purple-900">My Profile</p>
                    <p class="text-xs text-purple-700">Update details</p>
                </a>
            </div>

            {{-- Re-order Suggestions --}}
            @if($reorderSuggestions->isNotEmpty())
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-semibold mb-4">Re-order Suggestions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach ($reorderSuggestions as $product)
                            <a href="{{ route('products.show', $product) }}" class="border rounded-lg p-3 hover:shadow">
                                <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/150' }}" class="w-full h-24 object-cover rounded mb-2">
                                <p class="font-semibold text-sm">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">KES {{ number_format($product->price, 2) }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Top Suppliers --}}
            @if($topSuppliers->isNotEmpty())
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-semibold mb-4">Top Suppliers</h3>
                    <div class="space-y-2">
                        @foreach ($topSuppliers as $supplier)
                            <div class="flex justify-between items-center border rounded p-2">
                                <span class="font-medium">{{ $supplier->name }}</span>
                                <span class="text-sm text-gray-500">{{ $supplier->email }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Quote List with Tabs --}}
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="text-lg font-semibold">My Quotes</h3>
                    <div class="flex space-x-1">
                        @php $tabs = ['all' => 'All', 'pending' => 'Pending', 'accepted' => 'Accepted', 'completed' => 'Completed', 'rejected' => 'Rejected']; @endphp
                        @foreach ($tabs as $key => $label)
                            <a href="{{ request()->fullUrlWithQuery(['tab' => $key]) }}"
                               class="px-3 py-1 rounded text-sm font-medium
                                      {{ request('tab', 'all') === $key ? 'bg-blue-600 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Seller</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($quotes as $quote)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="{{ $quote->product->image ? asset('storage/'.$quote->product->image) : 'https://via.placeholder.com/40' }}" class="h-10 w-10 rounded object-cover">
                                            <div class="ml-3">
                                                <div class="text-sm font-medium">{{ $quote->product->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $quote->product->category->name ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $quote->product->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $quote->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full
                                            {{ $quote->status === 'pending'  ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $quote->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $quote->status === 'completed' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                            {{ $quote->status === 'rejected'  ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($quote->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $quote->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                        <a href="{{ route('quotes.show', $quote) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                        @if($quote->status === 'pending')
                                            <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Cancel this quote?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Cancel</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        No quotes found.
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