<template>
    <CustomerLayout>
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Track Your Order</h1>
            <p class="text-sm text-gray-500 mb-6">Enter your order number to track your shipment</p>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <form @submit.prevent="trackOrder" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Order Number</label>
                        <input
                            v-model="orderNumber"
                            type="text"
                            placeholder="e.g., PAK-2026-001"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                            required
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input
                            v-model="email"
                            type="email"
                            placeholder="your@email.com"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                            required
                        />
                    </div>
                    <button
                        type="submit"
                        class="w-full px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors"
                    >
                        Track Order
                    </button>
                </form>

                <div v-if="trackingResult" class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="font-semibold text-gray-900">Order Status</h4>
                    <p class="text-sm text-gray-600 mt-2">{{ trackingResult }}</p>
                </div>
            </div>

            <div class="mt-4 text-sm text-gray-500 text-center">
                <p>Don't have an order number? <a href="/contact" class="text-teal-600 hover:underline">Contact Support</a></p>
            </div>
        </div>
    </CustomerLayout>
</template>

<script setup>
import { ref } from 'vue';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';

const orderNumber = ref('');
const email = ref('');
const trackingResult = ref(null);

const trackOrder = () => {
    trackingResult.value = `Your order ${orderNumber.value} is being processed. We'll update you shortly.`;
};
</script>
