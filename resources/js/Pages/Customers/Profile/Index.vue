<template>
    <CustomerLayout page-title="My Profile" page-subtitle="Manage your account information">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Profile Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <!-- Avatar -->
                    <div class="text-center mb-6">
                        <div class="relative inline-block">
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-teal-500 to-teal-700 flex items-center justify-center mx-auto">
                                <span class="text-3xl font-bold text-white">{{ userInitials }}</span>
                            </div>
                            <button
                                @click="openAvatarUpload"
                                class="absolute bottom-0 right-0 p-1.5 bg-teal-600 rounded-full text-white hover:bg-teal-700 transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mt-3">{{ user.name }}</h3>
                        <p class="text-sm text-gray-500">{{ user.email }}</p>
                        <p class="text-sm text-gray-500">{{ user.phone || 'No phone number' }}</p>
                    </div>

                    <!-- Quick Stats -->
                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Member Since</span>
                            <span class="font-medium text-gray-700">{{ formatDate(user.created_at) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Total Orders</span>
                            <span class="font-medium text-gray-700">{{ stats.total_orders || 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Total Spent</span>
                            <span class="font-medium text-gray-700">Rs. {{ formatPrice(stats.total_spent || 0) }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 space-y-2">
                        <Link href="/profile/edit" class="block w-full text-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors">
                            Edit Profile
                        </Link>
                        <Link href="/profile/change-password" class="block w-full text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                            Change Password
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Right: Recent Activity -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Recent Orders -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-gray-900">Recent Orders</h4>
                        <Link href="/orders" class="text-sm text-teal-600 hover:text-teal-700 font-medium hover:underline">
                            View All →
                        </Link>
                    </div>

                    <div v-if="recentOrders && recentOrders.length > 0" class="divide-y divide-gray-100">
                        <div v-for="order in recentOrders" :key="order.id" class="py-3 first:pt-0 last:pb-0">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">#{{ order.order_number }}</p>
                                    <p class="text-sm text-gray-500">{{ formatDate(order.created_at) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900">Rs. {{ formatPrice(order.total_amount) }}</p>
                                    <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full"
                                        :class="getStatusClass(order.status)">
                                        {{ getStatusLabel(order.status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center py-6 text-gray-500">
                        <p>No orders yet</p>
                        <Link href="/" class="text-sm text-teal-600 hover:underline mt-1 inline-block">
                            Start Shopping →
                        </Link>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="grid grid-cols-2 gap-4">
                    <Link href="/addresses" class="bg-white rounded-lg shadow-sm p-4 text-center hover:shadow-md transition-shadow">
                        <svg class="w-8 h-8 text-teal-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-sm font-medium text-gray-700">Manage Addresses</p>
                    </Link>
                    <Link href="/wishlist" class="bg-white rounded-lg shadow-sm p-4 text-center hover:shadow-md transition-shadow">
                        <svg class="w-8 h-8 text-teal-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <p class="text-sm font-medium text-gray-700">Wishlist</p>
                    </Link>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    stats: {
        type: Object,
        default: () => ({
            total_orders: 0,
            total_spent: 0,
            wishlist_count: 0
        })
    },
    recentOrders: {
        type: Array,
        default: () => []
    }
});

const userInitials = computed(() => {
    if (!props.user.name) return '';
    return props.user.name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
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

const openAvatarUpload = () => {
    // Will implement avatar upload later
};
</script>
