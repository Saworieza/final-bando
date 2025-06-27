<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Blog Posts</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto space-y-4">
        <a href="{{ route('blog.posts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ New Post</a>

        @if (session('status'))
            <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('status') }}</div>
        @endif

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Category</th>
                    <th class="px-4 py-2">Created</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $post->title }}</td>
                        <td class="px-4 py-2">{{ $post->category->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $post->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('blog.posts.edit', $post) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('blog.posts.destroy', $post) }}" method="POST" class="inline">
                                @csrf @method
