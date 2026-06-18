<template>
    <header class="sticky top-0 z-50 bg-gray-900 shadow-lg">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Top Row: Logo, Search, Auth, Cart -->
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <Link href="/" class="flex items-center gap-2 group">
                        <div class="p-1.5 bg-teal-600 rounded-lg group-hover:bg-teal-500 transition-colors">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13v4m6-4v4" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white hidden sm:block">
                            Pak<span class="text-teal-400">Zone</span>
                        </span>
                    </Link>
                </div>

                <!-- Search Bar (Desktop) -->
                <div class="hidden md:flex flex-1 max-w-2xl mx-4">
                    <form @submit.prevent="performSearch" class="relative flex items-center w-full">
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search for products..."
                            class="w-full px-4 py-2 bg-gray-800 text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 rounded-l-lg"
                        />
                        <button
                            type="submit"
                            class="px-5 py-2 bg-gradient-to-r from-teal-600 to-teal-500 hover:from-teal-700 hover:to-teal-600 rounded-r-lg text-white transition-colors"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Right Section -->
                <div class="flex items-center gap-2">
                    <!-- Auth Buttons (Desktop) -->
                    <div class="hidden md:flex items-center gap-2">
                        <Link href="/login" class="px-4 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                            Sign In
                        </Link>
                        <Link href="/register" class="px-4 py-1.5 text-sm font-medium text-white bg-gradient-to-r from-teal-600 to-teal-500 hover:from-teal-700 hover:to-teal-600 rounded-lg transition-all duration-200 shadow-lg shadow-teal-500/30 hover:shadow-teal-500/40">
                            Sign Up
                        </Link>
                    </div>

                    <!-- Cart -->
                    <Link href="/cart" class="relative p-2 hover:bg-gray-800 rounded-lg transition-colors group">
                        <svg class="w-6 h-6 text-gray-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span v-if="cartCount > 0" class="absolute -top-1 -right-1 px-1.5 py-0.5 text-xs font-bold text-white bg-orange-500 rounded-full min-w-[20px] text-center">
                            {{ cartCount }}
                        </span>
                    </Link>

                    <!-- Mobile Menu Button -->
                    <button
                        @click="toggleMobileMenu"
                        class="md:hidden p-2 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors"
                    >
                        <svg v-if="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Search & Auth -->
            <div class="md:hidden pb-3" v-show="isMobileMenuOpen">
                <form @submit.prevent="performSearch" class="relative flex items-center w-full">
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search for products..."
                        class="w-full px-4 py-2 bg-gray-800 text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 rounded-l-lg"
                    />
                    <button
                        type="submit"
                        class="px-5 py-2 bg-gradient-to-r from-teal-600 to-teal-500 hover:from-teal-700 hover:to-teal-600 rounded-r-lg text-white transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
                <div class="flex items-center gap-2 mt-3">
                    <Link href="/login" class="flex-1 text-center px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                        Sign In
                    </Link>
                    <Link href="/register" class="flex-1 text-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-teal-600 to-teal-500 hover:from-teal-700 hover:to-teal-600 rounded-lg transition-all duration-200">
                        Sign Up
                    </Link>
                </div>
            </div>

            <!-- Bottom Navigation: Categories, Deals, etc. -->
            <div class="hidden md:block border-t border-gray-800 mt-1">
                <nav class="flex items-center gap-1 py-1.5 overflow-x-auto scrollbar-hide">
                    <!-- Categories Dropdown -->
                    <div class="relative"
                         @mouseenter="showCategoryDropdown = true"
                         @mouseleave="showCategoryDropdown = false">
                        <button
                            @click="toggleCategoryDropdown"
                            class="flex items-center gap-1 px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <span>Categories</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        <!-- Categories Mega Dropdown -->
                        <div v-if="showCategoryDropdown"
                             class="absolute left-0 mt-1 w-screen max-w-4xl bg-gray-800 rounded-lg shadow-2xl border border-gray-700 z-50 p-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-h-96 overflow-y-auto">
                            <div v-for="category in categories" :key="category.id" class="space-y-2">
                                <h4 class="text-sm font-semibold text-teal-400 hover:text-teal-300 cursor-pointer">
                                    {{ category.name }}
                                </h4>
                                <ul class="space-y-1">
                                    <li v-for="sub in category.children" :key="sub.id">
                                        <Link :href="`/category/${sub.slug}`"
                                           class="text-xs text-gray-400 hover:text-white hover:underline transition-colors">
                                            {{ sub.name }}
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <Link v-for="link in navLinks" :key="link.name"
                       :href="link.href"
                       class="px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors whitespace-nowrap">
                        {{ link.name }}
                    </Link>

                    <!-- Deals Badge -->
                    <Link href="/deals"
                       class="px-3 py-1.5 text-sm font-medium text-orange-400 hover:text-orange-300 hover:bg-gray-800 rounded-lg transition-colors whitespace-nowrap flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Deals
                    </Link>

                    <!-- Sell -->
                    <Link href="/sell"
                       class="px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors whitespace-nowrap">
                        Sell
                    </Link>

                    <!-- Help -->
                    <Link href="/help"
                       class="px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors whitespace-nowrap hidden lg:block">
                        Help
                    </Link>

                    <!-- Track Order -->
                    <Link href="/track"
                       class="px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors whitespace-nowrap hidden xl:block">
                        Track Order
                    </Link>
                </nav>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        default: null
    },
    cartCount: {
        type: Number,
        default: 0
    },
    categories: {
        type: Array,
        default: () => []
    }
});

const searchQuery = ref('');
const isMobileMenuOpen = ref(false);
const showCategoryDropdown = ref(false);

const navLinks = [
    { name: 'Today\'s Deals', href: '/deals' },
    { name: 'Customer Service', href: '/help' },
    { name: 'Gift Cards', href: '/gift-cards' },
    { name: 'Sell', href: '/sell' },
    { name: 'Track Order', href: '/track' },
    { name: 'Electronics', href: '/category/electronics' },
    { name: 'Fashion', href: '/category/fashion' },
    { name: 'Books', href: '/category/books' },
];

const performSearch = () => {
    if (searchQuery.value.trim()) {
        window.location.href = `/search?q=${encodeURIComponent(searchQuery.value)}`;
        isMobileMenuOpen.value = false;
    }
};

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const toggleCategoryDropdown = () => {
    showCategoryDropdown.value = !showCategoryDropdown.value;
};
</script>

<style scoped>
/* Smooth transitions */
.transition-colors {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}

/* Mobile menu animation */
.md\:hidden {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Category dropdown animation */
.absolute {
    transition: opacity 0.15s ease;
}

/* Hide scrollbar for nav */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* Container max-width for large screens */
.container {
    max-width: 1280px;
}

/* Hover effects */
.group:hover .group-hover\:text-white {
    color: white;
}

/* Custom scrollbar for category dropdown */
.max-h-96::-webkit-scrollbar {
    width: 4px;
}

.max-h-96::-webkit-scrollbar-track {
    background: #1f2937;
    border-radius: 4px;
}

.max-h-96::-webkit-scrollbar-thumb {
    background: #14b8a6;
    border-radius: 4px;
}

.max-h-96::-webkit-scrollbar-thumb:hover {
    background: #0d9488;
}
</style>
