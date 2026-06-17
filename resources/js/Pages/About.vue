<template>
    <CustomerLayout>
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">About PakZone</h1>
            <p class="text-sm text-gray-500 mt-1">Pakistan's Premier E-Commerce Platform</p>
        </div>

        <!-- Main Content -->
        <div class="space-y-12">
            <!-- Hero Section -->
            <div class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-teal-600 to-teal-800 p-8 sm:p-12">
                <div class="relative z-10 text-white max-w-2xl">
                    <h2 class="text-2xl sm:text-3xl font-bold">Our Mission</h2>
                    <p class="mt-3 text-teal-100 leading-relaxed">
                        To create a trusted and seamless shopping experience for every Pakistani,
                        connecting buyers with quality products at the best prices.
                    </p>
                    <div class="mt-6 flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Trusted by 10,000+ customers</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>1M+ products delivered</span>
                        </div>
                    </div>
                </div>
                <!-- Decorative elements -->
                <div class="absolute right-0 top-0 opacity-10">
                    <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                    </svg>
                </div>
            </div>

            <!-- Our Story -->
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Our Story</h3>
                <div class="prose max-w-none text-gray-600 space-y-4">
                    <p>
                        PakZone was founded with a simple vision: to make online shopping accessible,
                        reliable, and enjoyable for everyone in Pakistan. What started as a small idea
                        has grown into a platform connecting thousands of customers with quality products
                        across multiple categories.
                    </p>
                    <p>
                        We believe in the power of choice, the importance of trust, and the convenience
                        of modern technology. Every day, we work to bring you the best products, the
                        best prices, and the best shopping experience.
                    </p>
                </div>
            </div>

            <!-- Our Values -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-sm p-6 text-center hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900">Trust & Transparency</h4>
                    <p class="text-sm text-gray-500 mt-2">We believe in honest dealings and clear communication with our customers.</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 text-center hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900">Quality First</h4>
                    <p class="text-sm text-gray-500 mt-2">We curate only the best products from trusted sellers and brands.</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 text-center hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900">Customer First</h4>
                    <p class="text-sm text-gray-500 mt-2">Your satisfaction is our priority. We're here to help every step of the way.</p>
                </div>
            </div>

            <!-- Founder Section -->
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Meet the Founder</h3>
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <div class="w-32 h-32 bg-gradient-to-br from-teal-500 to-teal-700 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-4xl font-bold text-white">AR</span>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">Abdul Rehman</h4>
                        <p class="text-sm text-teal-600">Founder & CEO, PakZone</p>
                        <p class="text-sm text-gray-500 mt-2">
                            Passionate about technology and e-commerce, Abdul Rehman founded PakZone
                            to revolutionize online shopping in Pakistan. With a background in software
                            development and a vision for digital commerce, he leads the team with
                            innovation and integrity.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
                    <p class="text-2xl font-bold text-teal-600">10K+</p>
                    <p class="text-xs text-gray-500 mt-1">Happy Customers</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
                    <p class="text-2xl font-bold text-teal-600">1M+</p>
                    <p class="text-xs text-gray-500 mt-1">Products Delivered</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
                    <p class="text-2xl font-bold text-teal-600">100+</p>
                    <p class="text-xs text-gray-500 mt-1">Trusted Brands</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
                    <p class="text-2xl font-bold text-teal-600">4.9★</p>
                    <p class="text-xs text-gray-500 mt-1">Average Rating</p>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>

<script setup>
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
</script>
