@extends('layouts.app')

@section('title', 'Contact Us - Bando Kenya')

@push('styles')
<style>
    .hero-gradient {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }
    
    .card-gradient-red {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    }
    
    .card-gradient-gray {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    }
    
    .btn-gradient-red {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }
    
    .btn-gradient-gray {
        background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
    }
    
    .text-bando-red {
        color: #dc2626;
    }
    
    .bg-bando-red {
        background-color: #dc2626;
    }
    
    .form-input {
        transition: all 0.3s ease;
        border: 1px solid #d1d5db;
    }
    
    .form-input:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Hero Section -->
    <div class="relative overflow-hidden hero-gradient rounded-xl mb-12 p-12 text-center">
        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">
                Let's Start a Conversation
            </h1>
            <p class="text-lg text-red-100 max-w-2xl mx-auto leading-relaxed">
                Connect with our pharmaceutical experts. We're here to support your healthcare needs with innovative solutions and personalized service.
            </p>
        </div>
    </div>

    <!-- Quick Contact Cards -->
    <div class="grid lg:grid-cols-3 gap-6 mb-12">
        <div class="border border-gray-200 rounded-lg bg-white shadow-sm p-6 text-center">
            <div class="w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="text-red-600 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Call Us Direct</h3>
            <p class="text-gray-600 mb-3 text-sm">Speak with our team immediately</p>
            <p class="text-red-600 font-medium">+254 (0) 20 123 4567</p>
        </div>

        <div class="border border-gray-200 rounded-lg bg-white shadow-sm p-6 text-center">
            <div class="w-12 h-12 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="text-gray-600 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Email Support</h3>
            <p class="text-gray-600 mb-3 text-sm">Get detailed responses</p>
            <p class="text-gray-700 font-medium">info@bandokenya.com</p>
        </div>

        <div class="border border-gray-200 rounded-lg bg-white shadow-sm p-6 text-center">
            <div class="w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="text-red-600 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Visit Our Office</h3>
            <p class="text-gray-600 mb-3 text-sm">Meet us in person</p>
            <p class="text-red-600 font-medium">Nairobi, Kenya</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid lg:grid-cols-5 gap-8">
        <!-- Contact Form -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-lg shadow-md border border-gray-200">
                <div class="bg-red-600 p-6 text-white rounded-t-lg">
                    <h2 class="text-2xl font-bold mb-1">Send us a Message</h2>
                    <p class="text-red-100 text-sm">We typically respond within 2 hours during business hours</p>
                </div>
                <div class="p-6">
                    <form id="contact-form" class="space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                                <input type="text" name="first_name" required 
                                       class="w-full px-3 py-2 rounded-md form-input focus:outline-none"
                                       placeholder="Your first name">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                                <input type="text" name="last_name" required 
                                       class="w-full px-3 py-2 rounded-md form-input focus:outline-none"
                                       placeholder="Your last name">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                            <input type="email" name="email" required 
                                   class="w-full px-3 py-2 rounded-md form-input focus:outline-none"
                                   placeholder="your.email@example.com">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                            <input type="tel" name="phone" required
                                   class="w-full px-3 py-2 rounded-md form-input focus:outline-none"
                                   placeholder="+254 712 345 678">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Company (Optional)</label>
                            <input type="text" name="company" 
                                   class="w-full px-3 py-2 rounded-md form-input focus:outline-none"
                                   placeholder="Your company name">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subject *</label>
                            <select name="subject" required 
                                    class="w-full px-3 py-2 rounded-md form-input focus:outline-none">
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="products">Product Information</option>
                                <option value="partnership">Partnership Opportunity</option>
                                <option value="support">Technical Support</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                            <textarea name="message" rows="4" required 
                                      class="w-full px-3 py-2 rounded-md form-input focus:outline-none resize-none"
                                      placeholder="Please provide details about your inquiry..."></textarea>
                        </div>
                        
                        <button type="submit" 
                                class="w-full btn-gradient-red text-white py-3 px-4 rounded-md font-medium hover:opacity-90 transition-opacity">
                            Send Message
                        </button>
                    </form>
                    
                    <!-- Success Message (Hidden by default) -->
                    <div id="success-message" class="hidden mt-4 p-3 bg-green-100 border border-green-300 rounded-md text-sm">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-green-800">Thank you for your message! We'll get back to you soon.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information Sidebar -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Contact Details -->
            <div class="border border-gray-200 rounded-lg bg-white shadow-sm">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        Contact Details
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-red-100 rounded-md flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="text-red-600 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 mb-1">Head Office</h4>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    123 Pharmaceutical Drive<br>
                                    Nairobi, Kenya<br>
                                    P.O. Box 12345-00100
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-red-100 rounded-md flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="text-red-600 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 mb-1">Phone Numbers</h4>
                                <p class="text-gray-600 text-sm">+254 (0) 20 123 4567</p>
                                <p class="text-gray-600 text-sm">+254 (0) 712 345 678</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-red-100 rounded-md flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="text-red-600 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 mb-1">Business Hours</h4>
                                <p class="text-gray-600 text-sm">Mon-Fri: 8:00 AM - 6:00 PM</p>
                                <p class="text-gray-600 text-sm">Saturday: 9:00 AM - 2:00 PM</p>
                                <p class="text-gray-600 text-sm">Sunday: Closed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Why Choose Us -->
            <div class="border border-gray-200 rounded-lg bg-white shadow-sm">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        Why Contact Us?
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="text-red-600 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 text-sm">Expert pharmaceutical consultation</span>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="text-red-600 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 text-sm">Quality assured products</span>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="text-red-600 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 text-sm">Industry-leading solutions</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('contact-form');
        const submitBtn = form.querySelector('button[type="submit"]');
        const successMessage = document.getElementById('success-message');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (!isValid) return;
            
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Sending...
            `;
            submitBtn.disabled = true;
            
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                successMessage.classList.remove('hidden');
                form.reset();
                
                setTimeout(() => {
                    successMessage.classList.add('hidden');
                }, 5000);
            }, 2000);
        });
        
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('border-red-500')) {
                    this.classList.remove('border-red-500');
                }
            });
        });
    });
</script>
@endpush