<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bando Kenya</title>
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>
    <body class="bg-white text-gray-800">
        @include('layouts.navigation')

        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-gray-100 to-gray-200 py-16 md:py-24 rounded-lg shadow-lg mt-8">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Powering Africa's Growth with Trusted B2B E-Commerce
                </h1>
                <p class="text-lg md:text-xl text-gray-700 mb-8 max-w-3xl mx-auto">
                    Welcome to Bando Africa — your premier online marketplace for high-quality industrial belts, automotive parts, and essential supplies. Built to serve wholesalers, resellers, and manufacturers across Africa, we connect businesses with the tools they need to thrive. Whether you're restocking inventory or sourcing reliable components, Bando Africa delivers efficiency, affordability, and unmatched convenience — all at your fingertips.
                </p>
                <p class="text-lg md:text-xl text-gray-700 mb-8 font-semibold">
                    Join the future of African trade. Buy. Sell. Grow.
                </p>
                <a href="/products" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 text-lg rounded-md inline-block">
                    Browse Products
                </a>
            </div>
        </section>

        <!-- Featured Categories Section -->
        <section class="py-16">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Featured Categories</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto px-4">
                <a href="/products?category=industrial" class="group block bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <img src="https://www.c-rproducts.com/wp-content/uploads/2017/09/drive-belts-crp.png" alt="Industrial Belts" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300" />
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 group-hover:text-red-600 transition-colors duration-300">Industrial Belts</h3>
                    </div>
                </a>
                <a href="/products?category=automotive" class="group block bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <img src="https://www.marketresearchintellect.com/images/blogs/top-automotive-parts-manufacturers.webp" alt="Automotive Parts" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300" />
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 group-hover:text-red-600 transition-colors duration-300">Automotive Parts</h3>
                    </div>
                </a>
                <a href="/products?category=conveyor-belts" class="group block bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <img src="https://i0.wp.com/chassol.co.tz/wp-content/uploads/2021/07/SAFET.jpg?fit=1000%2C786&ssl=1" alt="Safety Equipment" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300" />
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 group-hover:text-red-600 transition-colors duration-300">Conveyor Belts</h3>
                    </div>
                </a>
            </div>
        </section>

        <!-- Why Choose Us Section -->
        <section class="bg-white py-16 rounded-lg shadow-lg">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Why Choose Bando Kenya?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="p-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto text-red-600 mb-4">
                            <path d="m7.5 4.27 9 5.15"></path>
                            <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                            <path d="m3.3 7 8.7 5 8.7-5"></path>
                            <path d="M12 22V12"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Wide Product Range</h3>
                        <p class="text-gray-600">Extensive catalog catering to diverse B2B needs across various industries.</p>
                    </div>
                    <div class="p-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto text-red-600 mb-4">
                            <path d="M5 18H3c-.6 0-1-.4-1-1V7c0-.6.4-1 1-1h10c.6 0 1 .4 1 1v11"></path>
                            <path d="M14 9h4l4 4v4c0 .6-.4 1-1 1h-2"></path>
                            <circle cx="7" cy="18" r="2"></circle>
                            <path d="M15 18H9"></path>
                            <circle cx="17" cy="18" r="2"></circle>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Reliable Logistics</h3>
                        <p class="text-gray-600">Efficient delivery network ensuring your orders reach you on time.</p>
                    </div>
                    <div class="p-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto text-red-600 mb-4">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Quality Assured</h3>
                        <p class="text-gray-600">Genuine products from trusted manufacturers, meeting high quality standards.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Us Section -->
        <section class="py-16 bg-gray-50 rounded-lg shadow-lg mt-12">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Contact Us</h2>
                <div class="max-w-2xl mx-auto text-gray-700">
                    <p class="text-lg mb-2 font-semibold">Bando (Singapore) Pte, Ltd. Nairobi Branch</p>
                    <p class="mb-1">
                        International House Limited Business Centre, 1st Floor, Office Number 17
                    </p>
                    <p class="mb-4">
                        International House, Mama Ngina St, Nairobi, Kenya
                    </p>
                    <div class="flex items-center justify-center text-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3 text-red-600">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <span>Office Mobile: (254) 700 919173</span>
                    </div>
                    <p class="mt-6 text-md">
                        Have questions or need assistance? Feel free to reach out to us!
                    </p>
                </div>
            </div>
        </section>
    </body>
</html>