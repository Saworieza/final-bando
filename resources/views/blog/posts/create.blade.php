<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">New Blog Post</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('blog.posts.store') }}" enctype="multipart/form-data">
            @include('blog.posts._form')
        </form>
    </div>
</x-app-layout>
