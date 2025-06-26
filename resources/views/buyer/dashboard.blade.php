<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Buyer Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <p>Welcome, {{ Auth::user()->name }}</p>
        </div>
    </div>
</x-app-layout>
