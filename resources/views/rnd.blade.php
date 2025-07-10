@extends('layouts.app')

@section('title', 'Research & Development')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16 rounded-lg mb-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Research & Development</h1>
            <p class="text-xl max-w-3xl mx-auto">
                Pioneering innovation in power transmission technology for tomorrow's challenges
            </p>
        </div>
    </section>

    <!-- R&D Overview -->
    <section class="mb-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Innovation at Our Core</h2>
                <p class="text-gray-700 mb-4">
                    Our Research & Development division is the driving force behind Bando's 
                    technological advancement. We invest heavily in cutting-edge research to 
                    develop next-generation power transmission solutions that meet the evolving 
                    needs of modern industry.
                </p>
                <p class="text-gray-700 mb-4">
                    With state-of-the-art laboratories and a team of experienced engineers, 
                    we focus on material science, product design, and manufacturing processes 
                    to deliver superior performance and reliability.
                </p>
            </div>
            <div>
                <img 
                    src="https://media.licdn.com/dms/image/v2/D4D12AQFn1CojumKSsg/article-cover_image-shrink_720_1280/B4DZbETKQZG0AM-/0/1747050080221?e=2147483647&v=beta&t=v2X8RvfJPEUomVrqqSDZSuXPFpNodBuDWxQdOAZ-fcg" 
                    alt="R&D Laboratory" 
                    class="w-full rounded-lg shadow-lg"
                />
            </div>
        </div>
    </section>

    <!-- Research Areas -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Research Focus Areas</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Material Science</h3>
                <p class="text-gray-600">Advanced rubber compounds and fiber reinforcement technologies</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Product Innovation</h3>
                <p class="text-gray-600">Next-generation belt designs and smart transmission systems</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Manufacturing</h3>
                <p class="text-gray-600">Automated production processes and quality control systems</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Performance Testing</h3>
                <p class="text-gray-600">Rigorous testing protocols and performance validation</p>
            </div>
        </div>
    </section>

    <!-- Recent Innovations -->
    <section class="bg-gray-50 py-16 rounded-lg mb-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Recent Innovations</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">High-Performance V-Belts</h3>
                    <p class="text-gray-600 mb-4">
                        New generation V-belts with enhanced durability and 30% longer service life.
                    </p>
                    <span class="text-red-600 font-semibold">2024</span>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Smart Conveyor Systems</h3>
                    <p class="text-gray-600 mb-4">
                        IoT-enabled conveyor belts with real-time monitoring and predictive maintenance.
                    </p>
                    <span class="text-red-600 font-semibold">2023</span>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Eco-Friendly Materials</h3>
                    <p class="text-gray-600 mb-4">
                        Sustainable rubber compounds reducing environmental impact by 40%.
                    </p>
                    <span class="text-red-600 font-semibold">2023</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Technology Partners -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Technology Partners</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center">
            <div class="text-center">
                <div class="bg-gray-100 h-20 rounded-lg flex items-center justify-center mb-4">
                    <span class="text-gray-500 font-semibold">University of Nairobi</span>
                </div>
            </div>
            <div class="text-center">
                <div class="bg-gray-100 h-20 rounded-lg flex items-center justify-center mb-4">
                    <span class="text-gray-500 font-semibold">KICD</span>
                </div>
            </div>
            <div class="text-center">
                <div class="bg-gray-100 h-20 rounded-lg flex items-center justify-center mb-4">
                    <span class="text-gray-500 font-semibold">JKUAT</span>
                </div>
            </div>
            <div class="text-center">
                <div class="bg-gray-100 h-20 rounded-lg flex items-center justify-center mb-4">
                    <span class="text-gray-500 font-semibold">KAM</span>
                </div>
            </div>
        </div>
    </section>
@endsection