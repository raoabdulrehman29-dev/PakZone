<template>
    <CustomerLayout>
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Search Results</h1>
            <p class="text-sm text-gray-500 mt-1">
                {{ products.length }} result{{ products.length !== 1 ? 's' : '' }} found for "{{ searchQuery }}"
            </p>
        </div>

        <!-- Search Bar -->
        <div class="mb-6">
            <form @submit.prevent="performSearch" class="flex gap-2">
                <div class="flex-1 relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search for products..."
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        @input="performSearch"
                    />
                </div>
                <button type="submit" class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors shadow-md hover:shadow-lg">
                    Search
                </button>
            </form>
        </div>

        <!-- Filter & Sort Bar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <!-- Filter Toggle (Mobile) -->
            <button
                @click="showFilters = !showFilters"
                class="sm:hidden px-4 py-2 bg-gray-100 text-gray-700 rounded-lg flex items-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filters
            </button>

            <!-- Sort Options -->
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <span class="text-sm text-gray-500 whitespace-nowrap">Sort by:</span>
                <select
                    v-model="sortBy"
                    class="flex-1 sm:flex-none px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm text-gray-700"
                    @change="applyFilters"
                >
                    <option value="relevance">Relevance</option>
                    <option value="newest">Newest</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                    <option value="popular">Popular</option>
                    <option value="rating">Rating</option>
                </select>
            </div>
        </div>

        <!-- Main Content: Sidebar + Products -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Sidebar - Filters -->
            <div
                class="lg:w-72 xl:w-80 flex-shrink-0"
                :class="{
                    'hidden': !showFilters,
                    'block': showFilters
                }"
            >
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <!-- Categories Filter -->
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">
                            Categories
                        </h3>
                        <div class="space-y-2 max-h-48 overflow-y-auto">
                            <label v-for="category in categories" :key="category.id"
                                   class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                                <input
                                    type="checkbox"
                                    :value="category.id"
                                    v-model="selectedCategories"
                                    @change="applyFilters"
                                    class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                                >
                                {{ category.name }}
                                <span class="text-xs text-gray-400">({{ category.product_count || 0 }})</span>
                            </label>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6 border-t border-gray-200 pt-4">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">
                            Price Range
                        </h3>
                        <div class="flex items-center gap-2">
                            <input
                                type="number"
                                v-model="priceMin"
                                placeholder="Min"
                                @change="applyFilters"
                                class="w-1/2 px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                            >
                            <span class="text-gray-400">-</span>
                            <input
                                type="number"
                                v-model="priceMax"
                                placeholder="Max"
                                @change="applyFilters"
                                class="w-1/2 px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                            >
                        </div>
                    </div>

                    <!-- Rating Filter -->
                    <div class="mb-6 border-t border-gray-200 pt-4">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">
                            Customer Rating
                        </h3>
                        <div class="space-y-2">
                            <label v-for="star in [4,3,2,1]" :key="star"
                                   class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                                <input
                                    type="checkbox"
                                    :value="star"
                                    v-model="selectedRatings"
                                    @change="applyFilters"
                                    class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                                >
                                <span class="flex items-center gap-1">
                                    <span v-for="s in 5" :key="s" class="text-sm">
                                        <span v-if="s <= star" class="text-yellow-400">★</span>
                                        <span v-else class="text-gray-300">★</span>
                                    </span>
                                    <span class="text-xs text-gray-400 ml-1">&amp; up</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Availability -->
                    <div class="border-t border-gray-200 pt-4">
                        <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                            <input
                                type="checkbox"
                                v-model="inStockOnly"
                                @change="applyFilters"
                                class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                            >
                            In Stock Only
                        </label>
                    </div>

                    <!-- Clear Filters -->
                    <button
                        @click="clearFilters"
                        class="w-full mt-4 px-4 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-lg transition-colors"
                    >
                        Clear All Filters
                    </button>
                </div>
            </div>

            <!-- Right Content - Products Grid -->
            <div class="flex-1">
                <!-- Loading State -->
                <div v-if="loading" class="text-center py-12">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-teal-600 border-t-transparent"></div>
                    <p class="text-gray-500 mt-2">Searching products...</p>
                </div>

                <!-- Products Grid -->
                <div v-else-if="products.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                    <ProductCard
                        v-for="product in products"
                        :key="product.id"
                        :product="product"
                        @add-to-cart="addToCart"
                    />
                </div>

                <!-- No Results -->
                <div v-else class="text-center py-12 bg-white rounded-lg shadow-sm">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                    <p class="text-gray-500 mt-1">
                        We couldn't find any products matching "{{ searchQuery }}"
                    </p>
                    <div class="mt-4 space-x-2">
                        <button
                            @click="clearFilters"
                            class="px-4 py-2 text-sm text-teal-600 hover:text-teal-700 font-medium"
                        >
                            Clear all filters
                        </button>
                        <a href="/" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 font-medium">
                            Browse all products
                        </a>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="products.length > 0 && pagination.last_page > 1" class="mt-8 flex justify-center">
                    <nav class="flex items-center gap-1">
                        <button
                            @click="goToPage(pagination.current_page - 1)"
                            :disabled="pagination.current_page <= 1"
                            class="px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Previous
                        </button>
                        <button
                            v-for="page in pagination.last_page"
                            :key="page"
                            @click="goToPage(page)"
                            class="px-3 py-2 text-sm rounded-lg transition-colors"
                            :class="{
                                'bg-teal-600 text-white': pagination.current_page === page,
                                'text-gray-600 hover:bg-gray-100': pagination.current_page !== page
                            }"
                        >
                            {{ page }}
                        </button>
                        <button
                            @click="goToPage(pagination.current_page + 1)"
                            :disabled="pagination.current_page >= pagination.last_page"
                            class="px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Next
                        </button>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Search Tips -->
        <div v-if="products.length === 0 && !loading" class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h4 class="text-sm font-medium text-blue-800">Search Tips:</h4>
            <ul class="text-xs text-blue-700 mt-1 space-y-1">
                <li>• Check the spelling of your search terms</li>
                <li>• Try using more general keywords</li>
                <li>• Try browsing our categories instead</li>
                <li>• Use fewer words to get more results</li>
            </ul>
        </div>
    </CustomerLayout>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import ProductCard from '@/Components/Home/ProductCard.vue';

// ============================================
// PROPS
// ============================================
const props = defineProps({
    products: {
        type: Array,
        default: () => []
    },
    categories: {
        type: Array,
        default: () => []
    },
    pagination: {
        type: Object,
        default: () => ({ current_page: 1, last_page: 1 })
    },
    query: {
        type: String,
        default: ''
    },
    filters: {
        type: Object,
        default: () => ({})
    }
});

// ============================================
// STATE
// ============================================
const loading = ref(false);
const showFilters = ref(window.innerWidth >= 1024);

// Search
const searchQuery = ref(props.query);

// Filter state
const selectedCategories = ref([]);
const selectedRatings = ref([]);
const priceMin = ref('');
const priceMax = ref('');
const inStockOnly = ref(false);
const sortBy = ref('relevance');

// ============================================
// METHODS
// ============================================
const performSearch = () => {
    if (!searchQuery.value.trim()) {
        window.location.href = '/';
        return;
    }

    loading.value = true;

    const params = new URLSearchParams();
    params.append('q', searchQuery.value);

    if (selectedCategories.value.length) {
        params.append('categories', selectedCategories.value.join(','));
    }
    if (selectedRatings.value.length) {
        params.append('ratings', selectedRatings.value.join(','));
    }
    if (priceMin.value) {
        params.append('price_min', priceMin.value);
    }
    if (priceMax.value) {
        params.append('price_max', priceMax.value);
    }
    if (inStockOnly.value) {
        params.append('in_stock', '1');
    }
    if (sortBy.value !== 'relevance') {
        params.append('sort', sortBy.value);
    }

    window.location.href = `/search?${params.toString()}`;
};

const applyFilters = () => {
    performSearch();
};

const clearFilters = () => {
    selectedCategories.value = [];
    selectedRatings.value = [];
    priceMin.value = '';
    priceMax.value = '';
    inStockOnly.value = false;
    sortBy.value = 'relevance';
    performSearch();
};

const goToPage = (page) => {
    if (page < 1 || page > props.pagination.last_page) return;
    loading.value = true;

    const params = new URLSearchParams(window.location.search);
    params.set('page', page);

    window.location.href = `/search?${params.toString()}`;
};

const addToCart = (product) => {
    console.log('Add to cart:', product);
};

// ============================================
// WATCHERS
// ============================================
watch(sortBy, () => {
    performSearch();
});

// ============================================
// LIFECYCLE
// ============================================
onMounted(() => {
    // Set initial filter values from URL
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.get('q')) {
        searchQuery.value = urlParams.get('q');
    }

    if (urlParams.get('categories')) {
        selectedCategories.value = urlParams.get('categories').split(',');
    }

    if (urlParams.get('ratings')) {
        selectedRatings.value = urlParams.get('ratings').split(',');
    }

    if (urlParams.get('price_min')) {
        priceMin.value = urlParams.get('price_min');
    }

    if (urlParams.get('price_max')) {
        priceMax.value = urlParams.get('price_max');
    }

    if (urlParams.get('in_stock')) {
        inStockOnly.value = urlParams.get('in_stock') === '1';
    }

    if (urlParams.get('sort')) {
        sortBy.value = urlParams.get('sort');
    }
});

// ============================================
// WINDOW RESIZE HANDLER
// ============================================
const handleResize = () => {
    if (window.innerWidth >= 1024) {
        showFilters.value = true;
    }
};

window.addEventListener('resize', handleResize);
</script>
