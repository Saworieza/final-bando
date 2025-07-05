@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Blog Categories</h1>
        <a href="{{ route('admin.blog.categories.create') }}" 
           class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Create New Category
        </a>
    </div>

    @if (session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posts Count</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($categories as $category)
                    <tr>
                        <td class="py-4 px-6 text-sm font-medium text-gray-900">{{ $category->name }}</td>
                        <td class="py-4 px-6 text-sm text-gray-500">{{ $category->slug }}</td>
                        <td class="py-4 px-6 text-sm text-gray-500">{{ $category->posts_count }}</td>
                        <td class="py-4 px-6 text-sm font-medium space-x-2">
                            <a href="{{ route('admin.blog.categories.show', $category) }}" 
                               class="text-blue-600 hover:text-blue-900">View</a>
                            <a href="{{ route('admin.blog.categories.edit', $category) }}" 
                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('admin.blog.categories.destroy', $category) }}" 
                                  method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 px-6 text-sm text-gray-500 text-center">
                            No categories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection