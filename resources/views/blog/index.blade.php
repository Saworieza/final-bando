<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Knowledge Center</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">
        @forelse ($posts as $post)
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-bold mb-2">
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-700 hover:underline">
                        {{ $post->title }}
                    </a>
                </h3>
                
                @if ($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" class="mb-3 w-full max-w-md rounded">
                @endif

                <p class="text-gray-700">{{ Str::limit(strip_tags($post->content), 150) }}</p>

                <p class="text-sm text-gray-500 mt-2">
                    Category: {{ $post->category->name ?? 'Uncategorized' }}
                </p>
            </div>
        @empty
            <p class="text-gray-600">No posts yet.</p>
        @endforelse
    </div>
</x-app-layout>
