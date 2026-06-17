<template>
    <CustomerLayout>
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">
                Welcome back, {{ user.name }}! 👋
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Here's what's happening with your orders and account.
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-teal-500">
                <p class="text-sm text-gray-500">Total Orders</p>
                <p class="text-2xl font-bold text-gray-900">{{ stats.total_orders || 0 }}</p>
                <p class="text-xs text-gray-400 mt-1">Lifetime orders</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-orange-500">
                <p class="text-sm text-gray-500">Pending Orders</p>
                <p class="text-2xl font-bold text-gray-900">{{ stats.pending_orders || 0 }}</p>
                <p class="text-xs text-gray-400 mt-1">Awaiting processing</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
                <p class="text-sm text-gray-500">Total Spent</p>
                <p class="text-2xl font-bold text-gray-900">Rs. {{ formatPrice(stats.total_spent || 0) }}</p>
                <p class="text-xs text-gray-400 mt-1">Lifetime spending</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-purple-500">
                <p class="text-sm text-gray-500">Wishlist Items</p>
                <p class="text-2xl font-bold text-gray-900">{{ stats.wishlist_count || 0 }}</p>
                <p class="text-xs text-gray-400 mt-1">Saved products</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-8">
            <a href="/orders" class="bg-white rounded-lg shadow-sm p-4 text-center hover:shadow-md transition-shadow">
                <svg class="w-8 h-8 text-teal-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span class="text-sm font-medium text-gray-700">My Orders</span>
            </a>
            <a href="/profile" class="bg-white rounded-lg shadow-sm p-4 text-center hover:shadow-md transition-shadow">
                <svg class="w-8 h-8 text-teal-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="text-sm font-medium text-gray-700">My Profile</span>
            </a>
            <a href="/wishlist" class="bg-white rounded-lg shadow-sm p-4 text-center hover:shadow-md transition-shadow">
                <svg class="w-8 h-8 text-teal-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <span class="text-sm font-medium text-gray-700">Wishlist</span>
            </a>
            <a href="/addresses" class="bg-white rounded-lg shadow-sm p-4 text-center hover:shadow-md transition-shadow">
                <svg class="w-8 h-8 text-teal-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-sm font-medium text-gray-700">Addresses</span>
            </a>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
                <a href="/orders" class="text-sm text-teal-600 hover:text-teal-700 font-medium hover:underline">
                    View All →
                </a>
            </div>

            <div v-if="recentOrders && recentOrders.length > 0" class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="order in recentOrders" :key="order.id" class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">#{{ order.order_number }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ formatDate(order.created_at) }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">Rs. {{ formatPrice(order.total_amount) }}</td>
                            <td class="px-4 py-3">
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                    :class="getStatusClass(order.status)"
                                >
                                    {{ order.status }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <a :href="`/orders/${order.id}`" class="text-teal-600 hover:text-teal-700 font-medium hover:underline">
                                    View
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <p class="text-gray-500">No orders yet</p>
                <a href="/" class="text-sm text-teal-600 hover:text-teal-700 font-medium hover:underline">
                    Start Shopping →
                </a>
            </div>
        </div>

        <!-- Quick Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Saved Addresses -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Saved Addresses</h3>
                    <a href="/addresses" class="text-sm text-teal-600 hover:text-teal-700 font-medium hover:underline">
                        Manage →
                    </a>
                </div>
                <div v-if="addresses && addresses.length > 0" class="space-y-3">
                    <div v-for="address in addresses.slice(0, 2)" :key="address.id" class="text-sm text-gray-600 border-b border-gray-100 pb-3">
                        <p class="font-medium text-gray-800">{{ address.name }}</p>
                        <p>{{ address.address }}</p>
                        <p>{{ address.city }}, {{ address.state }}</p>
                        <span v-if="address.is_default" class="inline-block mt-1 text-xs text-teal-600 bg-teal-50 px-2 py-0.5 rounded">Default</span>
                    </div>
                </div>
                <p v-else class="text-sm text-gray-500">No saved addresses</p>
            </div>

            <!-- Account Info -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Info</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Name</span>
                        <span class="font-medium text-gray-800">{{ user.name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Email</span>
                        <span class="font-medium text-gray-800">{{ user.email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Phone</span>
                        <span class="font-medium text-gray-800">{{ user.phone || 'Not set' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Member Since</span>
                        <span class="font-medium text-gray-800">{{ formatDate(user.created_at) }}</span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200 flex gap-2">
                    <a href="/profile" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                        Edit Profile
                    </a>
                    <a href="/profile/change-password" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                        Change Password
                    </a>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>

<script setup>
import { computed } from 'vue';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';

// ============================================
// PROPS
// ============================================
const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    stats: {
        type: Object,
        default: () => ({
            total_orders: 0,
            pending_orders: 0,
            total_spent: 0,
            wishlist_count: 0
        })
    },
    recentOrders: {
        type: Array,
        default: () => []
    },
    addresses: {
        type: Array,
        default: () => []
    }
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
