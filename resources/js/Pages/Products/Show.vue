<template>
    <CustomerLayout>
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6">
            <ol class="flex items-center gap-2 flex-wrap">
                <li><a href="/" class="hover:text-teal-600">Home</a></li>
                <li class="text-gray-300">/</li>
                <li>
                    <a :href="`/categories/${product.category?.slug}`" class="hover:text-teal-600">
                        {{ product.category?.name }}
                    </a>
                </li>
                <li class="text-gray-300">/</li>
                <li class="text-gray-700 font-medium">{{ product.name }}</li>
            </ol>
        </nav>

        <!-- Product Main Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            <!-- Left: Images -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="relative bg-gray-100 rounded-xl overflow-hidden aspect-square">
                    <img
                        :src="mainImage || 'https://via.placeholder.com/600x600?text=No+Image'"
                        :alt="product.name"
                        class="w-full h-full object-cover"
                    />
                    <!-- Discount Badge -->
                    <span v-if="product.discount_percentage"
                          class="absolute top-4 left-4 px-3 py-1 text-sm font-bold text-white bg-red-500 rounded-full">
                        -{{ product.discount_percentage }}%
                    </span>
                    <!-- Wishlist Button -->
                    <button
                        @click="toggleWishlist"
                        class="absolute top-4 right-4 p-2.5 bg-white/90 hover:bg-white rounded-full shadow-md transition-colors"
                        :class="{ 'text-red-500': isInWishlist }"
                    >
                        <svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                </div>

                <!-- Thumbnail Images -->
                <div v-if="product.images && product.images.length > 0"
                     class="grid grid-cols-4 sm:grid-cols-5 gap-2">
                    <button
                        v-for="(image, index) in product.images"
                        :key="index"
                        @click="mainImage = image.image"
                        class="relative bg-gray-100 rounded-lg overflow-hidden aspect-square hover:ring-2 hover:ring-teal-500 transition-all"
                        :class="{ 'ring-2 ring-teal-500': mainImage === image.image }"
                    >
                        <img :src="image.image" :alt="`${product.name} ${index + 1}`" class="w-full h-full object-cover" />
                    </button>
                </div>
            </div>

            <!-- Right: Product Info -->
            <div class="space-y-6">
                <!-- Brand & Name -->
                <div>
                    <p v-if="product.brand" class="text-sm text-teal-600 font-medium">
                        {{ product.brand.name }}
                    </p>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">
                        {{ product.name }}
                    </h1>
                </div>

                <!-- Rating -->
                <div class="flex items-center gap-3">
                    <StarRating :rating="product.rating || 0" :review-count="product.reviews_count || 0" />
                    <span class="text-sm text-gray-500">({{ product.reviews_count || 0 }} reviews)</span>
                </div>

                <!-- Price -->
                <div class="flex items-center gap-3">
                    <span class="text-3xl font-bold text-gray-900">Rs. {{ formatPrice(product.price) }}</span>
                    <span v-if="product.sale_price" class="text-lg text-gray-400 line-through">
                        Rs. {{ formatPrice(product.sale_price) }}
                    </span>
                    <span v-if="product.discount_percentage"
                          class="px-2 py-0.5 text-sm font-semibold text-green-700 bg-green-100 rounded">
                        Save {{ product.discount_percentage }}%
                    </span>
                </div>

                <!-- Stock Status -->
                <div class="flex items-center gap-2">
                    <span v-if="product.stock > 0" class="flex items-center gap-1 text-green-600">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        In Stock ({{ product.stock }} available)
                    </span>
                    <span v-else class="flex items-center gap-1 text-red-600">
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        Out of Stock
                    </span>
                </div>

                <!-- Variants -->
                <div v-if="product.variants && product.variants.length > 0" class="space-y-3">
                    <div v-for="(variantGroup, type) in groupedVariants" :key="type" class="space-y-1">
                        <label class="text-sm font-medium text-gray-700 capitalize">{{ type }}:</label>
                        <div class="flex flex-wrap gap-2">
                            <button
                                v-for="variant in variantGroup"
                                :key="variant.id"
                                @click="selectVariant(variant)"
                                class="px-4 py-1.5 text-sm border rounded-lg transition-all"
                                :class="{
                                    'border-teal-600 bg-teal-50 text-teal-700': selectedVariant?.id === variant.id,
                                    'border-gray-300 hover:border-gray-400': selectedVariant?.id !== variant.id
                                }"
                            >
                                {{ variant.value }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="flex items-center gap-4">
                    <label class="text-sm font-medium text-gray-700">Quantity:</label>
                    <div class="flex items-center border border-gray-300 rounded-lg">
                        <button
                            @click="decrementQuantity"
                            class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 transition-colors"
                            :disabled="quantity <= 1"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>
                        <span class="w-12 text-center font-medium">{{ quantity }}</span>
                        <button
                            @click="incrementQuantity"
                            class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 transition-colors"
                            :disabled="quantity >= (product.stock || 0)"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                    <span class="text-sm text-gray-500">Max: {{ product.stock || 0 }}</span>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <button
                        @click="addToCart"
                        :disabled="product.stock <= 0"
                        class="flex-1 px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            {{ product.stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                        </span>
                    </button>
                    <button
                        @click="buyNow"
                        :disabled="product.stock <= 0"
                        class="flex-1 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Buy Now
                    </button>
                </div>

                <!-- Delivery Info -->
                <div class="border-t border-gray-200 pt-4 space-y-2 text-sm">
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Free delivery on orders over Rs. 5,000</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>7-day return policy</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span>Secure payment</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        <div class="mt-12">
            <div class="border-b border-gray-200">
                <nav class="flex gap-6">
                    <button
                        @click="activeTab = 'description'"
                        class="pb-3 text-sm font-medium border-b-2 transition-colors"
                        :class="{
                            'border-teal-600 text-teal-600': activeTab === 'description',
                            'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'description'
                        }"
                    >
                        Description
                    </button>
                    <button
                        @click="activeTab = 'specifications'"
                        class="pb-3 text-sm font-medium border-b-2 transition-colors"
                        :class="{
                            'border-teal-600 text-teal-600': activeTab === 'specifications',
                            'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'specifications'
                        }"
                    >
                        Specifications
                    </button>
                    <button
                        @click="activeTab = 'reviews'"
                        class="pb-3 text-sm font-medium border-b-2 transition-colors"
                        :class="{
                            'border-teal-600 text-teal-600': activeTab === 'reviews',
                            'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'reviews'
                        }"
                    >
                        Reviews ({{ product.reviews_count || 0 }})
                    </button>
                </nav>
            </div>

            <div class="py-6">
                <!-- Description Tab -->
                <div v-if="activeTab === 'description'" class="prose max-w-none">
                    <p class="text-gray-600 leading-relaxed">{{ product.description || 'No description available.' }}</p>
                </div>

                <!-- Specifications Tab -->
                <div v-if="activeTab === 'specifications'" class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div v-for="(value, key) in product.specifications || {}" :key="key"
                         class="flex items-center border-b border-gray-100 py-2">
                        <span class="w-1/2 text-sm font-medium text-gray-600">{{ key }}</span>
                        <span class="w-1/2 text-sm text-gray-800">{{ value }}</span>
                    </div>
                    <p v-if="!product.specifications" class="text-gray-500">No specifications available.</p>
                </div>

                <!-- Reviews Tab -->
                <div v-if="activeTab === 'reviews'">
                    <!-- Review Summary -->
                    <div class="flex items-center gap-6 mb-6">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-gray-900">{{ product.rating || 0 }}</div>
                            <StarRating :rating="product.rating || 0" />
                            <span class="text-sm text-gray-500">{{ product.reviews_count || 0 }} reviews</span>
                        </div>
                        <div class="flex-1 space-y-1">
                            <div v-for="star in [5,4,3,2,1]" :key="star" class="flex items-center gap-2">
                                <span class="text-sm text-gray-600 w-6">{{ star }}</span>
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400 rounded-full"
                                         :style="{ width: getRatingPercentage(star) + '%' }"></div>
                                </div>
                                <span class="text-xs text-gray-400 w-8">{{ getRatingCount(star) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Review List -->
                    <div v-if="product.reviews && product.reviews.length > 0" class="space-y-4">
                        <div v-for="review in product.reviews" :key="review.id" class="border-b border-gray-100 pb-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-600">
                                            {{ review.user?.name?.charAt(0) || 'U' }}
                                        </span>
                                    </div>
                                    <span class="font-medium text-gray-800">{{ review.user?.name || 'Anonymous' }}</span>
                                    <span v-if="review.is_verified" class="text-xs text-green-600 bg-green-50 px-1.5 py-0.5 rounded">
                                        Verified
                                    </span>
                                </div>
                                <span class="text-xs text-gray-400">{{ formatDate(review.created_at) }}</span>
                            </div>
                            <StarRating :rating="review.rating" class="mt-1" />
                            <p class="text-gray-600 mt-1">{{ review.comment }}</p>
                        </div>
                    </div>
                    <p v-else class="text-gray-500">No reviews yet. Be the first to review this product!</p>

                    <!-- Write Review Button -->
                    <button v-if="user" @click="openReviewModal" class="mt-4 px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors">
                        Write a Review
                    </button>
                    <p v-else class="mt-4 text-sm text-gray-500">
                        <a href="/login" class="text-teal-600 hover:underline">Sign in</a> to write a review.
                    </p>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div v-if="relatedProducts && relatedProducts.length > 0" class="mt-12">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Related Products</h2>
            <ProductGrid :products="relatedProducts" />
        </div>
    </CustomerLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import ProductGrid from '@/Components/Home/ProductGrid.vue';
import StarRating from '@/Components/Shared/StarRating.vue';

// ============================================
// PROPS
// ============================================
const props = defineProps({
    product: {
        type: Object,
        required: true
    },
    relatedProducts: {
        type: Array,
        default: () => []
    },
    user: {
        type: Object,
        default: null
    }
});

const page = usePage();

// ============================================
// STATE
// ============================================
const mainImage = ref(props.product.images?.[0]?.image || null);
const quantity = ref(1);
const selectedVariant = ref(null);
const activeTab = ref('description');
const isInWishlist = ref(props.product.is_in_wishlist || false);
const showReviewModal = ref(false);

// ============================================
// COMPUTED
// ============================================
const groupedVariants = computed(() => {
    if (!props.product.variants) return {};
    return props.product.variants.reduce((acc, variant) => {
        if (!acc[variant.type]) {
            acc[variant.type] = [];
        }
        acc[variant.type].push(variant);
        return acc;
    }, {});
});

// ============================================
// METHODS
// ============================================
const formatPrice = (amount) => {
    return new Intl.NumberFormat('en-PK').format(amount || 0);
};

const formatDate = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('en-PK', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

const incrementQuantity = () => {
    if (quantity.value < (props.product.stock || 0)) {
        quantity.value++;
    }
};

const decrementQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};

const selectVariant = (variant) => {
    selectedVariant.value = variant;
};

const toggleWishlist = async () => {
    if (!props.user) {
        window.location.href = '/login';
        return;
    }

    try {
        // Will implement with API later
        isInWishlist.value = !isInWishlist.value;
        // await axios.post('/wishlist/toggle', { product_id: props.product.id });
    } catch (error) {
        console.error('Error toggling wishlist:', error);
    }
};

const addToCart = () => {
    if (props.product.stock <= 0) return;

    // Will implement with API later
    console.log('Add to cart:', {
        product_id: props.product.id,
        variant_id: selectedVariant.value?.id,
        quantity: quantity.value
    });
};

const buyNow = () => {
    if (props.product.stock <= 0) return;

    // Will implement with API later
    console.log('Buy now:', {
        product_id: props.product.id,
        variant_id: selectedVariant.value?.id,
        quantity: quantity.value
    });
};

const openReviewModal = () => {
    showReviewModal.value = true;
};

const getRatingPercentage = (star) => {
    // Will calculate from reviews data
    return 0;
};

const getRatingCount = (star) => {
    // Will calculate from reviews data
    return 0;
};

// ============================================
// LIFECYCLE
// ============================================
onMounted(() => {
    // Set first variant as default if available
    if (props.product.variants && props.product.variants.length > 0) {
        selectedVariant.value = props.product.variants[0];
    }
});
</script>
