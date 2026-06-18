<template>
    <div>
        <!-- Grid Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
            <h2 class="text-xl font-bold text-gray-900">{{ title }}</h2>
            <div class="flex items-center gap-2 text-sm w-full sm:w-auto">
                <span class="text-gray-500 whitespace-nowrap">Sort by:</span>
                <select
                    v-model="sortBy"
                    @change="handleSortChange"
                    class="flex-1 sm:flex-none px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-700"
                >
                    <option value="newest">Newest</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                    <option value="popular">Popular</option>
                    <option value="rating">Rating</option>
                </select>
            </div>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-teal-600 border-t-transparent"></div>
            <p class="text-gray-500 mt-2">Loading products...</p>
        </div>

        <!-- Products Grid -->
        <div v-else-if="products && products.length > 0" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-3 md:gap-4">
            <ProductCard
                v-for="product in products"
                :key="product.id"
                :product="product"
                @add-to-cart="handleAddToCart"
                @toggle-wishlist="handleToggleWishlist"
            />
        </div>

        <!-- No Products Message -->
        <div v-else class="text-center py-12 bg-white rounded-lg shadow-sm">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900">No products found</h3>
            <p class="text-gray-500 mt-1">Try adjusting your filters</p>
        </div>

        <!-- Pagination -->
        <div v-if="products && products.length > 0 && pagination && pagination.last_page > 1" class="mt-8 flex justify-center">
            <Pagination
                :current-page="pagination.current_page"
                :total-pages="pagination.last_page"
                :on-page-change="handlePageChange"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import ProductCard from './ProductCard.vue';
import Pagination from '@/Components/Common/Pagination.vue';

const props = defineProps({
    products: {
        type: Array,
        default: () => []
    },
    pagination: {
        type: Object,
        default: () => ({
            current_page: 1,
            last_page: 1
        })
    },
    title: {
        type: String,
        default: 'Featured Products'
    },
    loading: {
        type: Boolean,
        default: false
    },
    sortBy: {
        type: String,
        default: 'newest'
    },
    route: {
        type: String,
        default: '/products'
    }
});

const emit = defineEmits(['add-to-cart', 'toggle-wishlist', 'sort-change', 'page-change']);

const sortBy = ref(props.sortBy);

const handleAddToCart = (product) => {
    emit('add-to-cart', product);
};

const handleToggleWishlist = (productId) => {
    emit('toggle-wishlist', productId);
};

const handleSortChange = () => {
    emit('sort-change', sortBy.value);
};

const handlePageChange = (page) => {
    emit('page-change', page);
};

// Watch for sort changes from parent
watch(() => props.sortBy, (newVal) => {
    sortBy.value = newVal;
});
</script>
