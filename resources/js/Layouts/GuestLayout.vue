<template>
    <div class="min-h-screen flex flex-col bg-gradient-to-br from-slate-50 via-white to-teal-50/30">
        <!-- Navbar - Full width at top -->
        <Navbar
            :user="$page.props.auth.user"
            :cart-count="$page.props.cart_count || 0"
            :categories="$page.props.categories || []"
        />

        <!-- Login/Register Content - Centered -->
        <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-8">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <a href="/" class="inline-block">
                        <div class="inline-flex items-center justify-center p-3 bg-gradient-to-br from-teal-600 to-teal-500 rounded-2xl shadow-lg shadow-teal-500/30 hover:shadow-teal-500/40 transition-all duration-200">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13v4m6-4v4" />
                            </svg>
                        </div>
                    </a>
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mt-4">
                        Pak<span class="text-teal-600">Zone</span>
                    </h1>
                    <p class="text-sm text-gray-500 font-medium mt-1">{{ pageSubtitle }}</p>
                </div>

                <!-- Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-2xl shadow-gray-200/50 border border-gray-100/50 overflow-hidden transition-all hover:shadow-xl">
                    <div class="px-6 sm:px-8 py-8">
                        <slot />
                    </div>
                </div>

                <!-- Footer Links -->
                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-400">
                        By continuing, you agree to our
                        <a href="#" class="text-teal-600 hover:text-teal-700 font-medium hover:underline">Terms</a> &amp;
                        <a href="#" class="text-teal-600 hover:text-teal-700 font-medium hover:underline">Privacy Policy</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Navbar from '@/Components/Common/Navbar.vue';

defineProps({
    pageTitle: {
        type: String,
        default: 'Welcome Back'
    },
    pageSubtitle: {
        type: String,
        default: 'Sign in to continue shopping'
    }
});
</script>
