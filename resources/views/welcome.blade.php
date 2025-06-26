<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bando Kenya</title>
    @vite('resources/css/app.css') <!-- Required if you're using Breeze/Vite -->
</head>
<body class="bg-white text-gray-800">

    <!-- Simple Navbar -->
    <nav class="flex items-center justify-between px-6 py-4 shadow-md">
        <h1 class="text-xl font-bold">Bando Kenya</h1>
        <div>
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline mx-3">Login</a>
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Sign Up</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="text-center mt-20">
        <h2 class="text-3xl font-semibold mb-4">Welcome to Bando Kenya</h2>
        <p class="text-lg text-gray-600">A trusted B2B marketplace for African wholesalers and resellers.</p>
    </div>

</body>
</html>
