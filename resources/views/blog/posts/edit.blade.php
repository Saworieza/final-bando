<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Post</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('blog.posts.update', $post) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('blog.posts._form')
        </form>
    </div>
</x-app-layout>
