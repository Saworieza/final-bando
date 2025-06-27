@csrf

<div class="mb-4">
    <label for="title" class="block font-medium">Title</label>
    <input type="text" name="title" id="title" class="w-full border p-2" value="{{ old('title', $post->title ?? '') }}" required>
</div>

<div class="mb-4">
    <label for="slug" class="block font-medium">Slug</label>
    <input type="text" name="slug" id="slug" class="w-full border p-2" value="{{ old('slug', $post->slug ?? '') }}">
</div>

<div class="mb-4">
    <label for="blog_category_id" class="block font-medium">Category</label>
    <select name="blog_category_id" class="w-full border p-2" required>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" @selected(old('blog_category_id', $post->blog_category_id ?? '') == $cat->id)>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="block font-medium">Body</label>
    <input id="body" type="hidden" name="body" value="{{ old('body', $post->body ?? '') }}">
    <trix-editor input="body" class="trix-content bg-white border rounded p-2"></trix-editor>
</div>

<div class="mb-4">
    <label for="file" class="block font-medium">PDF Upload (optional)</label>
    <input type="file" name="file" id="file" class="w-full border p-2">
</div>

<button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save</button>
