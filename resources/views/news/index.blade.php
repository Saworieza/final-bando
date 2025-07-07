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

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">News Articles</h1>
        <x-breadcrumb :links="[
            'News' => route('news.index'),
            $currentCategory?->name ?? 'All Articles' => null
        ]" />
        @auth
            <a href="{{ route('news.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-plus mr-2"></i> Create News
            </a>
        @endauth
    </div>

    @if($news->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($news as $item)
                <div class="bg-white rounded-lg shadow-sm hover-shadow overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-1 rounded-full">
                                {{ $item->category->name }}
                            </span>
                            <small class="text-gray-500">{{ $item->created_at->format('M d, Y') }}</small>
                        </div>
                        
                        <h5 class="text-xl font-semibold mb-3">
                            <a href="{{ route('news.show', $item->slug) }}" class="text-gray-900 hover:text-blue-600 transition duration-200">
                                {{ $item->title }}
                            </a>
                        </h5>
                        
                        <p class="text-gray-600 mb-4">
                            {{ Str::limit($item->content, 150) }}
                        </p>
                        
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <i class="fas fa-user text-gray-400 mr-2"></i>
                                <small class="text-gray-500">{{ $item->user->name }}</small>
                            </div>
                            
                            <a href="{{ route('news.show', $item->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center transition duration-200">
                                Read More <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="flex justify-center mt-8">
            {{ $news->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="mb-4">
                <i class="fas fa-newspaper text-6xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-semibold text-gray-700 mb-2">No News Articles</h3>
            <p class="text-gray-500 mb-6">There are no news articles to display at the moment.</p>
            @auth
                <a href="{{ route('news.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center transition duration-200">
                    <i class="fas fa-plus mr-2"></i> Create First Article
                </a>
            @endauth
        </div>
    @endif
</div>
@endsection