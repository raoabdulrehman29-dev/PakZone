<template>
    <CustomerLayout>
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-4 overflow-x-auto">
            <ol class="flex items-center gap-2 flex-nowrap">
                <li><a href="/" class="hover:text-teal-600">Home</a></li>
                <li class="text-gray-300">›</li>
                <li>
                    <a :href="`/category/${product.category?.slug}`" class="hover:text-teal-600">
                        {{ product.category?.name }}
                    </a>
                </li>
                <li class="text-gray-300">›</li>
                <li class="text-gray-700 font-medium truncate max-w-[200px]">{{ product.name }}</li>
            </ol>
        </nav>

        <!-- Loading State -->
        <div v-if="loading" class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-teal-600 border-t-transparent"></div>
            <p class="text-gray-500 mt-3">Loading product details...</p>
        </div>

        <!-- Product Content -->
        <div v-else class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-4 sm:p-6">
                <!-- ============================================ -->
                <!-- MAIN PRODUCT SECTION - Amazon Style -->
                <!-- ============================================ -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">

                    <!-- ========================================== -->
                    <!-- LEFT: IMAGE GALLERY (4 columns) -->
                    <!-- ========================================== -->
                    <div class="lg:col-span-5">
                        <!-- Main Image -->
                        <div class="relative bg-gray-50 rounded-lg overflow-hidden aspect-square border border-gray-200">
                            <img
                                :src="mainImage || 'https://via.placeholder.com/600x600?text=No+Image'"
                                :alt="product.name"
                                class="w-full h-full object-contain p-4"
                                @mouseenter="isZooming = true"
                                @mouseleave="isZooming = false"
                            />

                            <!-- Zoom Overlay -->
                            <div v-if="isZooming" class="absolute inset-0 pointer-events-none">
                                <div class="w-full h-full bg-white/10 backdrop-blur-[2px] flex items-center justify-center">
                                    <span class="text-white bg-black/50 px-4 py-2 rounded-lg text-sm">🔍 Zoom</span>
                                </div>
                            </div>

                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex flex-col gap-2">
                                <span v-if="product.discount_percentage"
                                      class="px-2.5 py-1 text-xs font-bold text-white bg-red-500 rounded shadow-lg">
                                    -{{ product.discount_percentage }}%
                                </span>
                                <span v-if="product.best_seller"
                                      class="px-2.5 py-1 text-xs font-bold text-white bg-orange-500 rounded shadow-lg">
                                    Best Seller
                                </span>
                            </div>

                            <!-- Wishlist Button -->
                            <button
                                @click="toggleWishlist"
                                class="absolute top-3 right-3 p-2 bg-white/90 hover:bg-white rounded-full shadow-md transition-colors"
                                :class="{ 'text-red-500': isInWishlist }"
                            >
                                <svg class="w-5 h-5" :fill="isInWishlist ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Thumbnails -->
                        <div v-if="product.images && product.images.length > 0"
                             class="grid grid-cols-5 gap-2 mt-3">
                            <button
                                v-for="(image, index) in product.images"
                                :key="index"
                                @click="mainImage = image.image"
                                class="relative bg-gray-50 rounded-lg overflow-hidden aspect-square border-2 transition-all"
                                :class="{ 'border-teal-500': mainImage === image.image, 'border-gray-200 hover:border-gray-300': mainImage !== image.image }"
                            >
                                <img :src="image.image" :alt="`${product.name} ${index + 1}`" class="w-full h-full object-cover p-1" />
                            </button>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- RIGHT: PRODUCT INFO (7 columns) -->
                    <!-- ========================================== -->
                    <div class="lg:col-span-7 space-y-4">
                        <!-- Brand & Name -->
                        <div>
                            <p v-if="product.brand" class="text-sm text-teal-600 font-medium hover:text-teal-700 cursor-pointer">
                                {{ product.brand.name }}
                            </p>
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">
                                {{ product.name }}
                            </h1>
                        </div>

                        <!-- Rating & Reviews -->
                        <div class="flex flex-wrap items-center gap-3">
                            <StarRating :rating="product.rating || 0" />
                            <a href="#reviews" class="text-sm text-teal-600 hover:text-teal-700 hover:underline">
                                {{ product.reviews_count || 0 }} reviews
                            </a>
                            <span class="text-sm text-gray-400">|</span>
                            <span class="text-sm text-green-600">{{ product.sold_count || 0 }} sold</span>
                        </div>

                        <!-- ========================================== -->
                        <!-- PRICE BOX - Amazon Style -->
                        <!-- ========================================== -->
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2 border border-gray-100">
                            <div class="flex items-end gap-3 flex-wrap">
                                <span class="text-2xl sm:text-3xl font-bold text-gray-900">
                                    Rs. {{ formatPrice(product.price) }}
                                </span>
                                <span v-if="product.sale_price" class="text-base text-gray-400 line-through">
                                    Rs. {{ formatPrice(product.sale_price) }}
                                </span>
                                <span v-if="product.discount_percentage"
                                      class="px-2 py-0.5 text-xs font-semibold text-green-700 bg-green-100 rounded">
                                    Save {{ product.discount_percentage }}%
                                </span>
                            </div>

                            <!-- EMI -->
                            <div v-if="product.price > 10000" class="text-sm text-gray-600">
                                <span class="font-medium">Easy EMI:</span>
                                Starting from Rs. {{ formatPrice(Math.round(product.price / 12)) }}/month
                                <a href="#" class="text-teal-600 hover:underline ml-1">Know more</a>
                            </div>

                            <!-- Tax Info -->
                            <p class="text-xs text-gray-500">Inclusive of all taxes</p>
                        </div>

                        <!-- ========================================== -->
                        <!-- DELIVERY BOX - Amazon Style -->
                        <!-- ========================================== -->
                        <div class="border border-gray-200 rounded-lg p-4 space-y-2 bg-white">
                            <!-- Stock Status -->
                            <div class="flex items-center gap-2">
                                <span v-if="product.stock > 10" class="flex items-center gap-1 text-green-600">
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                    <span class="font-medium">In Stock</span>
                                </span>
                                <span v-else-if="product.stock > 0" class="flex items-center gap-1 text-orange-500">
                                    <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                    <span class="font-medium">Only {{ product.stock }} left!</span>
                                </span>
                                <span v-else class="flex items-center gap-1 text-red-600">
                                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                    <span class="font-medium">Out of Stock</span>
                                </span>
                            </div>

                            <!-- Delivery -->
                            <div class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-teal-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <div>
                                    <span class="font-medium text-gray-700">Free Delivery</span>
                                    <span class="text-gray-500"> on orders over Rs. 5,000</span>
                                    <p class="text-xs text-gray-400">Estimated delivery: 3-5 business days</p>
                                </div>
                            </div>

                            <!-- Returns -->
                            <div class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-teal-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span class="text-gray-600">7-day return policy</span>
                            </div>

                            <!-- Payment -->
                            <div class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-teal-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-gray-600">Secure payment</span>
                            </div>
                        </div>

                        <!-- ========================================== -->
                        <!-- VARIANTS -->
                        <!-- ========================================== -->
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

                        <!-- ========================================== -->
                        <!-- QUANTITY & ACTIONS -->
                        <!-- ========================================== -->
                        <div class="space-y-3">
                            <!-- Quantity -->
                            <div class="flex items-center gap-4">
                                <label class="text-sm font-medium text-gray-700">Qty:</label>
                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                    <button
                                        @click="decrementQuantity"
                                        class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 transition-colors disabled:opacity-50"
                                        :disabled="quantity <= 1"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </button>
                                    <span class="w-12 text-center font-medium">{{ quantity }}</span>
                                    <button
                                        @click="incrementQuantity"
                                        class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 transition-colors disabled:opacity-50"
                                        :disabled="quantity >= (product.stock || 0)"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </div>
                                <span class="text-xs text-gray-500">Max: {{ product.stock || 0 }}</span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3">
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
                        </div>

                        <!-- Share -->
                        <div class="flex items-center gap-3 pt-2 border-t border-gray-200">
                            <span class="text-sm text-gray-500">Share:</span>
                            <button @click="shareProduct" class="text-gray-400 hover:text-teal-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/>
                                </svg>
                            </button>
                            <button class="text-gray-400 hover:text-teal-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.104c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 0021.288-11.49 9.976 9.976 0 002.506-2.6z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- TABS: Description, Specifications, Reviews -->
        <!-- ============================================ -->
        <div class="mt-6 bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 overflow-x-auto px-4">
                <nav class="flex gap-6">
                    <button
                        v-for="tab in tabs"
                        :key="tab.key"
                        @click="activeTab = tab.key"
                        class="py-4 text-sm font-medium border-b-2 transition-colors whitespace-nowrap"
                        :class="{
                            'border-teal-600 text-teal-600': activeTab === tab.key,
                            'border-transparent text-gray-500 hover:text-gray-700': activeTab !== tab.key
                        }"
                    >
                        {{ tab.label }}
                        <span v-if="tab.key === 'reviews' && product.reviews_count"
                              class="ml-1 text-xs bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full">
                            {{ product.reviews_count }}
                        </span>
                    </button>
                </nav>
            </div>

            <div class="p-4 sm:p-6">
                <!-- Description -->
                <div v-if="activeTab === 'description'" class="prose max-w-none">
                    <p class="text-gray-600 leading-relaxed whitespace-pre-wrap">{{ product.description || 'No description available.' }}</p>
                </div>

                <!-- Specifications -->
                <div v-if="activeTab === 'specifications'">
                    <div v-if="product.specifications && Object.keys(product.specifications).length > 0"
                         class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div v-for="(value, key) in product.specifications" :key="key"
                             class="flex items-center border-b border-gray-100 py-2">
                            <span class="w-1/2 text-sm font-medium text-gray-600">{{ key }}</span>
                            <span class="w-1/2 text-sm text-gray-800">{{ value }}</span>
                        </div>
                    </div>
                    <p v-else class="text-gray-500">No specifications available.</p>
                </div>

                <!-- Reviews -->
                <div v-if="activeTab === 'reviews'" id="reviews">
                    <!-- Review Summary -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 mb-6">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-gray-900">{{ product.rating || 0 }}</div>
                            <StarRating :rating="product.rating || 0" />
                            <span class="text-sm text-gray-500">{{ product.reviews_count || 0 }} reviews</span>
                        </div>
                    </div>

                    <!-- Write Review -->
                    <div v-if="user" class="mb-6">
                        <button @click="openReviewModal" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors">
                            Write a Review
                        </button>
                    </div>
                    <p v-else class="text-sm text-gray-500 mb-4">
                        <a href="/login" class="text-teal-600 hover:underline">Sign in</a> to write a review.
                    </p>

                    <!-- Review List -->
                    <div v-if="product.reviews && product.reviews.length > 0" class="space-y-4">
                        <div v-for="review in product.reviews" :key="review.id" class="border-b border-gray-100 pb-4">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-gradient-to-br from-teal-500 to-teal-700 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-white">
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
                            <p class="text-gray-600 mt-1 text-sm">{{ review.comment }}</p>
                        </div>
                    </div>
                    <p v-else class="text-gray-500">No reviews yet. Be the first to review this product!</p>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- RELATED PRODUCTS -->
        <!-- ============================================ -->
        <div v-if="relatedProducts && relatedProducts.length > 0" class="mt-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Related Products</h2>
            <ProductGrid :products="relatedProducts" />
        </div>
    </CustomerLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
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

// ============================================
// STATE
// ============================================
const loading = ref(false);
const mainImage = ref(props.product.images?.[0]?.image || null);
const quantity = ref(1);
const selectedVariant = ref(null);
const activeTab = ref('description');
const isInWishlist = ref(props.product.is_in_wishlist || false);
const isZooming = ref(false);
const showReviewModal = ref(false);

// ============================================
// TABS
// ============================================
const tabs = [
    { key: 'description', label: 'Description' },
    { key: 'specifications', label: 'Specifications' },
    { key: 'reviews', label: 'Reviews' }
];

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

const toggleWishlist = () => {
    if (!props.user) {
        window.location.href = '/login';
        return;
    }
    isInWishlist.value = !isInWishlist.value;
};

const addToCart = () => {
    if (props.product.stock <= 0) return;
    console.log('Add to cart:', {
        product_id: props.product.id,
        variant_id: selectedVariant.value?.id,
        quantity: quantity.value
    });
};

const buyNow = () => {
    if (props.product.stock <= 0) return;
    console.log('Buy now:', {
        product_id: props.product.id,
        variant_id: selectedVariant.value?.id,
        quantity: quantity.value
    });
};

const openReviewModal = () => {
    showReviewModal.value = true;
};

const shareProduct = () => {
    if (navigator.share) {
        navigator.share({
            title: props.product.name,
            text: `Check out ${props.product.name} on PakZone!`,
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Link copied to clipboard!');
    }
};

// ============================================
// LIFECYCLE
// ============================================
onMounted(() => {
    if (props.product.variants && props.product.variants.length > 0) {
        selectedVariant.value = props.product.variants[0];
    }
});
</script>
