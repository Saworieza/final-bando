@extends('layouts.app')

@section('title', 'Sales Network')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-green-600 to-green-800 text-white py-16 rounded-lg mb-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Sales Network</h1>
            <p class="text-xl max-w-3xl mx-auto">
                Comprehensive coverage across East Africa with local expertise and support
            </p>
        </div>
    </section>

    <!-- Network Overview -->
    <section class="mb-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Presence</h2>
            <p class="text-gray-700 max-w-3xl mx-auto">
                Bando Kenya maintains a strategic network of offices and distributors across 
                East Africa, ensuring prompt service delivery and technical support to our customers.
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div class="p-6">
                <div class="bg-red-600 text-white rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                    <span class="text-2xl font-bold">4</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Office Locations</h3>
                <p class="text-gray-600">Strategic presence in key cities</p>
            </div>
            <div class="p-6">
                <div class="bg-red-600 text-white rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                    <span class="text-2xl font-bold">15+</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Authorized Dealers</h3>
                <p class="text-gray-600">Certified distribution partners</p>
            </div>
            <div class="p-6">
                <div class="bg-red-600 text-white rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                    <span class="text-2xl font-bold">24/7</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Technical Support</h3>
                <p class="text-gray-600">Round-the-clock assistance</p>
            </div>
            <div class="p-6">
                <div class="bg-red-600 text-white rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                    <span class="text-2xl font-bold">48h</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Delivery Time</h3>
                <p class="text-gray-600">Fast nationwide delivery</p>
            </div>
        </div>
    </section>

    <!-- Office Locations -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Office Locations</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Nairobi Office -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-2xl font-bold text-gray-900">Nairobi</h3>
                    <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm">
                        Headquarters
                    </span>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-gray-700">International House, Mama Ngina St</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-gray-700">(254) 700 919173</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-700">nairobi@bandokenya.com</span>
                    </div>
                </div>
            </div>

            <!-- Mombasa Office -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-2xl font-bold text-gray-900">Mombasa</h3>
                    <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm">
                        Regional Office
                    </span>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-gray-700">Industrial Area, Changamwe Road</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-gray-700">(254) 700 919174</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-700">mombasa@bandokenya.com</span>
                    </div>
                </div>
            </div>

            <!-- Kisumu Office -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-2xl font-bold text-gray-900">Kisumu</h3>
                    <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm">
                        Regional Office
                    </span>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-gray-700">Oginga Odinga Street, CBD</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-gray-700">(254) 700 919175</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-700">kisumu@bandokenya.com</span>
                    </div>
                </div>
            </div>

            <!-- Nakuru Office -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-2xl font-bold text-gray-900">Nakuru</h3>
                    <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm">
                        Branch Office
                    </span>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-gray-700">Kenyatta Avenue, Town Center</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-gray-700">(254) 700 919176</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-700">nakuru@bandokenya.com</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Regional Coverage -->
    <section class="bg-gray-50 py-16 rounded-lg mb-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Regional Coverage</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Kenya</h3>
                    <p class="text-gray-600">
                        Complete coverage with offices in major cities and authorized dealers nationwide.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Uganda</h3>
                    <p class="text-gray-600">
                        Strategic partnerships with local distributors in Kampala and major industrial centers.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Tanzania</h3>
                    <p class="text-gray-600">
                        Established network serving Dar es Salaam and key industrial regions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="bg-red-600 text-white py-16 rounded-lg">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Find Your Local Representative</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Get in touch with our local sales team for personalized service and technical support.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="bg-white text-red-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Contact Sales Team
                </button>
                <button class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-red-600 transition-colors">
                    Request Quote
                </button>
            </div>
        </div>
    </section>
@endsection