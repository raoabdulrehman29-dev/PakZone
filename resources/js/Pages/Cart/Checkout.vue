<template>
    <CustomerLayout>
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>
            <p class="text-sm text-gray-500 mt-1">Complete your order</p>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-teal-600 border-t-transparent"></div>
            <p class="text-gray-500 mt-3">Processing your order...</p>
        </div>

        <!-- Checkout Content -->
        <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Forms -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Step Indicator -->
                <div class="flex items-center gap-2 text-sm">
                    <span class="flex items-center gap-1">
                        <span class="w-6 h-6 bg-teal-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                        <span class="text-gray-700 font-medium">Shipping</span>
                    </span>
                    <span class="text-gray-300">→</span>
                    <span class="flex items-center gap-1">
                        <span class="w-6 h-6 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-xs font-bold">2</span>
                        <span class="text-gray-400">Payment</span>
                    </span>
                    <span class="text-gray-300">→</span>
                    <span class="flex items-center gap-1">
                        <span class="w-6 h-6 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-xs font-bold">3</span>
                        <span class="text-gray-400">Confirm</span>
                    </span>
                </div>

                <!-- Step 1: Shipping Address -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="text-teal-600">1.</span> Shipping Address
                    </h3>

                    <!-- Address Selection -->
                    <div v-if="addresses.length > 0" class="space-y-3">
                        <div v-for="address in addresses" :key="address.id"
                             class="flex items-start gap-3 p-3 border rounded-lg cursor-pointer transition-colors"
                             :class="{
                                 'border-teal-600 bg-teal-50': selectedAddress === address.id,
                                 'border-gray-200 hover:border-gray-300': selectedAddress !== address.id
                             }"
                             @click="selectedAddress = address.id"
                        >
                            <input
                                type="radio"
                                :value="address.id"
                                v-model="selectedAddress"
                                class="mt-1 text-teal-600 focus:ring-teal-500"
                            />
                            <div class="flex-1 text-sm">
                                <p class="font-medium text-gray-800">{{ address.name }}</p>
                                <p class="text-gray-600">{{ address.phone }}</p>
                                <p class="text-gray-600">{{ address.address }}</p>
                                <p class="text-gray-600">{{ address.city }}, {{ address.state }} - {{ address.pincode }}</p>
                            </div>
                            <span v-if="address.is_default" class="text-xs text-teal-600 bg-teal-50 px-2 py-1 rounded">
                                Default
                            </span>
                        </div>

                        <button @click="showAddAddress = true"
                                class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                            + Add New Address
                        </button>
                    </div>

                    <!-- Add Address Form -->
                    <div v-if="showAddAddress" class="border-t border-gray-200 pt-4 mt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Add New Address</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs text-gray-600">Full Name</label>
                                <input v-model="newAddress.name" type="text"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm" />
                            </div>
                            <div>
                                <label class="text-xs text-gray-600">Phone</label>
                                <input v-model="newAddress.phone" type="text"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm" />
                            </div>
                            <div class="sm:col-span-2">
                                <label class="text-xs text-gray-600">Address</label>
                                <input v-model="newAddress.address" type="text"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm" />
                            </div>
                            <div>
                                <label class="text-xs text-gray-600">City</label>
                                <input v-model="newAddress.city" type="text"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm" />
                            </div>
                            <div>
                                <label class="text-xs text-gray-600">Postal Code</label>
                                <input v-model="newAddress.pincode" type="text"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm" />
                            </div>
                        </div>
                        <div class="flex gap-2 mt-3">
                            <button @click="saveAddress"
                                    class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors">
                                Save Address
                            </button>
                            <button @click="showAddAddress = false"
                                    class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700">
                                Cancel
                            </button>
                        </div>
                    </div>

                    <div v-if="!addresses.length && !showAddAddress" class="text-center py-4">
                        <p class="text-gray-500">No addresses saved. Add one to continue.</p>
                        <button @click="showAddAddress = true"
                                class="mt-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors">
                            Add Address
                        </button>
                    </div>
                </div>

                <!-- Step 2: Payment Method -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="text-teal-600">2.</span> Payment Method
                    </h3>

                    <div class="space-y-3">
                        <div v-for="method in paymentMethods" :key="method.id"
                             class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-gray-300 transition-colors"
                             :class="{ 'border-teal-600 bg-teal-50': selectedPayment === method.id }"
                             @click="selectedPayment = method.id"
                        >
                            <input type="radio" :value="method.id" v-model="selectedPayment"
                                   class="text-teal-600 focus:ring-teal-500" />
                            <div class="flex items-center gap-2">
                                <span class="text-lg">{{ method.icon }}</span>
                                <span class="text-sm font-medium text-gray-700">{{ method.name }}</span>
                            </div>
                            <span v-if="method.is_default" class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded ml-auto">
                                Recommended
                            </span>
                        </div>
                    </div>

                    <!-- COD Note -->
                    <div v-if="selectedPayment === 'cod'" class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-xs text-yellow-700">
                            <span class="font-medium">Cash on Delivery</span> - You will pay when the order is delivered.
                        </p>
                    </div>
                </div>

                <!-- Step 3: Order Notes -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Notes</h3>
                    <textarea v-model="orderNotes"
                              rows="3"
                              placeholder="Any special instructions for delivery..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm">
                    </textarea>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>

                    <!-- Order Items -->
                    <div class="max-h-48 overflow-y-auto space-y-2 mb-4">
                        <div v-for="item in cartItems" :key="item.id" class="flex items-center gap-3 py-2 border-b border-gray-100">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                <img :src="item.image || 'https://via.placeholder.com/100x100?text=No+Image'"
                                     :alt="item.name"
                                     class="w-full h-full object-cover"
                                />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800 line-clamp-1">{{ item.name }}</p>
                                <p class="text-xs text-gray-500">Qty: {{ item.quantity }}</p>
                            </div>
                            <span class="text-sm font-bold text-gray-900">Rs. {{ formatPrice(item.price * item.quantity) }}</span>
                        </div>
                    </div>

                    <!-- Calculations -->
                    <div class="space-y-2 text-sm border-t border-gray-200 pt-4">
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
                        <div class="flex justify-between text-xs text-gray-500 border-t border-gray-200 pt-2">
                            <span>Tax ({{ taxRate }}%)</span>
                            <span>Rs. {{ formatPrice(tax) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-gray-900 border-t border-gray-200 pt-2">
                            <span>Total</span>
                            <span>Rs. {{ formatPrice(total) }}</span>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button
                        @click="placeOrder"
                        :disabled="!canPlaceOrder"
                        class="w-full mt-4 px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span v-if="!placingOrder">Place Order</span>
                        <span v-else class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Placing Order...
                        </span>
                    </button>

                    <!-- Security Badge -->
                    <div class="mt-3 flex items-center justify-center gap-2 text-xs text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Secure Checkout
                    </div>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';

// ============================================
// PROPS
// ============================================
const props = defineProps({
    cartItems: {
        type: Array,
        default: () => []
    },
    addresses: {
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
    user: {
        type: Object,
        default: null
    }
});

// ============================================
// STATE
// ============================================
const loading = ref(false);
const placingOrder = ref(false);
const selectedAddress = ref(null);
const selectedPayment = ref('cod');
const orderNotes = ref('');
const showAddAddress = ref(false);
const couponCode = ref('');

const newAddress = ref({
    name: '',
    phone: '',
    address: '',
    city: '',
    state: '',
    pincode: '',
    country: 'Pakistan'
});

// ============================================
// COMPUTED
// ============================================
const canPlaceOrder = computed(() => {
    return selectedAddress.value !== null &&
           selectedPayment.value !== null &&
           props.cartItems.length > 0 &&
           !placingOrder.value;
});

const paymentMethods = [
    { id: 'cod', name: 'Cash on Delivery', icon: '💵', is_default: true },
    { id: 'card', name: 'Credit/Debit Card', icon: '💳', is_default: false },
    { id: 'paypal', name: 'PayPal', icon: '💰', is_default: false },
    { id: 'jazzcash', name: 'JazzCash', icon: '📱', is_default: false },
    { id: 'easypaisa', name: 'EasyPaisa', icon: '📱', is_default: false }
];

// ============================================
// METHODS
// ============================================
const formatPrice = (amount) => {
    return new Intl.NumberFormat('en-PK').format(amount || 0);
};

const saveAddress = () => {
    // Will implement with API later
    showAddAddress.value = false;
};

const placeOrder = () => {
    if (!canPlaceOrder.value) return;

    placingOrder.value = true;

    const orderData = {
        address_id: selectedAddress.value,
        payment_method: selectedPayment.value,
        notes: orderNotes.value,
        coupon_code: couponCode.value
    };

    router.post('/orders', orderData, {
        preserveState: false,
        onSuccess: () => {
            placingOrder.value = false;
        },
        onError: () => {
            placingOrder.value = false;
        }
    });
};

// ============================================
// LIFECYCLE
// ============================================
onMounted(() => {
    // Set default address if available
    if (props.addresses.length > 0) {
        const defaultAddress = props.addresses.find(a => a.is_default);
        selectedAddress.value = defaultAddress ? defaultAddress.id : props.addresses[0].id;
    }
});
</script>
