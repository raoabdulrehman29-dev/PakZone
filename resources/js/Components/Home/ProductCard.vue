<template>
    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden group">
        <!-- Image Section -->
        <div class="relative overflow-hidden aspect-square">
            <img
                :src="product.image || 'https://via.placeholder.com/300x300?text=No+Image'"
                :alt="product.name"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            />
            <!-- Discount Badge -->
            <span v-if="product.discount_percentage"
                  class="absolute top-2 right-2 px-2 py-1 text-xs font-bold text-white bg-red-500 rounded-full">
                -{{ product.discount_percentage }}%
            </span>
            <!-- Wishlist Button -->
            <button class="absolute top-2 left-2 p-1.5 bg-white/80 hover:bg-white rounded-full shadow-sm transition-colors">
                <svg class="w-5 h-5 text-gray-400 hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </button>
        </div>

        <!-- Product Info -->
        <div class="p-4">
            <!-- Brand/Store -->
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">{{ product.brand || 'Generic' }}</p>

            <!-- Product Name -->
            <a :href="`/product/${product.slug}`" class="block">
                <h3 class="text-sm font-semibold text-gray-800 hover:text-teal-600 transition-colors line-clamp-2 min-h-[40px]">
                    {{ product.name }}
                </h3>
            </a>

            <!-- Rating -->
            <div class="flex items-center gap-2 mt-1">
                <StarRating :rating="product.rating || 0" :review-count="product.reviews_count || 0" />
                <span v-if="product.sold_count" class="text-xs text-gray-500">{{ product.sold_count }} sold</span>
            </div>

            <!-- Price -->
            <div class="mt-2">
                <span class="text-xl font-bold text-gray-900">Rs. {{ formatPrice(product.price) }}</span>
                <span v-if="product.original_price" class="ml-2 text-sm text-gray-400 line-through">
                    Rs. {{ formatPrice(product.original_price) }}
                </span>
            </div>

            <!-- Free Delivery Badge -->
            <div class="flex items-center gap-1 mt-1 text-xs text-teal-600">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Free Delivery</span>
            </div>

            <!-- Add to Cart Button -->
            <button
                @click="$emit('add-to-cart', product)"
                class="w-full mt-3 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Add to Cart
            </button>
        </div>
    </div>
</template>

<script setup>
import StarRating from '@/Components/Shared/StarRating.vue';

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['add-to-cart']);

const formatPrice = (amount) => {
    return new Intl.NumberFormat('en-PK').format(amount);
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
