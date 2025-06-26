<x-guest-layout>
    <div class="max-w-md mx-auto mt-12 p-6 bg-white border shadow rounded">
        <h2 class="text-xl font-semibold mb-4">Registration Pending</h2>
        <p>Your account is under review. Please wait for admin approval.</p>

        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline text-sm">
                Return to login
            </a>
        </div>
    </div>
</x-guest-layout>
