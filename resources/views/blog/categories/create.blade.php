<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">New Category</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto">
        <form method="POST" action="{{ route('blog.categories.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block font-medium">Name</label>
                <input type="text" name="name" class="w-full border p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Slug (optional)</label>
                <input type="text" name="slug" class="w-full border p-2">
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save</button>
        </form>
    </div>
</x-app-layout>
