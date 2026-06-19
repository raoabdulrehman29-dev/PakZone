<template>
    <CustomerLayout>
        <!-- Category Header -->
        <div class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-teal-600 to-teal-800 mb-6">
            <div class="px-6 py-8 sm:px-8 sm:py-10">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div>
                        <!-- Category Icon -->
                        <span v-if="category.icon" class="text-4xl">{{ category.icon }}</span>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ category.name }}</h1>
                        <p v-if="category.description" class="text-teal-100 mt-1 text-sm max-w-2xl">
                            {{ category.description }}
                        </p>
                        <p class="text-xs text-teal-200 mt-2">
                            {{ products.length || 0 }} products found
                        </p>
                    </div>
                </div>
            </div>
            <!-- Decorative pattern -->
            <div class="absolute right-0 top-0 opacity-10">
                <svg class="w-48 h-48 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                </svg>
            </div>
        </div>

        <!-- Sub-categories Navigation -->
        <div v-if="subCategories && subCategories.length > 0" class="flex gap-2 overflow-x-auto pb-4 mb-6 scrollbar-hide">
            <a
                v-for="sub in subCategories"
                :key="sub.id"
                :href="`/category/${sub.slug}`"
                class="px-4 py-2 text-sm bg-white border border-gray-200 rounded-full hover:border-teal-500 hover:text-teal-600 transition-colors whitespace-nowrap"
                :class="{ 'border-teal-500 text-teal-600': activeSubCategory === sub.slug }"
            >
                {{ sub.name }}
            </a>
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
            <h3 class="text-lg font-medium text-gray-900">No products in this category</h3>
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
import { router } from '@inertiajs/vue3';

defineProps({
    category: {
        type: Object,
        required: true
    },
    subCategories: {
        type: Array,
        default: () => []
    },
    products: {
        type: Array,
        default: () => []
    },
    activeSubCategory: {
        type: String,
        default: ''
    }
});

const addToCart = (product) => {
    router.post('/cart', {
        product_id: product.id,
        quantity: 1
    }, {
        preserveScroll: true,
    });
};
</script>
