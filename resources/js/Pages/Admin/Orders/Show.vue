<template>
    <AdminLayout page-title="Order Details">
        <div class="space-y-6">
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Order Number</p>
                        <p class="font-semibold text-gray-900">#{{ order.order_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date</p>
                        <p class="font-medium text-gray-700">{{ formatDate(order.created_at) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <select v-model="orderStatus" @change="updateStatus" class="mt-1 px-3 py-1 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="refunded">Refunded</option>
                        </select>
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
                        <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
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
            </div>

            <!-- Customer & Shipping -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Customer Info -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Customer Information</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Name</span>
                            <span class="font-medium">{{ order.user?.name || 'Guest' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Email</span>
                            <span class="font-medium">{{ order.user?.email || 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Phone</span>
                            <span class="font-medium">{{ order.user?.phone || 'N/A' }}</span>
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
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="font-semibold text-gray-900 mb-4">Order Summary</h4>
                <div class="space-y-2 text-sm max-w-md">
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
                        <span>Tax</span>
                        <span>Rs. {{ formatPrice(order.tax_amount || 0) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-900 border-t border-gray-200 pt-2">
                        <span>Total</span>
                        <span>Rs. {{ formatPrice(order.total_amount) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    order: {
        type: Object,
        required: true
    }
});

const orderStatus = ref(props.order.status || 'pending');

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

const updateStatus = () => {
    console.log('Update status:', orderStatus.value);
};
</script>
