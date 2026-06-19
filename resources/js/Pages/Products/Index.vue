<template>
    <CustomerLayout>
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">All Products</h1>
            <p class="text-sm text-gray-500 mt-1">Browse our complete collection</p>
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
                >
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
            <!-- Left Sidebar - Filters (Desktop) -->
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
                        <div class="space-y-2">
                            <template v-for="category in categories" :key="category.id">
                                <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        :value="category.id"
                                        v-model="selectedCategories"
                                        class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                                    >
                                    {{ category.name }}
                                    <span class="text-xs text-gray-400">({{ category.products_count || 0 }})</span>
                                </label>
                                <label v-for="child in category.children || []" :key="child.id"
                                       class="ml-5 flex items-center gap-2 text-sm text-gray-500 hover:text-gray-900 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        :value="child.id"
                                        v-model="selectedCategories"
                                        class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                                    >
                                    {{ child.name }}
                                    <span class="text-xs text-gray-400">({{ child.products_count || 0 }})</span>
                                </label>
                            </template>
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
                                class="w-1/2 px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                            >
                            <span class="text-gray-400">-</span>
                            <input
                                type="number"
                                v-model="priceMax"
                                placeholder="Max"
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
                                class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                            >
                            In Stock Only
                        </label>
                    </div>

                    <!-- Apply Filters Button -->
                    <button
                        @click="applyFilters"
                        class="w-full mt-6 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors shadow-md"
                    >
                        Apply Filters
                    </button>

                    <button
                        @click="clearFilters"
                        class="w-full mt-2 px-4 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-lg transition-colors"
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
                    <p class="text-gray-500 mt-2">Loading products...</p>
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

                <!-- No Products -->
                <div v-else class="text-center py-12 bg-white rounded-lg shadow-sm">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                    <p class="text-gray-500 mt-1">Try adjusting your filters</p>
                    <button
                        @click="clearFilters"
                        class="mt-4 px-4 py-2 text-sm text-teal-600 hover:text-teal-700 font-medium"
                    >
                        Clear all filters
                    </button>
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
    </CustomerLayout>
</template>

<script setup>
import { ref, reactive, onMounted, watch } from 'vue';
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

// Filter state
const selectedCategories = ref([]);
const selectedRatings = ref([]);
const priceMin = ref('');
const priceMax = ref('');
const inStockOnly = ref(false);
const sortBy = ref('newest');

// ============================================
// METHODS
// ============================================
const applyFilters = () => {
    loading.value = true;

    const filters = {
        categories: selectedCategories.value.length ? selectedCategories.value.join(',') : null,
        ratings: selectedRatings.value.length ? selectedRatings.value.join(',') : null,
        price_min: priceMin.value || null,
        price_max: priceMax.value || null,
        in_stock: inStockOnly.value ? 1 : null,
        sort: sortBy.value
    };

    Object.keys(filters).forEach((key) => {
        if (filters[key] === null || filters[key] === '') {
            delete filters[key];
        }
    });

    router.get('/products', filters, {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            loading.value = false;
        }
    });
};

const clearFilters = () => {
    selectedCategories.value = [];
    selectedRatings.value = [];
    priceMin.value = '';
    priceMax.value = '';
    inStockOnly.value = false;
    sortBy.value = 'newest';
    router.get('/products', {}, {
        preserveScroll: true,
        onFinish: () => {
            loading.value = false;
        }
    });
};

const goToPage = (page) => {
    if (page < 1 || page > props.pagination.last_page) return;
    loading.value = true;

    router.get('/products', { page, ...props.filters }, {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            loading.value = false;
        }
    });
};

const addToCart = (product) => {
    router.post('/cart', {
        product_id: product.id,
        quantity: 1
    }, {
        preserveScroll: true,
    });
};

// ============================================
// WATCHERS
// ============================================
watch(sortBy, () => {
    applyFilters();
});

// ============================================
// LIFEHOOKS
// ============================================
onMounted(() => {
    // Set initial filter values from props
    if (props.filters) {
        selectedCategories.value = props.filters.categories ? props.filters.categories.split(',') : [];
        selectedRatings.value = props.filters.ratings ? props.filters.ratings.split(',') : [];
        priceMin.value = props.filters.price_min || '';
        priceMax.value = props.filters.price_max || '';
        inStockOnly.value = props.filters.in_stock === 1 || props.filters.in_stock === '1';
        sortBy.value = props.filters.sort || 'newest';
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
