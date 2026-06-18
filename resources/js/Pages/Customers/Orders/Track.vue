<template>
    <CustomersLayout page-title="Track Order" page-subtitle="Real-time order tracking">
        <div class="max-w-2xl mx-auto">
            <!-- Order Status -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-gray-900">Order #{{ order.order_number }}</h4>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full"
                        :class="getStatusClass(order.status)">
                        {{ getStatusLabel(order.status) }}
                    </span>
                </div>
                <p class="text-sm text-gray-500">Placed on {{ formatDate(order.created_at) }}</p>
            </div>

            <!-- Tracking Timeline -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="font-semibold text-gray-900 mb-6">Order Timeline</h4>
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                    <!-- Timeline Items -->
                    <div v-for="(step, index) in trackingSteps" :key="index" class="relative pl-12 pb-8 last:pb-0">
                        <!-- Circle -->
                        <div class="absolute left-0 top-0 w-8 h-8 rounded-full flex items-center justify-center"
                            :class="step.completed ? 'bg-teal-600' : 'bg-gray-200'">
                            <svg v-if="step.completed" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span v-else class="text-xs font-medium text-gray-400">{{ index + 1 }}</span>
                        </div>

                        <!-- Content -->
                        <div>
                            <p class="font-medium text-gray-900">{{ step.label }}</p>
                            <p v-if="step.description" class="text-sm text-gray-500">{{ step.description }}</p>
                            <p v-if="step.date" class="text-xs text-gray-400 mt-1">{{ step.date }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Details -->
            <div v-if="order.status === 'shipped' || order.status === 'delivered'" class="bg-white rounded-lg shadow-sm p-6 mt-6">
                <h4 class="font-semibold text-gray-900 mb-4">Delivery Details</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tracking Number</span>
                        <span class="font-medium">{{ order.tracking_number || 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Carrier</span>
                        <span class="font-medium">{{ order.shipping_method || 'Standard' }}</span>
                    </div>
                    <div v-if="order.estimated_delivery" class="flex justify-between">
                        <span class="text-gray-500">Estimated Delivery</span>
                        <span class="font-medium">{{ formatDate(order.estimated_delivery) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </CustomersLayout>
</template>

<script setup>
import CustomersLayout from '@/Layouts/CustomerLayout.vue';

const props = defineProps({
    order: {
        type: Object,
        required: true
    }
});

const trackingSteps = [
    { label: 'Order Placed', description: 'Your order has been confirmed', completed: true },
    { label: 'Processing', description: 'Your order is being prepared', completed: ['processing', 'shipped', 'delivered'].includes(props.order.status) },
    { label: 'Shipped', description: 'Your order is on the way', completed: ['shipped', 'delivered'].includes(props.order.status) },
    { label: 'Delivered', description: 'Your order has been delivered', completed: props.order.status === 'delivered' },
];

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
