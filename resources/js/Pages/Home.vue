<template>
    <CustomerLayout>
        <!-- Hero Banner -->
        <div class="mb-8">
            <div class="relative rounded-xl overflow-hidden bg-gradient-to-r from-teal-600 to-teal-800 h-48 sm:h-64 lg:h-80">
                <div class="absolute inset-0 flex items-center px-8 sm:px-12">
                    <div class="text-white">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold">Welcome to PakZone!</h1>
                        <p class="text-sm sm:text-base text-teal-100 mt-2">Pakistan's Premier E-Commerce Platform</p>
                        <p class="text-sm text-teal-200 mt-1">Shop millions of products with trusted delivery</p>
                        <Link href="/products" class="inline-block mt-4 px-6 py-2 bg-white text-teal-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                            Start Shopping
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar -->
            <div class="lg:w-72 xl:w-80 flex-shrink-0">
                <CategorySidebar :categories="categories" />
            </div>

            <!-- Products -->
            <div class="flex-1">
                <!-- Featured Products Header -->
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Featured Products</h2>
                    <Link href="/products" class="text-sm text-teal-600 hover:text-teal-700 font-medium hover:underline">
                        View All →
                    </Link>
                </div>

                <!-- Products Grid -->
                <div v-if="products && products.length > 0" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-4">
                    <ProductCard
                        v-for="product in products"
                        :key="product.id"
                        :product="product"
                        @add-to-cart="addToCart"
                    />
                </div>

                <!-- No Products -->
                <div v-else class="text-center py-12 bg-white rounded-lg shadow-sm">
                    <p class="text-gray-500">No products found.</p>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>

<script setup>
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import CategorySidebar from '@/Components/Home/CategorySidebar.vue';
import ProductCard from '@/Components/Home/ProductCard.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    categories: {
        type: Array,
        default: () => []
    },
    products: {
        type: Array,
        default: () => []
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
