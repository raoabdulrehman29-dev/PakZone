<template>
    <AdminLayout page-title="Manage Coupons">
        <!-- Header Actions -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <!-- Search -->
                <div class="relative">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search coupons..."
                        class="w-64 px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm"
                        @input="searchCoupons"
                    />
                    <svg class="absolute right-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <!-- Type Filter -->
                <select v-model="typeFilter" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">All Types</option>
                    <option value="fixed">Fixed</option>
                    <option value="percentage">Percentage</option>
                    <option value="free_shipping">Free Shipping</option>
                </select>

                <!-- Status Filter -->
                <select v-model="statusFilter" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <Link href="/admin/coupons/create" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Coupon
            </Link>
        </div>

        <!-- Coupons Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Used</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valid</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="coupon in coupons" :key="coupon.id" class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <span class="font-mono font-semibold text-teal-600">{{ coupon.code }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                    :class="{
                                        'bg-blue-100 text-blue-800': coupon.type === 'fixed',
                                        'bg-purple-100 text-purple-800': coupon.type === 'percentage',
                                        'bg-green-100 text-green-800': coupon.type === 'free_shipping'
                                    }">
                                    {{ coupon.type }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-900">
                                <span v-if="coupon.type === 'fixed'">Rs. {{ formatPrice(coupon.value) }}</span>
                                <span v-else-if="coupon.type === 'percentage'">{{ coupon.value }}%</span>
                                <span v-else>Free Shipping</span>
                            </td>
                            <td class="px-4 py-3">
                                {{ coupon.used_count || 0 }} / {{ coupon.usage_limit || '∞' }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                <div>{{ formatDate(coupon.start_date) }}</div>
                                <div class="text-xs">to {{ formatDate(coupon.end_date) }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                    :class="coupon.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                                    {{ coupon.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <Link :href="`/admin/coupons/${coupon.id}/edit`" class="text-teal-600 hover:text-teal-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </Link>
                                    <button @click="toggleCouponStatus(coupon.id, coupon.is_active)" class="text-yellow-600 hover:text-yellow-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                    <button @click="deleteCoupon(coupon.id)" class="text-red-500 hover:text-red-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <Pagination
                :current-page="pagination.current_page"
                :total-pages="pagination.last_page"
                :on-page-change="handlePageChange"
            />
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Common/Pagination.vue';

const props = defineProps({
    coupons: {
        type: Array,
        default: () => []
    },
    pagination: {
        type: Object,
        default: () => ({ current_page: 1, last_page: 1 })
    }
});

const search = ref('');
const typeFilter = ref('');
const statusFilter = ref('');

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

const searchCoupons = () => {
    // Will implement later
};

const handlePageChange = (page) => {
    // Will implement later
};

const toggleCouponStatus = (id, currentStatus) => {
    if (confirm(`Are you sure you want to ${currentStatus ? 'deactivate' : 'activate'} this coupon?`)) {
        console.log('Toggle status:', id);
    }
};

const deleteCoupon = (id) => {
    if (confirm('Are you sure you want to delete this coupon?')) {
        console.log('Delete coupon:', id);
    }
};
</script>
