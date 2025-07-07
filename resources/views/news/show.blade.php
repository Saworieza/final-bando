@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <article class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-8">
            <header class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $news->title }}</h1>
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center space-x-4">
                        <span class=" text-blue-800 font-semibold px-3 py-1 rounded-full">
                            <x-breadcrumb 
                                :model="$news"
                                :currentItem="$news->slug"
                            />
                        </span><br>
                        <span class="text-gray-600">Posted by {{ $news->user->name }}</span>
                    </div>
                    <div class="text-gray-500">{{ $news->created_at->format('F j, Y') }}</div>
                </div>
            </header>

            @if($news->images->count() > 0)
            <div class="mb-8">
                @if($news->images->count() === 1)
                    <img src="{{ Storage::url($news->images->first()->file_path) }}" 
                         class="w-full h-96 object-cover rounded-lg" 
                         alt="News image">
                @else
                    <div class="relative">
                        <div class="overflow-hidden rounded-lg">
                            <div class="flex transition-transform duration-300 ease-in-out" id="imageSlider">
                                @foreach($news->images as $key => $image)
                                <div class="w-full flex-shrink-0">
                                    <img src="{{ Storage::url($image->file_path) }}" 
                                         class="w-full h-96 object-cover" 
                                         alt="News image {{ $key + 1 }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Navigation buttons -->
                        <button class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full p-2 shadow-lg transition duration-200" 
                                onclick="previousImage()">
                            <i class="fas fa-chevron-left text-gray-600"></i>
                        </button>
                        <button class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full p-2 shadow-lg transition duration-200" 
                                onclick="nextImage()">
                            <i class="fas fa-chevron-right text-gray-600"></i>
                        </button>
                        
                        <!-- Dots indicator -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                            @foreach($news->images as $key => $image)
                            <button class="w-3 h-3 rounded-full bg-white bg-opacity-60 hover:bg-opacity-100 transition duration-200 image-dot" 
                                    onclick="goToImage({{ $key }})"></button>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            @endif

            <div class="prose prose-lg max-w-none mb-8">
                {!! nl2br(e($news->content)) !!}
            </div>

            @if($news->files->count() > 0)
            <div class="border border-gray-200 rounded-lg mb-8">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h5 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-paperclip mr-2"></i>Attachments
                    </h5>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($news->files as $file)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                            <div class="flex items-center">
                                <i class="fas fa-file text-gray-400 mr-3"></i>
                                <span class="text-gray-900 truncate">{{ $file->original_name }}</span>
                            </div>
                            <a href="{{ Storage::url($file->file_path) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm flex items-center transition duration-200" 
                               download>
                                <i class="fas fa-download mr-1"></i>
                                Download
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <footer class="flex justify-between items-center pt-6 border-t border-gray-200">
                <div class="flex space-x-3">
                    @can('update', $news)
                    <a href="{{ route('news.edit', $news->slug) }}" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg flex items-center transition duration-200">
                        <i class="fas fa-edit mr-2"></i> Edit Article
                    </a>
                    @endcan
                    
                    @can('delete', $news)
                    <form method="POST" action="{{ route('news.destroy', $news->slug) }}" 
                          class="inline" 
                          onsubmit="return confirm('Are you sure you want to delete this article?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg flex items-center transition duration-200">
                            <i class="fas fa-trash mr-2"></i> Delete
                        </button>
                    </form>
                    @endcan
                </div>
                <a href="{{ route('news.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Back to News
                </a>
            </footer>
        </div>
    </article>
</div>

@if($news->images->count() > 1)
<script>
let currentImageIndex = 0;
const totalImages = {{ $news->images->count() }};

function updateImageSlider() {
    const slider = document.getElementById('imageSlider');
    const dots = document.querySelectorAll('.image-dot');
    
    slider.style.transform = `translateX(-${currentImageIndex * 100}%)`;
    
    dots.forEach((dot, index) => {
        if (index === currentImageIndex) {
            dot.classList.add('bg-opacity-100');
            dot.classList.remove('bg-opacity-60');
        } else {
            dot.classList.add('bg-opacity-60');
            dot.classList.remove('bg-opacity-100');
        }
    });
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % totalImages;
    updateImageSlider();
}

function previousImage() {
    currentImageIndex = (currentImageIndex - 1 + totalImages) % totalImages;
    updateImageSlider();
}

function goToImage(index) {
    currentImageIndex = index;
    updateImageSlider();
}

// Initialize
updateImageSlider();

// Auto-advance slides every 5 seconds
setInterval(nextImage, 5000);
</script>
@endif
@endsection