@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Blog Posts</h1>
        <div class="space-x-4">
            <a href="{{ route('admin.blog.categories.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Manage Categories
            </a>
            <a href="{{ route('admin.blog.posts.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Create New Post
            </a>
        </div>
    </div>

    @if (session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($posts as $post)
                    <tr>
                        <td class="py-4 px-6 text-sm font-medium text-gray-900">
                            <div class="flex items-center">
                                {{ $post->title }}
                                @if($post->file)
                                    <svg class="w-4 h-4 ml-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                                    </svg>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-500">
                            {{ $post->category->name ?? 'Uncategorized' }}
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-500">
                            {{ $post->author->name ?? 'Unknown' }}
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-500">
                            {{ $post->created_at->format('M j, Y') }}
                        </td>
                        <td class="py-4 px-6 text-sm font-medium space-x-2">
                            <a href="{{ route('blog.show', $post->slug) }}" 
                               class="text-green-600 hover:text-green-900" 
                               target="_blank">View</a>
                            <a href="{{ route('admin.blog.posts.edit', $post) }}" 
                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('admin.blog.posts.destroy', $post) }}" 
                                  method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Are you sure you want to delete this post?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-6 text-sm text-gray-500 text-center">
                            No posts found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection