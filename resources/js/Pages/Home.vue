<template>
    <CustomerLayout>
        <div class="mb-8">
            <div class="relative rounded-xl overflow-hidden bg-gradient-to-r from-teal-600 to-teal-800 h-48 sm:h-64 lg:h-80">
                <div class="absolute inset-0 flex items-center px-8 sm:px-12">
                    <div class="text-white">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold">Welcome to PakZone!</h1>
                        <p class="text-sm sm:text-base text-teal-100 mt-2">Pakistan's Premier E-Commerce Platform</p>
                        <button class="mt-4 px-6 py-2 bg-white text-teal-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                            Start Shopping
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <div class="lg:w-72 xl:w-80 flex-shrink-0">
                <CategorySidebar :categories="categories" />
            </div>
            <div class="flex-1">
                <ProductGrid :products="products" />
            </div>
        </div>
    </CustomerLayout>
</template>

<script setup>
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import CategorySidebar from '@/Components/Home/CategorySidebar.vue';
import ProductGrid from '@/Components/Home/ProductGrid.vue';

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
</script>
