@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
            <button type="button" class="text-green-600 hover:text-green-800" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
            <button type="button" class="text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Header Section -->
    <section class="text-center mb-12">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-4xl font-bold text-gray-900">Blog Posts & Updates</h1>
            <x-breadcrumb :links="[
                'News' => route('news.index'),
                $currentCategory?->name ?? 'All Articles' => null
            ]" />
            @auth
                <a href="{{ route('news.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg flex items-center transition duration-200">
                    <i class="fas fa-plus mr-2"></i> Add Blog Post
                </a>
            @endauth
        </div>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
            Stay informed about the latest developments, product launches, and company updates from Bando Kenya.
        </p>
    </section>

    @if($news->count() > 0)
        <!-- Featured Post Section -->
        @php
            $featuredPost = $news->where('featured', true)->first();
            $regularPosts = $news->where('featured', false);
        @endphp

        @if($featuredPost)
            <section class="mb-16">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <div class="lg:order-2">
                            @if($featuredPost->image_url)
                                <img src="{{ $featuredPost->image_url }}" alt="{{ $featuredPost->title }}" class="w-full h-64 lg:h-full object-cover">
                            @else
                                <div class="w-full h-64 lg:h-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-4xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-8 lg:order-1 flex flex-col justify-center">
                            <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium mb-4 inline-block w-fit">
                                Featured
                            </span>
                            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                                {{ $featuredPost->title }}
                            </h2>
                            <p class="text-gray-600 mb-6">
                                {{ $featuredPost->excerpt ?? Str::limit($featuredPost->content, 200) }}
                            </p>
                            <div class="flex items-center text-gray-500 text-sm mb-6">
                                <i class="fas fa-user mr-2"></i>
                                <span class="mr-4">{{ $featuredPost->user->name }}</span>
                                <i class="fas fa-calendar mr-2"></i>
                                <span>{{ $featuredPost->created_at->format('F j, Y') }}</span>
                            </div>
                            <a href="{{ route('news.show', $featuredPost->slug) }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg inline-flex items-center transition duration-200 w-fit">
                                Read Full Post
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Posts Grid Section -->
        <section>
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Recent Posts</h2>
            @if($regularPosts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($regularPosts as $item)
                        <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-3xl text-gray-400"></i>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <span class="text-red-600 text-sm font-medium">
                                    {{ $item->category->name }}
                                </span>
                                <h3 class="text-xl font-bold text-gray-900 mt-2 mb-3 line-clamp-2">
                                    <a href="{{ route('news.show', $item->slug) }}" class="hover:text-red-600 transition duration-200">
                                        {{ $item->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $item->excerpt ?? Str::limit($item->content, 150) }}
                                </p>
                                <div class="flex items-center justify-between text-gray-500 text-sm mb-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-user mr-1"></i>
                                        <span>{{ $item->user->name }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar mr-1"></i>
                                        <span>{{ $item->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('news.show', $item->slug) }}" class="w-full border border-gray-300 hover:border-red-600 text-gray-700 hover:text-red-600 px-4 py-2 rounded-lg inline-flex items-center justify-center transition duration-200">
                                    Read More
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">No regular blog posts available yet.</p>
                </div>
            @endif
        </section>

        <!-- Pagination -->
        <div class="flex justify-center mt-8">
            {{ $news->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="mb-4">
                <i class="fas fa-newspaper text-6xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-semibold text-gray-700 mb-2">No News Articles</h3>
            <p class="text-gray-500 mb-6">There are no news articles to display at the moment.</p>
            @auth
                <a href="{{ route('news.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg inline-flex items-center transition duration-200">
                    <i class="fas fa-plus mr-2"></i> Create First Article
                </a>
            @endauth
        </div>
    @endif

    <!-- Newsletter Signup Section -->
   
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .hover-shadow {
        transition: box-shadow 0.3s ease;
    }
    
    .hover-shadow:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
</style>
@endpush
@endsection