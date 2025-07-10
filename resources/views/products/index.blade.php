<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-4xl font-bold text-gray-800">Our Products</h2>
                <x-breadcrumb :links="[
                    'Products' => route('products.index'),
                    $currentCategory?->name ?? 'All Products' => null
                ]" />
            </div>
            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add Product
            </button>
        </div>
    </x-slot>

    <div class="py-6 px-4">
        <!-- Header Description -->
        <section class="text-center mb-8">
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Discover our comprehensive range of industrial belts, automotive parts, and safety equipment. 
                All products are manufactured to the highest quality standards and available for bulk purchase.
            </p>
        </section>

        <!-- Search and Filter Section -->
        <section class="mb-8">
            <div class="space-y-4">
                <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                    <!-- Search Bar -->
                    <div class="relative flex-1 max-w-md">
                        <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Search products..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                        />
                    </div>

                    <!-- Category Filter -->
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <select
                            id="categoryFilter"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                        >
                            <option value="">All Products</option>
                        </select>
                    </div>
                </div>

                <!-- Category Chips -->
                <div class="flex flex-wrap gap-2" id="categoryChips">
                    <!-- Category chips will be populated by JavaScript -->
                </div>
            </div>
        </section>

        <!-- Products Grid -->
        <section>
            <div class="mb-4 text-gray-600" id="productCount">
                Showing {{ $products->count() }} products
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="productsGrid">
                @foreach ($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 product-card" 
                         data-category="{{ $product->category->name ?? 'Uncategorized' }}"
                         data-name="{{ strtolower($product->name) }}"
                         data-description="{{ strtolower($product->description ?? '') }}">
                        @if ($product->image)
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="w-full h-48 object-cover" 
                                     alt="{{ $product->name }}" />
                            </div>
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $product->name }}</h3>
                            
                            @if($product->description)
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($product->description, 100) }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xl font-bold text-red-600">Ksh {{ number_format($product->price, 2) }}</span>
                                @if($product->rating)
                                    <div class="flex items-center">
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($product->rating))
                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-500 ml-1">({{ $product->reviews ?? 0 }})</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                @if($product->in_stock ?? true)
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">In Stock</span>
                                @else
                                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">Out of Stock</span>
                                @endif
                            </div>
                            
                            @if($product->moq)
                                <p class="text-xs text-gray-500 mb-3">MOQ: {{ $product->moq }} units</p>
                            @endif
                            
                            <div class="flex gap-2">
                                <a href="{{ route('products.show', $product) }}" 
                                   class="flex-1 bg-red-600 hover:bg-red-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                                    View Details
                                </a>
                                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No Results Message -->
            <div class="text-center py-12 hidden" id="noResults">
                <div class="max-w-md mx-auto">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-500 text-lg mb-4">No products found matching your criteria.</p>
                    <button onclick="clearFilters()" class="text-red-600 hover:underline font-medium">
                        Clear filters
                    </button>
                </div>
            </div>
        </section>


        <!-- JavaScript for Client-side Filtering -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const categoryFilter = document.getElementById('categoryFilter');
                const categoryChips = document.getElementById('categoryChips');
                const productCards = document.querySelectorAll('.product-card');
                const productCount = document.getElementById('productCount');
                const noResults = document.getElementById('noResults');
                const productsGrid = document.getElementById('productsGrid');
                
                let currentCategory = '';
                let currentSearch = '';
                
                // Extract categories from products
                const categories = new Set();
                productCards.forEach(card => {
                    const category = card.dataset.category;
                    if (category && category !== 'Uncategorized') {
                        categories.add(category);
                    }
                });
                
                // Populate category filter
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category;
                    option.textContent = category;
                    categoryFilter.appendChild(option);
                });
                
                // Create category chips
                function createCategoryChips() {
                    categoryChips.innerHTML = '';
                    
                    // All Products chip
                    const allChip = document.createElement('button');
                    allChip.textContent = 'All Products';
                    allChip.className = `px-4 py-2 rounded-full text-sm font-medium transition-colors ${
                        currentCategory === '' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                    }`;
                    allChip.onclick = () => filterByCategory('');
                    categoryChips.appendChild(allChip);
                    
                    // Category chips
                    categories.forEach(category => {
                        const chip = document.createElement('button');
                        chip.textContent = category;
                        chip.className = `px-4 py-2 rounded-full text-sm font-medium transition-colors ${
                            currentCategory === category ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                        }`;
                        chip.onclick = () => filterByCategory(category);
                        categoryChips.appendChild(chip);
                    });
                }
                
                // Filter products
                function filterProducts() {
                    let visibleCount = 0;
                    
                    productCards.forEach(card => {
                        const cardCategory = card.dataset.category;
                        const cardName = card.dataset.name;
                        const cardDescription = card.dataset.description;
                        
                        const matchesCategory = currentCategory === '' || cardCategory === currentCategory;
                        const matchesSearch = currentSearch === '' || 
                            cardName.includes(currentSearch.toLowerCase()) || 
                            cardDescription.includes(currentSearch.toLowerCase());
                        
                        if (matchesCategory && matchesSearch) {
                            card.style.display = 'block';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });
                    
                    // Update product count
                    let countText = `Showing ${visibleCount} products`;
                    if (currentCategory) {
                        countText += ` in ${currentCategory}`;
                    }
                    if (currentSearch) {
                        countText += ` matching "${currentSearch}"`;
                    }
                    productCount.textContent = countText;
                    
                    // Show/hide no results message
                    if (visibleCount === 0) {
                        noResults.classList.remove('hidden');
                        productsGrid.classList.add('hidden');
                    } else {
                        noResults.classList.add('hidden');
                        productsGrid.classList.remove('hidden');
                    }
                }
                
                // Filter by category
                function filterByCategory(category) {
                    currentCategory = category;
                    categoryFilter.value = category;
                    createCategoryChips();
                    filterProducts();
                }
                
                // Clear filters
                window.clearFilters = function() {
                    currentCategory = '';
                    currentSearch = '';
                    searchInput.value = '';
                    categoryFilter.value = '';
                    createCategoryChips();
                    filterProducts();
                };
                
                // Search input handler
                searchInput.addEventListener('input', function() {
                    currentSearch = this.value;
                    filterProducts();
                });
                
                // Category filter handler
                categoryFilter.addEventListener('change', function() {
                    filterByCategory(this.value);
                });
                
                // Initialize
                createCategoryChips();
                filterProducts();
            });
        </script>

        <!-- CTA Section -->
        <section class="bg-gray-50 py-16 rounded-lg mt-16">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Need a Custom Solution?</h2>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                    Can't find exactly what you're looking for? Our technical team can help you find 
                    the right product or develop a custom solution for your specific requirements.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button class="bg-red-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                        Request Quote
                    </button>
                    <button class="border-2 border-red-600 text-red-600 px-8 py-3 rounded-lg font-semibold hover:bg-red-600 hover:text-white transition-colors">
                        Technical Support
                    </button>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>