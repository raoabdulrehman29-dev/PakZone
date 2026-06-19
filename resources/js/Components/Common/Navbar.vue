<template>
    <header class="sticky top-0 z-50 bg-gray-900 shadow-lg">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Top Row -->
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <Link href="/" class="flex items-center gap-2 group">
                        <div class="p-1.5 bg-teal-600 rounded-lg group-hover:bg-teal-500 transition-colors">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white hidden sm:block">
                            Pak<span class="text-teal-400">Zone</span>
                        </span>
                    </Link>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-2xl mx-4 relative">
                    <form @submit.prevent="performSearch" class="relative flex items-center w-full">
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search for products..."
                            class="w-full px-4 py-2 bg-gray-800 text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 rounded-l-lg"
                            @input="handleSearchInput"
                            @focus="showSuggestions = true"
                            @blur="setTimeout(() => showSuggestions = false, 200)"
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

                <!-- Auth & Cart -->
                <div class="flex items-center gap-2">
                    <div class="hidden md:flex items-center gap-2">
                        <Link v-if="!user" href="/login" class="px-4 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                            Sign In
                        </Link>
                        <Link v-if="!user" href="/register" class="px-4 py-1.5 text-sm font-medium text-white bg-gradient-to-r from-teal-600 to-teal-500 hover:from-teal-700 hover:to-teal-600 rounded-lg transition-all duration-200 shadow-lg shadow-teal-500/30 hover:shadow-teal-500/40">
                            Sign Up
                        </Link>
                        <div v-if="user" class="flex items-center gap-2">
                            <span class="text-sm text-gray-300">{{ user.name }}</span>
                            <Link href="/logout" method="post" as="button" class="text-sm text-red-400 hover:text-red-300">
                                Logout
                            </Link>
                        </div>
                    </div>

                    <Link href="/cart" class="relative p-2 hover:bg-gray-800 rounded-lg transition-colors group">
                        <svg class="w-6 h-6 text-gray-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span v-if="cartCount > 0" class="absolute -top-1 -right-1 px-1.5 py-0.5 text-xs font-bold text-white bg-orange-500 rounded-full min-w-[20px] text-center">
                            {{ cartCount }}
                        </span>
                    </Link>

                    <button @click="toggleMobileMenu" class="md:hidden p-2 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                        <svg v-if="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden pb-3" v-show="isMobileMenuOpen">
                <form @submit.prevent="performSearch" class="relative flex items-center w-full">
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search for products..."
                        class="w-full px-4 py-2 bg-gray-800 text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 rounded-l-lg"
                    />
                    <button type="submit" class="px-5 py-2 bg-gradient-to-r from-teal-600 to-teal-500 hover:from-teal-700 hover:to-teal-600 rounded-r-lg text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
                <div v-if="!user" class="flex items-center gap-2 mt-3">
                    <Link href="/login" class="flex-1 text-center px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                        Sign In
                    </Link>
                    <Link href="/register" class="flex-1 text-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-teal-600 to-teal-500 hover:from-teal-700 hover:to-teal-600 rounded-lg transition-all duration-200">
                        Sign Up
                    </Link>
                </div>
                <div v-else class="flex items-center justify-between gap-2 mt-3">
                    <span class="text-sm text-gray-300">{{ user.name }}</span>
                    <Link href="/logout" method="post" as="button" class="text-sm text-red-400 hover:text-red-300">
                        Logout
                    </Link>
                </div>
            </div>

            <!-- Bottom Navigation -->
            <div class="hidden md:block border-t border-gray-800 mt-1">
                <nav class="flex items-center gap-1 py-1.5 overflow-x-auto scrollbar-hide">

                    <!-- Categories Button -->
                    <button
                        @click="toggleCategoryDropdown"
                        class="flex items-center gap-1 px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span>Categories</span>
                        <svg class="w-4 h-4 transition-transform duration-200"
                             :class="{ 'rotate-180': showCategoryDropdown }"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>

                    <!-- Navigation Links -->
                    <Link v-for="link in navLinks" :key="link.name" :href="link.href"
                       class="px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors whitespace-nowrap">
                        {{ link.name }}
                    </Link>

                    <!-- Deals Badge -->
                    <Link href="/deals" class="px-3 py-1.5 text-sm font-medium text-orange-400 hover:text-orange-300 hover:bg-gray-800 rounded-lg transition-colors whitespace-nowrap flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Deals
                    </Link>
                </nav>
            </div>
        </div>
    </header>

    <!-- ============================================ -->
    <!-- BEAUTIFUL DROPDOWN WITH TELEPORT -->
    <!-- ============================================ -->
    <Teleport to="body">
        <div v-if="showCategoryDropdown"
             @click.self="showCategoryDropdown = false"
             class="fixed inset-0 z-[99999] bg-black/20 backdrop-blur-sm transition-opacity duration-300"
             style="top: 60px;"
        >
            <div class="container mx-auto px-4">
                <div class="relative max-w-6xl mx-auto mt-2 bg-gray-800 rounded-2xl shadow-2xl border border-gray-700 p-6 animate-slideDown max-h-[70vh] overflow-y-auto custom-scrollbar">

                    <!-- Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-gray-700 mb-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            All Categories
                            <span class="text-xs text-gray-500 font-normal ml-2">({{ categories.length }})</span>
                        </h3>
                        <button @click="showCategoryDropdown = false"
                                class="text-gray-400 hover:text-white transition-colors p-1 rounded-lg hover:bg-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Categories Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                        <div v-for="category in categories" :key="category.id"
                             class="group bg-gray-900/50 rounded-xl p-4 hover:bg-gray-700/50 transition-all duration-300 hover:shadow-lg hover:shadow-teal-500/10 hover:scale-[1.02]">

                            <!-- Main Category -->
                            <Link
                                :href="`/category/${category.slug}`"
                                @click="showCategoryDropdown = false"
                                class="flex items-center gap-2 mb-2"
                            >
                                <span v-if="category.icon" class="text-xl">{{ category.icon }}</span>
                                <span class="text-sm font-semibold text-teal-400 group-hover:text-teal-300 transition-colors">
                                    {{ category.name }}
                                </span>
                                <span class="text-xs text-gray-500 ml-auto">({{ category.products_count || 0 }})</span>
                            </Link>

                            <!-- Sub Categories -->
                            <div v-if="category.children && category.children.length > 0" class="space-y-1">
                                <a v-for="sub in category.children" :key="sub.id"
                                   :href="`/category/${sub.slug}`"
                                   @click="showCategoryDropdown = false"
                                   class="block text-xs text-gray-400 hover:text-white transition-all duration-200 hover:translate-x-1 hover:shadow-sm rounded-lg px-2 py-1 hover:bg-gray-700/50">
                                    {{ sub.name }}
                                    <span class="text-gray-600 text-[10px]">({{ sub.products_count || 0 }})</span>
                                </a>
                            </div>
                            <div v-else class="text-xs text-gray-600 italic">
                                No sub-categories
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-4 pt-4 border-t border-gray-700 flex items-center justify-between text-xs text-gray-500">
                        <span>{{ categories.length }} categories available</span>
                        <button @click="showCategoryDropdown = false"
                                class="text-teal-400 hover:text-teal-300 transition-colors">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

// ============================================
// PROPS
// ============================================
const props = defineProps({
    user: { type: Object, default: null },
    cartCount: { type: Number, default: 0 },
    categories: { type: Array, default: () => [] }
});

// ============================================
// STATE
// ============================================
const searchQuery = ref('');
const searchSuggestions = ref([]);
const showSuggestions = ref(false);
const isMobileMenuOpen = ref(false);
const showCategoryDropdown = ref(false);

// ============================================
// NAVIGATION LINKS
// ============================================
const navLinks = [
    { name: "Today's Deals", href: '/deals' },
    { name: 'Customer Service', href: '/help' },
    { name: 'Gift Cards', href: '/gift-cards' },
    { name: 'Sell', href: '/sell' },
    { name: 'Track Order', href: '/track' },
];

// ============================================
// METHODS
// ============================================
const formatPrice = (amount) => {
    return new Intl.NumberFormat('en-PK').format(amount || 0);
};

const toggleCategoryDropdown = () => {
    showCategoryDropdown.value = !showCategoryDropdown.value;
};

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

let searchTimeout = null;

const handleSearchInput = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(async () => {
        if (searchQuery.value.length < 2) {
            searchSuggestions.value = [];
            showSuggestions.value = false;
            return;
        }

        try {
            const response = await fetch(`/api/search-suggestions?q=${encodeURIComponent(searchQuery.value)}`);
            const data = await response.json();
            searchSuggestions.value = data;
            showSuggestions.value = true;
        } catch (error) {
            console.error('Search error:', error);
        }
    }, 300);
};

const selectSuggestion = (suggestion) => {
    window.location.href = `/products/${suggestion.slug}`;
};

const performSearch = () => {
    if (searchQuery.value.trim()) {
        window.location.href = `/search?q=${encodeURIComponent(searchQuery.value)}`;
        isMobileMenuOpen.value = false;
    }
};

watch(showCategoryDropdown, (newVal) => {
    if (newVal) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
});

onMounted(() => {
    console.log('✅ Navbar mounted with', props.categories.length, 'categories');
});
</script>

<style scoped>
/* ============================================ */
/* ANIMATIONS */
/* ============================================ */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.animate-slideDown {
    animation: slideDown 0.25s ease-out;
}

/* ============================================ */
/* SCROLLBAR STYLING */
/* ============================================ */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #1f2937;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #14b8a6;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #0d9488;
}

/* ============================================ */
/* NAVBAR SCROLLBAR */
/* ============================================ */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* ============================================ */
/* TRANSITIONS */
/* ============================================ */
.transition-colors {
    transition-property: color, background-color, border-color;
    transition-duration: 200ms;
}

.transition-all {
    transition-property: all;
    transition-duration: 300ms;
}
</style>
