<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Category</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto">
        <form method="POST" action="{{ route('blog.categories.update', $category) }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="w-full border p-2">
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
        </form>
    </div>
</x-app-layout>
