<template>
    <CustomerLayout>
        <!-- Brand Header -->
        <div class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-gray-800 to-gray-900 mb-6">
            <div class="px-6 py-8 sm:px-8 sm:py-10">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <!-- Brand Logo -->
                    <div v-if="brand.logo" class="w-24 h-24 bg-white rounded-2xl p-3 flex items-center justify-center shadow-lg flex-shrink-0">
                        <img :src="brand.logo" :alt="brand.name" class="max-w-full max-h-full object-contain" />
                    </div>
                    <div class="flex-1 text-center sm:text-left">
                        <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ brand.name }}</h1>
                        <p v-if="brand.description" class="text-gray-300 mt-1 text-sm max-w-2xl">
                            {{ brand.description }}
                        </p>
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 mt-3">
                            <span class="text-xs text-gray-400">
                                {{ products.length || 0 }} products
                            </span>
                            <span v-if="brand.website" class="text-xs">
                                <a :href="brand.website" target="_blank" class="text-teal-400 hover:text-teal-300 hover:underline">
                                    Visit Website →
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div v-if="products && products.length > 0" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
            <ProductCard
                v-for="product in products"
                :key="product.id"
                :product="product"
                @add-to-cart="addToCart"
            />
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-12 bg-white rounded-lg shadow-sm">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900">No products from this brand</h3>
            <p class="text-gray-500 mt-1">Check back later for new arrivals</p>
            <a href="/" class="inline-block mt-4 text-teal-600 hover:text-teal-700 font-medium hover:underline">
                Continue Shopping →
            </a>
        </div>
    </CustomerLayout>
</template>

<script setup>
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import ProductCard from '@/Components/Home/ProductCard.vue';

defineProps({
    brand: {
        type: Object,
        required: true
    },
    products: {
        type: Array,
        default: () => []
    }
});

const addToCart = (product) => {
    console.log('Add to cart:', product);
};
</script>
