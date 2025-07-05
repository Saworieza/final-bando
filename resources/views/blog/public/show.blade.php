@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-8">
            <a href="{{ route('blog.index') }}" class="hover:text-blue-600">Blog</a>
            <span>></span>
            @if($post->category)
                <a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-blue-600">
                    {{ $post->category->name }}
                </a>
                <span>></span>
            @endif
            <span class="text-gray-800">{{ $post->title }}</span>
        </nav>

        <!-- Post Header -->
        <header class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    @if($post->category)
                        <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                            {{ $post->category->name }}
                        </span>
                    @endif
                    @if($post->file)
                        <div class="flex items-center space-x-1 text-red-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                            </svg>
                            <span class="text-sm">PDF Available</span>
                        </div>
                    @endif
                </div>
                <div class="text-sm text-gray-500">
                    {{ $post->created_at->format('F j, Y') }}
                </div>
            </div>
            
            <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $post->title }}</h1>
            
            <div class="flex items-center space-x-4 text-sm text-gray-600">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    <span>By {{ $post->author->name ?? 'Unknown Author' }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </header>

        <!-- PDF Download -->
        @if($post->file)
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-red-800">PDF Document Available</h3>
                            <p class="text-sm text-red-600">Download the complete document</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ asset('storage/' . $post->file) }}" 
                           target="_blank"
                           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-medium">
                            View PDF
                        </a>
                        <a href="{{ asset('storage/' . $post->file) }}" 
                           download
                           class="bg-white border border-red-600 text-red-600 hover:bg-red-50 px-4 py-2 rounded text-sm font-medium">
                            Download
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Post Content -->
        <article class="bg-white rounded-lg shadow-sm p-8 mb-8">
            <div class="prose prose-lg max-w-none">
                {!! nl2br(e($post->body)) !!}
            </div>
        </article>

        <!-- Post Footer -->
        <footer class="bg-gray-50 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Share this post:</span>
                    <div class="flex space-x-2">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" 
                           target="_blank"
                           class="text-blue-400 hover:text-blue-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank"
                           class="text-blue-600 hover:text-blue-800">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M20 10C20 4.477 15.523 0 10 0S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <a href="{{ route('blog.index') }}" 
                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    ← Back to Blog
                </a>
            </div>
        </footer>

        <!-- Related Posts -->
        @if($post->category)
            @php
                $relatedPosts = \App\Models\BlogPost::where('blog_category_id', $post->category->id)
                    ->where('id', '!=', $post->id)
                    ->latest()
                    ->take(3)
                    ->get();
            @endphp
            
            @if($relatedPosts->count() > 0)
                <div class="mt-12">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Related Posts</h3>
                    <div class="grid gap-6 md:grid-cols-3">
                        @foreach($relatedPosts as $relatedPost)
                            <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                                <div class="p-4">
                                    <h4 class="font-semibold text-gray-800 mb-2 hover:text-blue-600 transition-colors">
                                        <a href="{{ route('blog.show', $relatedPost->slug) }}">
                                            {{ $relatedPost->title }}
                                        </a>
                                    </h4>
                                    <p class="text-sm text-gray-600 mb-3">
                                        {!! Str::limit(strip_tags($relatedPost->body), 100) !!}
                                    </p>
                                    <div class="text-xs text-gray-500">
                                        {{ $relatedPost->created_at->format('M j, Y') }}
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection