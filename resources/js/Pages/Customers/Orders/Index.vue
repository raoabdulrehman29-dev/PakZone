<template>
    <CustomerLayout page-title="My Orders" page-subtitle="View all your orders">
        <!-- Status Filter -->
        <div class="flex gap-2 overflow-x-auto pb-2 mb-6">
            <button
                v-for="status in statuses"
                :key="status.value"
                @click="filterStatus = status.value"
                class="px-4 py-2 text-sm rounded-full border transition-colors whitespace-nowrap"
                :class="{
                    'bg-teal-600 text-white border-teal-600': filterStatus === status.value,
                    'bg-white text-gray-600 border-gray-300 hover:border-teal-400': filterStatus !== status.value
                }"
            >
                {{ status.label }}
                <span v-if="status.count" class="ml-1 text-xs opacity-75">({{ status.count }})</span>
            </button>
        </div>

        <!-- Orders List -->
        <div v-if="orders && orders.length > 0" class="space-y-4">
            <div v-for="order in orders" :key="order.id" class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex flex-wrap items-start justify-between gap-2">
                    <div>
                        <p class="font-semibold text-gray-900">Order #{{ order.order_number }}</p>
                        <p class="text-sm text-gray-500">{{ formatDate(order.created_at) }}</p>
                        <p class="text-sm text-gray-500">{{ order.items?.length || 0 }} items</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-gray-900">Rs. {{ formatPrice(order.total_amount) }}</p>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                            :class="getStatusClass(order.status)">
                            {{ getStatusLabel(order.status) }}
                        </span>
                    </div>
                </div>

                <!-- Order Items Preview -->
                <div v-if="order.items && order.items.length > 0" class="mt-4 flex gap-3 overflow-x-auto">
                    <div v-for="item in order.items.slice(0, 3)" :key="item.id" class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden">
                            <img :src="item.product?.image || 'https://via.placeholder.com/50x50?text=No+Image'"
                                 :alt="item.product?.name"
                                 class="w-full h-full object-cover"
                            />
                        </div>
                    </div>
                    <div v-if="order.items.length > 3" class="flex items-center text-sm text-gray-500">
                        +{{ order.items.length - 3 }} more
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap gap-2">
                    <Link :href="`/orders/${order.id}`" class="px-4 py-1.5 text-sm bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors">
                        View Details
                    </Link>
                    <Link v-if="order.status === 'pending' || order.status === 'processing'"
                          :href="`/orders/${order.id}/track`"
                          class="px-4 py-1.5 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                        Track Order
                    </Link>
                    <button v-if="order.status === 'pending'"
                            @click="cancelOrder(order.id)"
                            class="px-4 py-1.5 text-sm bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                        Cancel Order
                    </button>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-16 bg-white rounded-lg shadow-sm">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <h3 class="text-xl font-medium text-gray-900">No orders found</h3>
            <p class="text-gray-500 mt-1">Start shopping to see your orders here</p>
            <Link href="/" class="inline-block mt-4 px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors">
                Start Shopping →
            </Link>
        </div>
    </CustomerLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';

const props = defineProps({
    orders: {
        type: Array,
        default: () => []
    },
    filters: {
        type: Object,
        default: () => ({})
    }
});

const filterStatus = ref(props.filters?.status || 'all');

const statuses = [
    { value: 'all', label: 'All Orders', count: props.orders?.length || 0 },
    { value: 'pending', label: 'Pending', count: props.orders?.filter(o => o.status === 'pending').length || 0 },
    { value: 'processing', label: 'Processing', count: props.orders?.filter(o => o.status === 'processing').length || 0 },
    { value: 'shipped', label: 'Shipped', count: props.orders?.filter(o => o.status === 'shipped').length || 0 },
    { value: 'delivered', label: 'Delivered', count: props.orders?.filter(o => o.status === 'delivered').length || 0 },
    { value: 'cancelled', label: 'Cancelled', count: props.orders?.filter(o => o.status === 'cancelled').length || 0 },
];

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

const cancelOrder = (id) => {
    if (confirm('Are you sure you want to cancel this order?')) {
        console.log('Cancel order:', id);
    }
};
</script>
