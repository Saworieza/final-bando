<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Blog Categories</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto space-y-4">
        <a href="{{ route('blog.categories.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Add Category
        </a>

        @if (session('status'))
            <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('status') }}</div>
        @endif

        <table class="w-full border text-sm mt-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Slug</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $category->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-500">{{ $category->slug }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('blog.categories.edit', $category) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('blog.categories.destroy', $category) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete this category?')" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
