<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto space-y-6">

        @if ($post->featured_image)
            <img src="{{ asset('storage/' . $post->featured_image) }}" class="w-full rounded">
        @endif

        <p class="text-sm text-gray-500">
            Category: {{ $post->category->name ?? 'Uncategorized' }}
        </p>

        <div class="prose max-w-none">
            {!! $post->content !!}
        </div>

        @if ($post->attachment && \Illuminate\Support\Str::endsWith($post->attachment, '.pdf'))
            <h4 class="text-md font-semibold mt-6">PDF Preview</h4>
            <iframe src="{{ asset('storage/' . $post->attachment) }}#page=1" type="application/pdf"
                width="100%" height="500px" class="border rounded"></iframe>
        @endif

    </div>
</x-app-layout>
