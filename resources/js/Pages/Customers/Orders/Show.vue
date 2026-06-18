<template>
    <CustomerLayout page-title="Order Details" page-subtitle="View your order information">
        <div class="space-y-6">
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Order Number</p>
                        <p class="font-semibold text-gray-900">#{{ order.order_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Order Date</p>
                        <p class="font-medium text-gray-700">{{ formatDate(order.created_at) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full"
                            :class="getStatusClass(order.status)">
                            {{ getStatusLabel(order.status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total</p>
                        <p class="text-xl font-bold text-gray-900">Rs. {{ formatPrice(order.total_amount) }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="font-semibold text-gray-900 mb-4">Order Items</h4>
                <div class="divide-y divide-gray-100">
                    <div v-for="item in order.items" :key="item.id" class="py-4 flex flex-col sm:flex-row items-start gap-4">
                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                            <img :src="item.product?.image || 'https://via.placeholder.com/80x80?text=No+Image'"
                                 :alt="item.product?.name"
                                 class="w-full h-full object-cover"
                            />
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">{{ item.product?.name }}</p>
                            <p class="text-sm text-gray-500">Qty: {{ item.quantity }}</p>
                            <p class="text-sm text-gray-500">Price: Rs. {{ formatPrice(item.price) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">Rs. {{ formatPrice(item.total) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="mt-4 pt-4 border-t border-gray-200 space-y-1 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="font-medium">Rs. {{ formatPrice(order.subtotal) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Shipping</span>
                        <span class="font-medium">Rs. {{ formatPrice(order.shipping_cost || 0) }}</span>
                    </div>
                    <div v-if="order.discount > 0" class="flex justify-between text-green-600">
                        <span>Discount</span>
                        <span>- Rs. {{ formatPrice(order.discount) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Tax ({{ taxRate }}%)</span>
                        <span>Rs. {{ formatPrice(order.tax_amount || 0) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-900 border-t border-gray-200 pt-2">
                        <span>Total</span>
                        <span>Rs. {{ formatPrice(order.total_amount) }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="font-semibold text-gray-900 mb-4">Shipping Address</h4>
                <div class="text-sm text-gray-600">
                    <p class="font-medium text-gray-800">{{ order.shipping_address?.name }}</p>
                    <p>{{ order.shipping_address?.address }}</p>
                    <p>{{ order.shipping_address?.city }}, {{ order.shipping_address?.state }}</p>
                    <p>{{ order.shipping_address?.country }} - {{ order.shipping_address?.pincode }}</p>
                    <p>Phone: {{ order.shipping_address?.phone }}</p>
                </div>
            </div>

            <!-- Tracking (if available) -->
            <div v-if="order.tracking_number" class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="font-semibold text-gray-900 mb-4">Tracking Information</h4>
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Tracking Number: {{ order.tracking_number }}</p>
                        <p class="text-sm text-gray-500">Carrier: {{ order.shipping_method || 'Standard' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';

const props = defineProps({
    order: {
        type: Object,
        required: true
    },
    taxRate: {
        type: Number,
        default: 17
    }
});

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

const getStatusLabel = (status) => {
    const labels = {
        pending: 'Pending',
        processing: 'Processing',
        shipped: 'Shipped',
        delivered: 'Delivered',
        cancelled: 'Cancelled',
        refunded: 'Refunded'
    };
    return labels[status?.toLowerCase()] || status;
};

const getStatusClass = (status) => {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        processing: 'bg-blue-100 text-blue-800',
        shipped: 'bg-indigo-100 text-indigo-800',
        delivered: 'bg-green-100 text-green-800',
        cancelled: 'bg-red-100 text-red-800',
        refunded: 'bg-gray-100 text-gray-800'
    };
    return classes[status?.toLowerCase()] || 'bg-gray-100 text-gray-800';
};
</script>
