<template>
    <CustomerLayout>
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Shopping Cart</h1>
            <p class="text-sm text-gray-500 mt-1">
                {{ cartItems.length }} item{{ cartItems.length !== 1 ? 's' : '' }} in your cart
            </p>
        </div>

        <!-- Empty Cart -->
        <div v-if="cartItems.length === 0" class="text-center py-16 bg-white rounded-lg shadow-sm">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900">Your cart is empty</h3>
            <p class="text-gray-500 mt-1">Start shopping to add items to your cart</p>
            <a href="/" class="inline-block mt-4 px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors">
                Continue Shopping
            </a>
        </div>

        <!-- Cart Content -->
        <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Cart Item -->
                <div v-for="item in cartItems" :key="item.id"
                     class="bg-white rounded-lg shadow-sm p-4 flex flex-col sm:flex-row gap-4 hover:shadow-md transition-shadow">

                    <!-- Product Image -->
                    <div class="w-full sm:w-24 h-24 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                        <img :src="item.image || 'https://via.placeholder.com/100x100?text=No+Image'"
                             :alt="item.name"
                             class="w-full h-full object-cover"
                        />
                    </div>

                    <!-- Product Info -->
                    <div class="flex-1 space-y-2">
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2">
                            <div>
                                <a :href="`/product/${item.slug}`" class="font-medium text-gray-800 hover:text-teal-600 transition-colors">
                                    {{ item.name }}
                                </a>
                                <p v-if="item.variant" class="text-sm text-gray-500">Variant: {{ item.variant }}</p>
                                <p class="text-sm text-gray-500">SKU: {{ item.sku }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-bold text-gray-900">Rs. {{ formatPrice(item.price) }}</span>
                                <span v-if="item.original_price" class="ml-2 text-sm text-gray-400 line-through">
                                    Rs. {{ formatPrice(item.original_price) }}
                                </span>
                            </div>
                        </div>

                        <!-- Quantity & Actions -->
                        <div class="flex flex-wrap items-center gap-3">
                            <!-- Quantity Controls -->
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button
                                    @click="updateQuantity(item, item.quantity - 1)"
                                    class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 transition-colors"
                                    :disabled="item.quantity <= 1"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                </button>
                                <span class="w-10 text-center font-medium">{{ item.quantity }}</span>
                                <button
                                    @click="updateQuantity(item, item.quantity + 1)"
                                    class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 transition-colors"
                                    :disabled="item.quantity >= item.max_stock"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Save for Later -->
                            <button
                                @click="saveForLater(item)"
                                class="text-sm text-teal-600 hover:text-teal-700 hover:underline transition-colors"
                            >
                                Save for Later
                            </button>

                            <!-- Remove -->
                            <button
                                @click="removeItem(item)"
                                class="text-sm text-red-500 hover:text-red-600 hover:underline transition-colors"
                            >
                                Remove
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Continue Shopping -->
                <div class="text-center">
                    <a href="/" class="text-teal-600 hover:text-teal-700 font-medium hover:underline transition-colors">
                        ← Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>

                    <!-- Coupon Code -->
                    <div class="mb-4">
                        <label class="text-sm font-medium text-gray-700 block mb-1">Coupon Code</label>
                        <div class="flex gap-2">
                            <input
                                v-model="couponCode"
                                type="text"
                                placeholder="Enter code"
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm"
                            />
                            <button
                                @click="applyCoupon"
                                class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors"
                            >
                                Apply
                            </button>
                        </div>
                        <p v-if="couponError" class="text-sm text-red-600 mt-1">{{ couponError }}</p>
                        <p v-if="couponSuccess" class="text-sm text-green-600 mt-1">{{ couponSuccess }}</p>
                    </div>

                    <!-- Calculations -->
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">Rs. {{ formatPrice(subtotal) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-medium">
                                {{ shippingCost > 0 ? 'Rs. ' + formatPrice(shippingCost) : 'Free' }}
                            </span>
                        </div>
                        <div v-if="discount > 0" class="flex justify-between text-green-600">
                            <span>Discount</span>
                            <span>- Rs. {{ formatPrice(discount) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500 border-t border-gray-200 pt-2">
                            <span>Tax ({{ taxRate }}%)</span>
                            <span>Rs. {{ formatPrice(tax) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-gray-900 border-t border-gray-200 pt-2">
                            <span>Total</span>
                            <span>Rs. {{ formatPrice(total) }}</span>
                        </div>
                    </div>

                    <!-- Free Shipping Threshold -->
                    <div v-if="freeShippingThreshold > 0 && subtotal < freeShippingThreshold" class="mt-3">
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Free shipping on orders over Rs. {{ formatPrice(freeShippingThreshold) }}</span>
                            <span>Rs. {{ formatPrice(freeShippingThreshold - subtotal) }} more</span>
                        </div>
                        <div class="w-full h-2 bg-gray-200 rounded-full mt-1 overflow-hidden">
                            <div class="h-full bg-teal-500 rounded-full transition-all"
                                 :style="{ width: (subtotal / freeShippingThreshold * 100) + '%' }"></div>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <button
                        @click="proceedToCheckout"
                        :disabled="cartItems.length === 0"
                        class="w-full mt-4 px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Proceed to Checkout
                    </button>

                    <!-- Payment Methods -->
                    <div class="mt-4 text-center">
                        <p class="text-xs text-gray-400 mb-2">We Accept</p>
                        <div class="flex justify-center gap-3">
                            <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded">Visa</span>
                            <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded">Mastercard</span>
                            <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded">PayPal</span>
                            <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded">JazzCash</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save for Later Section -->
        <div v-if="savedItems.length > 0" class="mt-12">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Saved for Later</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="item in savedItems" :key="item.id"
                     class="bg-white rounded-lg shadow-sm p-4 flex items-center gap-4">
                    <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                        <img :src="item.image || 'https://via.placeholder.com/100x100?text=No+Image'"
                             :alt="item.name"
                             class="w-full h-full object-cover"
                        />
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-800">{{ item.name }}</h4>
                        <p class="text-sm font-bold text-gray-900">Rs. {{ formatPrice(item.price) }}</p>
                        <button @click="moveToCart(item)" class="text-xs text-teal-600 hover:text-teal-700 font-medium">
                            Move to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';

// ============================================
// PROPS
// ============================================
const props = defineProps({
    cartItems: {
        type: Array,
        default: () => []
    },
    savedItems: {
        type: Array,
        default: () => []
    },
    subtotal: {
        type: Number,
        default: 0
    },
    shippingCost: {
        type: Number,
        default: 0
    },
    discount: {
        type: Number,
        default: 0
    },
    tax: {
        type: Number,
        default: 0
    },
    total: {
        type: Number,
        default: 0
    },
    taxRate: {
        type: Number,
        default: 17
    },
    freeShippingThreshold: {
        type: Number,
        default: 5000
    }
});

// ============================================
// STATE
// ============================================
const couponCode = ref('');
const couponError = ref('');
const couponSuccess = ref('');
const loading = ref(false);

// ============================================
// METHODS
// ============================================
const formatPrice = (amount) => {
    return new Intl.NumberFormat('en-PK').format(amount || 0);
};

const updateQuantity = (item, quantity) => {
    if (quantity < 1) return;
    if (quantity > item.max_stock) return;

    loading.value = true;

    router.patch(`/cart/${item.id}`, { quantity }, {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            loading.value = false;
        }
    });
};

const removeItem = (item) => {
    if (!confirm(`Remove "${item.name}" from your cart?`)) return;

    loading.value = true;

    router.delete(`/cart/${item.id}`, {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            loading.value = false;
        }
    });
};

const saveForLater = (item) => {
    loading.value = true;

    router.patch(`/cart/${item.id}/save-for-later`, {}, {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            loading.value = false;
        }
    });
};

const moveToCart = (item) => {
    loading.value = true;

    router.patch(`/cart/move/${item.id}`, {}, {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            loading.value = false;
        }
    });
};

const applyCoupon = () => {
    if (!couponCode.value.trim()) {
        couponError.value = 'Please enter a coupon code';
        return;
    }

    loading.value = true;
    couponError.value = '';
    couponSuccess.value = '';

    router.post('/cart/apply-coupon', { code: couponCode.value }, {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            loading.value = false;
        }
    });
};

const proceedToCheckout = () => {
    if (props.cartItems.length === 0) return;
    router.get('/checkout');
};

// ============================================
// COMPUTED
// ============================================
const itemCount = computed(() => {
    return props.cartItems.reduce((total, item) => total + item.quantity, 0);
});
</script>
