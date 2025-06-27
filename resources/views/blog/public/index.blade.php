@if(isset($category))
    <h2 class="text-xl font-bold mb-4">
        Posts in “{{ $category->name }}”
    </h2>
@endif
