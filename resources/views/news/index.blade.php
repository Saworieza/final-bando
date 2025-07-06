@extends('layouts.app')

@section('content')
<div id="news-index" class="container mx-auto px-4 py-8">
    @if($news->count() > 0)
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($news as $item)
                <div class="news-card bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden"
                     @click="openNews('{{ route('news.show', $item->slug) }}')">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-semibold">
                                {{ $item->category->name }}
                            </span>
                            <span class="text-gray-500 text-sm">{{ $item->created_at->format('M d, Y') }}</span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                            {{ $item->title }}
                        </h3>
                        
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ Str::limit($item->content, 150) }}
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $item->user->name }}
                            </div>
                            
                            <a 
                                href="{{ route('news.show', $item->slug) }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                                @click.stop
                            >
                                Read More
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8 flex justify-center">
            {{ $news->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📰</div>
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">No News Articles</h3>
            <p class="text-gray-600 max-w-md mx-auto">There are no news articles to display at the moment.</p>
        </div>
    @endif
</div>

<script>
// Initialize Vue app for this page
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('news-index')) {
        new Vue({
            el: '#news-index',
            methods: {
                openNews(url) {
                    window.location.href = url;
                }
            }
        });
    }
});
</script>

<style>
.news-card {
    cursor: pointer;
}

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
</style>
@endsection