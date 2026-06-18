<template>
    <AdminLayout page-title="Sales Report">
        <!-- Filters -->
        <div class="flex flex-wrap items-center gap-4 mb-6">
            <select v-model="reportPeriod" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="quarter">This Quarter</option>
                <option value="year">This Year</option>
                <option value="custom">Custom</option>
            </select>

            <div v-if="reportPeriod === 'custom'" class="flex items-center gap-2">
                <input type="date" v-model="dateFrom" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                <span class="text-gray-400">to</span>
                <input type="date" v-model="dateTo" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
            </div>

            <button @click="generateReport" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors">
                Generate Report
            </button>
            <button @click="exportReport" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                Export CSV
            </button>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <p class="text-sm text-gray-500">Total Sales</p>
                <p class="text-2xl font-bold text-gray-900">Rs. {{ formatPrice(report.total_sales || 0) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <p class="text-sm text-gray-500">Total Orders</p>
                <p class="text-2xl font-bold text-gray-900">{{ report.total_orders || 0 }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <p class="text-sm text-gray-500">Average Order Value</p>
                <p class="text-2xl font-bold text-gray-900">Rs. {{ formatPrice(report.average_order || 0) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <p class="text-sm text-gray-500">Total Customers</p>
                <p class="text-2xl font-bold text-gray-900">{{ report.total_customers || 0 }}</p>
            </div>
        </div>

        <!-- Chart Placeholder -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h4 class="font-semibold text-gray-900 mb-4">Sales Overview</h4>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                <p class="text-gray-400">Sales Chart (Coming Soon)</p>
            </div>
        </div>

        <!-- Sales Data Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sales</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Average</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customers</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="item in report.data || []" :key="item.date" class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-600">{{ item.date }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ item.orders }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">Rs. {{ formatPrice(item.sales) }}</td>
                            <td class="px-4 py-3 text-gray-600">Rs. {{ formatPrice(item.average) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ item.customers }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    report: {
        type: Object,
        default: () => ({
            total_sales: 0,
            total_orders: 0,
            average_order: 0,
            total_customers: 0,
            data: []
        })
    }
});

const reportPeriod = ref('month');
const dateFrom = ref('');
const dateTo = ref('');

const formatPrice = (amount) => {
    return new Intl.NumberFormat('en-PK').format(amount || 0);
};

const generateReport = () => {
    console.log('Generate report');
};

const exportReport = () => {
    console.log('Export report');
};
</script>
