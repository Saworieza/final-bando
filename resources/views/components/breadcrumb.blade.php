@props([
    'links' => [],
    'model' => null,  // The model instance (for show pages)
    'currentItem' => null  // For show page item name
])

<nav class="text-sm text-gray-500 mb-4">
    <ol class="list-reset flex space-x-2 items-center">
        <li><a href="{{ url('/') }}" class="hover:text-blue-600">Home</a></li>

        @isset($model)
            @php
                $modelName = class_basename($model);
                $routeBase = strtolower($modelName);
                // Handle special cases where plural isn't just adding 's'
                $pluralNames = [
                    'news' => 'news', // News is already plural
                    'product' => 'products'
                ];
                $indexRoute = ($pluralNames[$routeBase] ?? $routeBase.'s') . '.index';
            @endphp

            <li>/</li>
            <li>
                <a href="{{ route($indexRoute) }}" class="hover:text-blue-600">
                    {{ ucfirst($modelName) }}
                </a>
            </li>

            @if($model->category ?? false)
                <li>/</li>
                <li>
                    <a href="{{ route($indexRoute, ['category' => $model->category->slug]) }}" 
                       class="hover:text-blue-600">
                        {{ $model->category->name }}
                    </a>
                </li>
            @endif

            @if($currentItem)
                <li>/</li>
                <li>
                    <span class="text-gray-700 font-semibold">
                        {{ $currentItem }}
                    </span>
                </li>
            @endif

        @else
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
        @endisset
    </ol>
</nav>