<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Top Bar (from second navigation) -->
    <div class="top-bar bg-gray-800 text-white py-2">
        <div class="container mx-auto px-4 flex justify-between items-center">            
            <div class="top-info hidden md:flex items-center space-x-6 text-sm">
                <a href="tel:254700919173" class="flex items-center hover:text-gray-300" style="color: #fff;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    (254) 700 919173
                </a>
                <a href="mailto:info@bando.co.ke" class="flex items-center hover:text-gray-300" style="color: #fff;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    info@bando.co.ke
                </a>
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    International House, Mama Ngina St, Nairobi
                </span>
            </div>

            <!-- Language and Dashboard -->
            <div class="top-connect flex items-center space-x-4">
                <div class="language-select hidden sm:block">
                    <select id="select" class="bg-transparent border-none text-white text-sm focus:ring-0 focus:border-transparent">
                        <option value="en">English</option>
                        <option value="sw">Swahili</option>
                    </select>
                </div>
                @auth
                <a href="{{ route('dashboard') }}" class="text-sm hover:text-gray-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                    Dashboard
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('storage/images/bando.png') }}" class="block h-9 w-auto" alt="Bando Kenya">
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden md:flex space-x-8 sm:ms-10 sm:flex">
                    <!-- Home -->
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    
                    <!-- About -->
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        {{ __('About') }}
                    </x-nav-link>

                    <!-- Products Dropdown - Now visible to all users -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border-none border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>Products</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <a href="{{ route('products.index') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium border-b border-gray-100">
                                    All Products
                                </a>
                                @foreach(App\Models\Category::all() as $category)
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- RND -->
                    <x-nav-link :href="route('rnd')" :active="request()->routeIs('rnd')">
                        {{ __('RND') }}
                    </x-nav-link>

                    <!-- Network -->
                    <x-nav-link :href="route('network')" :active="request()->routeIs('network')">
                        {{ __('Sales Network') }}
                    </x-nav-link>

                    <!-- News Dropdown - Now visible to all users -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border-none border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>News</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <a href="{{ route('news.index') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium border-b border-gray-100">
                                    All Posts
                                </a>
                                @foreach(App\Models\Category::all() as $category)
                                    <a href="{{ route('news.index', ['category' => $category->slug]) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Contact -->
                    <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                        {{ __('Contact') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Side Navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <!-- Search -->
                <!-- <form action="{{ route('search') }}" method="GET" class="relative">
                    <input type="text" name="query" placeholder="Search…" class="rounded-md border border-gray-300 px-3 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 w-40 md:w-64">
                </form> -->

                <!-- Auth Links -->
                @auth
                    <!-- User Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Login/Register Links -->
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-blue-600 focus:outline-none transition ease-in-out duration-150">
                            {{ __('Login') }}
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition ease-in-out duration-150">
                            {{ __('Register') }}
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Mobile Navigation Links -->
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                {{ __('About') }}
            </x-responsive-nav-link>

            <!-- Products - Now visible to all users -->
            <div class="px-4 py-2">
                <div class="font-medium text-gray-500">Products</div>
                <div class="mt-1 space-y-1">
                    <a href="{{ route('products.index') }}" class="block pl-4 pr-2 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium">
                        All Products
                    </a>
                    @foreach(App\Models\Category::all() as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="block pl-4 pr-2 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- News - Now visible to all users -->
            <div class="px-4 py-2">
                <div class="font-medium text-gray-500">News</div>
                <div class="mt-1 space-y-1">
                    <a href="{{ route('news.index') }}" class="block pl-4 pr-2 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium">
                        All News
                    </a>
                    @foreach(App\Models\Category::all() as $category)
                        <a href="{{ route('news.index', ['category' => $category->slug]) }}" class="block pl-4 pr-2 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                {{ __('Contact') }}
            </x-responsive-nav-link>

            <!-- Mobile Search -->
            <div class="px-4 py-2">
                <form action="{{ route('search') }}" method="GET" class="relative">
                    <input type="text" name="query" placeholder="Search…" class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 w-full">
                </form>
            </div>
        </div>

        <!-- Mobile Auth Links -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1 px-4">
                    <a href="{{ route('login') }}" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                        {{ __('Login') }}
                    </a>
                    <a href="{{ route('register') }}" class="block w-full px-4 py-2 text-left text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                        {{ __('Register') }}
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>