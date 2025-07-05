@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">
                @if(isset($category))
                    {{ $category->name }} Posts
                @else
                    Our Blog
                @endif
            </h1>
            
            @if(isset($category))
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <a href="{{ route('blog.index') }}" class="hover:text-blue-600">All Posts</a>
                    <span>></span>
                    <span>{{ $category->name }}</span>
                </div>
            @endif
        </div>

        @if($posts->count() > 0)
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($posts as $post)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                    {{ $post->category->name ?? 'Uncategorized' }}
                                </span>
                                @if($post->file)
                                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                                    </svg>
                                @endif
                            </div>
                            
                            <h2 class="text-xl font-bold text-gray-800 mb-3 hover:text-blue-600 transition-colors">
                                <a href="{{ route('blog.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            
                            <div class="text-gray-600 mb-4">
                                {!! Str::limit(strip_tags($post->body), 150) !!}
                            </div>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <div class="flex items-center space-x-2">
                                    <span>By {{ $post->author->name ?? 'Unknown' }}</span>
                                </div>
                                <span>{{ $post->created_at->format('M j, Y') }}</span>
                            </div>
                            
                            <div class="mt-4">
                                <a href="{{ route('blog.show', $post->slug) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Read More →
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-xl font-medium text-gray-700 mb-2">No posts found</h3>
                <p class="text-gray-500">
                    @if(isset($category))
                        No posts in this category yet.
                    @else
                        No blog posts have been published yet.
                    @endif
                </p>
                @if(isset($category))
                    <a href="{{ route('blog.index') }}" 
                       class="inline-block mt-4 text-blue-600 hover:text-blue-800">
                        View all posts
                    </a>
                @endif
            </div>
        @endif

        <!-- Categories sidebar could go here -->
        @if(!isset($category))
            <div class="mt-12 bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Categories</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach(\App\Models\BlogCategory::withCount('posts')->get() as $cat)
                        <a href="{{ route('blog.category', $cat->slug) }}" 
                           class="inline-block bg-white text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-blue-100 hover:text-blue-800 transition-colors">
                            {{ $cat->name }} ({{ $cat->posts_count }})
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection