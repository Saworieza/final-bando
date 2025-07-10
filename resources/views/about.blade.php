@extends('layouts.app')

@section('title', 'About Bando Kenya')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-red-600 to-red-700 text-white py-16 rounded-lg mb-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">About Bando Kenya</h1>
            <p class="text-xl max-w-3xl mx-auto">
                Leading the way in power transmission and conveyor belt solutions across East Africa
            </p>
        </div>
    </section>

    <!-- Company Overview -->
    <section class="mb-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Heritage</h2>
                <p class="text-gray-700 mb-4">
                    Bando Kenya, a subsidiary of Bando (Singapore) Pte Ltd, has been at the forefront of 
                    power transmission solutions in East Africa for over two decades. We specialize in 
                    manufacturing and distributing high-quality industrial belts, automotive parts, and 
                    precision machinery components.
                </p>
                <p class="text-gray-700 mb-4">
                    Our commitment to innovation, quality, and customer satisfaction has made us the 
                    preferred partner for businesses across various industries, from automotive and 
                    manufacturing to agriculture and mining.
                </p>
                <p class="text-gray-700">
                    With our headquarters in Nairobi and distribution network spanning East Africa, 
                    we ensure reliable supply and technical support to our valued customers.
                </p>
            </div>
            <div class="bg-gray-100 rounded-lg p-8">
                <img 
                    src="https://media.licdn.com/dms/image/v2/D4E10AQHSHrElf8Qo3A/image-shrink_800/image-shrink_800/0/1700064400296?e=2147483647&v=beta&t=tA9pwsUC1fIrp9stg_Yi_QUvQk1Gf0K1dcGUTlQO_LY" 
                    alt="Bando Kenya Facility" 
                    class="w-full rounded-lg shadow-lg"
                />
            </div>
        </div>
    </section>

    <!-- Key Statistics -->
    <section class="bg-gray-50 py-16 rounded-lg mb-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Our Impact</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div class="p-6">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">25+</h3>
                    <p class="text-gray-600">Years of Excellence</p>
                </div>
                <div class="p-6">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">500+</h3>
                    <p class="text-gray-600">Satisfied Customers</p>
                </div>
                <div class="p-6">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">15+</h3>
                    <p class="text-gray-600">Industry Awards</p>
                </div>
                <div class="p-6">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-3m0-6v-3m0 3h3m-3 0h-3"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">5</h3>
                    <p class="text-gray-600">Countries Served</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="mb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h3>
                <p class="text-gray-700">
                    To provide innovative, high-quality power transmission solutions that drive 
                    industrial growth across East Africa, while maintaining the highest standards 
                    of customer service and technical excellence.
                </p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h3>
                <p class="text-gray-700">
                    To be the leading provider of industrial power transmission solutions in East Africa, 
                    recognized for our innovation, reliability, and contribution to regional 
                    industrial development.
                </p>
            </div>
        </div>
    </section>

    <!-- Quality Certifications -->
    <section class="bg-white py-16 rounded-lg shadow-lg">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Quality Certifications</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6">
                    <div class="bg-gray-100 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                        <span class="text-red-600 font-bold">ISO</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">ISO 9001:2015</h3>
                    <p class="text-gray-600">Quality Management System</p>
                </div>
                <div class="p-6">
                    <div class="bg-gray-100 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                        <span class="text-red-600 font-bold">ISO</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">ISO 14001:2015</h3>
                    <p class="text-gray-600">Environmental Management</p>
                </div>
                <div class="p-6">
                    <div class="bg-gray-100 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                        <span class="text-red-600 font-bold">CE</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">CE Certification</h3>
                    <p class="text-gray-600">European Conformity</p>
                </div>
            </div>
        </div>
    </section>
@endsection