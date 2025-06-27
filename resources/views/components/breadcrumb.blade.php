@props(['links' => []])

<nav class="text-sm text-gray-500 mb-4">
    <ol class="list-reset flex space-x-2 items-center">
        <li><a href="{{ route('products.index') }}" class="hover:text-blue-600">Home</a></li>

        @foreach ($links as $label => $url)
            <li>/</li>
            <li>
                @if ($url)
                    <a href="{{ $url }}" class="hover:text-blue-600">{{ $label }}</a>
                @else
                    <span class="text-gray-700 font-semibold">{{ $label }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
