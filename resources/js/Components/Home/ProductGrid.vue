<template>
    <div>
        <!-- Grid Header -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Featured Products</h2>
            <div class="flex items-center gap-2 text-sm">
                <span class="text-gray-500">Sort by:</span>
                <select class="px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-700">
                    <option>Featured</option>
                    <option>Newest</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Rating</option>
                </select>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4 md:gap-6">
            <ProductCard
                v-for="product in products"
                :key="product.id"
                :product="product"
                @add-to-cart="handleAddToCart"
            />
        </div>

        <!-- No Products Message -->
        <div v-if="products.length === 0" class="text-center py-12">
            <p class="text-gray-500">No products found.</p>
        </div>

        <!-- Pagination -->
        <div v-if="products.length > 0" class="mt-8 flex justify-center">
            <nav class="flex items-center gap-1">
                <button class="px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    Previous
                </button>
                <button class="px-3 py-2 text-sm bg-teal-600 text-white rounded-lg">1</button>
                <button class="px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">2</button>
                <button class="px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">3</button>
                <button class="px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">Next</button>
            </nav>
        </div>
    </div>
</template>

<script setup>
import ProductCard from './ProductCard.vue';

defineProps({
    products: {
        type: Array,
        default: () => []
    }
});

const handleAddToCart = (product) => {
    console.log('Added to cart:', product);
    // This will be handled by parent component
};
</script>
