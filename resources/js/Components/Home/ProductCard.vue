<template>
    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden group">
        <!-- Image Section -->
        <div class="relative overflow-hidden aspect-square bg-gray-100">
            <img
                :src="productImage"
                :alt="product.name"
                class="w-full h-full object-cover"
                @error="handleImageError"
            />

            <!-- Discount Badge -->
            <span v-if="product.discount_percentage > 0"
                  class="absolute top-2 right-2 px-2 py-1 text-xs font-bold text-white bg-red-500 rounded-full">
                -{{ product.discount_percentage }}%
            </span>

            <!-- Best Seller Badge -->
            <span v-if="product.best_seller"
                  class="absolute top-2 left-2 px-2 py-1 text-xs font-bold text-white bg-orange-500 rounded-full">
                Best Seller
            </span>
        </div>

        <!-- Product Info -->
        <div class="p-4">
            <!-- Brand -->
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">{{ brandName }}</p>

            <!-- Product Name -->
            <Link :href="`/products/${product.slug}`" class="block">
                <h3 class="text-sm font-semibold text-gray-800 hover:text-teal-600 transition-colors line-clamp-2 min-h-[40px]">
                    {{ product.name }}
                </h3>
            </Link>

            <!-- Rating -->
            <div class="flex items-center gap-2 mt-1">
                <StarRating :rating="product.rating || 0" :review-count="product.reviews_count || 0" />
                <span v-if="product.reviews_count" class="text-xs text-gray-500">({{ product.reviews_count }})</span>
            </div>

            <!-- Price -->
            <div class="mt-2">
                <span class="text-xl font-bold text-gray-900">Rs. {{ formatPrice(product.final_price || product.price) }}</span>
                <span v-if="product.sale_price" class="ml-2 text-sm text-gray-400 line-through">
                    Rs. {{ formatPrice(product.price) }}
                </span>
            </div>

            <!-- Free Delivery -->
            <div class="flex items-center gap-1 mt-1 text-xs text-teal-600">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Free Delivery</span>
            </div>

            <!-- Add to Cart -->
            <button
                @click="addToCart"
                :disabled="product.stock <= 0"
                class="w-full mt-3 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                {{ product.stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import StarRating from '@/Components/Shared/StarRating.vue';

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['add-to-cart']);

const brandName = computed(() => {
    return typeof props.product.brand === 'string'
        ? props.product.brand
        : props.product.brand?.name || 'Generic';
});

const productImage = computed(() => {
    return props.product.image || props.product.images?.[0]?.image || '/images/placeholder.png';
});

const formatPrice = (amount) => {
    return new Intl.NumberFormat('en-PK').format(amount || 0);
};

const addToCart = () => {
    if (props.product.stock > 0) {
        emit('add-to-cart', props.product);
    }
};

const handleImageError = (event) => {
    // Only try to replace once
    if (!event.target.dataset.retried) {
        event.target.dataset.retried = 'true';
        event.target.src = '/images/placeholder.png';
    }
};
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
