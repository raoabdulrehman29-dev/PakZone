<template>
    <CustomersLayout page-title="My Wishlist" page-subtitle="Your saved products">
        <!-- Wishlist Grid -->
        <div v-if="wishlist && wishlist.length > 0" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
            <div v-for="item in wishlist" :key="item.id" class="bg-white rounded-lg shadow-sm overflow-hidden group relative">
                <!-- Product Image -->
                <div class="relative aspect-square bg-gray-100">
                    <img
                        :src="item.product?.image || 'https://via.placeholder.com/300x300?text=No+Image'"
                        :alt="item.product?.name"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    />
                    <!-- Remove Button -->
                    <button
                        @click="removeFromWishlist(item.id)"
                        class="absolute top-2 right-2 p-1.5 bg-white/90 hover:bg-white rounded-full shadow-md transition-colors"
                    >
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    <!-- Move to Cart -->
                    <button
                        @click="moveToCart(item.id)"
                        class="absolute bottom-2 left-2 right-2 px-3 py-1.5 text-sm bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors opacity-0 group-hover:opacity-100"
                    >
                        Move to Cart
                    </button>
                </div>

                <!-- Product Info -->
                <div class="p-3">
                    <a :href="`/product/${item.product?.slug}`" class="block">
                        <h3 class="text-sm font-medium text-gray-800 hover:text-teal-600 transition-colors line-clamp-2">
                            {{ item.product?.name }}
                        </h3>
                    </a>
                    <div class="mt-1">
                        <span class="text-sm font-bold text-gray-900">
                            Rs. {{ formatPrice(item.product?.price || 0) }}
                        </span>
                        <span v-if="item.product?.sale_price" class="ml-2 text-xs text-gray-400 line-through">
                            Rs. {{ formatPrice(item.product?.sale_price) }}
                        </span>
                    </div>
                    <StarRating :rating="item.product?.rating || 0" :review-count="item.product?.reviews_count || 0" />
                </div>
            </div>
        </div>

        <!-- Empty Wishlist -->
        <div v-else class="text-center py-16 bg-white rounded-lg shadow-sm">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <h3 class="text-xl font-medium text-gray-900">Your wishlist is empty</h3>
            <p class="text-gray-500 mt-1">Save your favorite items here</p>
            <a href="/" class="inline-block mt-4 px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors">
                Start Shopping →
            </a>
        </div>
    </CustomersLayout>
</template>

<script setup>
import CustomersLayout from '@/Layouts/CustomerLayout.vue';
import StarRating from '@/Components/Shared/StarRating.vue';

const props = defineProps({
    wishlist: {
        type: Array,
        default: () => []
    }
});

const formatPrice = (amount) => {
    return new Intl.NumberFormat('en-PK').format(amount || 0);
};

const removeFromWishlist = (id) => {
    if (confirm('Remove this item from wishlist?')) {
        console.log('Remove from wishlist:', id);
    }
};

const moveToCart = (id) => {
    console.log('Move to cart:', id);
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
