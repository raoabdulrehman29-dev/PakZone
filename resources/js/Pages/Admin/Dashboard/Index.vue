<template>
    <AdminLayout page-title="Dashboard">
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-900">Rs. {{ formatPrice(stats.revenue || 0) }}</p>
                        <p class="text-xs text-green-600 mt-1">↑ 12% from last month</p>
                    </div>
                    <div class="p-3 bg-teal-50 rounded-lg">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-900">{{ stats.orders || 0 }}</p>
                        <p class="text-xs text-green-600 mt-1">↑ 8% from last month</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Products</p>
                        <p class="text-2xl font-bold text-gray-900">{{ stats.products || 0 }}</p>
                        <p class="text-xs text-green-600 mt-1">↑ 5% from last month</p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Users</p>
                        <p class="text-2xl font-bold text-gray-900">{{ stats.users || 0 }}</p>
                        <p class="text-xs text-green-600 mt-1">↑ 15% from last month</p>
                    </div>
                    <div class="p-3 bg-orange-50 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders & Low Stock -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-gray-900">Recent Orders</h4>
                    <Link href="/admin/orders" class="text-sm text-teal-600 hover:text-teal-700 hover:underline">
                        View All →
                    </Link>
                </div>
                <div v-if="recentOrders && recentOrders.length > 0" class="divide-y divide-gray-100">
                    <div v-for="order in recentOrders" :key="order.id" class="py-3 first:pt-0 last:pb-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">#{{ order.order_number }}</p>
                                <p class="text-sm text-gray-500">{{ order.user?.name || 'Guest' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">Rs. {{ formatPrice(order.total_amount) }}</p>
                                <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full"
                                    :class="getStatusClass(order.status)">
                                    {{ getStatusLabel(order.status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center py-6 text-gray-500">
                    <p>No recent orders</p>
                </div>
            </div>

            <!-- Low Stock Products -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-gray-900">Low Stock Products</h4>
                    <Link href="/admin/products" class="text-sm text-teal-600 hover:text-teal-700 hover:underline">
                        View All →
                    </Link>
                </div>
                <div v-if="lowStockProducts && lowStockProducts.length > 0" class="divide-y divide-gray-100">
                    <div v-for="product in lowStockProducts" :key="product.id" class="py-3 first:pt-0 last:pb-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ product.name }}</p>
                                <p class="text-sm text-gray-500">SKU: {{ product.sku }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ product.stock }} left
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center py-6 text-green-600">
                    <p>✓ All products are well-stocked</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            revenue: 0,
            orders: 0,
            products: 0,
            users: 0
        })
    },
    recentOrders: {
        type: Array,
        default: () => []
    },
    lowStockProducts: {
        type: Array,
        default: () => []
    }
});

const formatPrice = (amount) => {
    return new Intl.NumberFormat('en-PK').format(amount || 0);
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
