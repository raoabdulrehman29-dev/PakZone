<template>
    <AdminLayout page-title="Manage Brands">
        <!-- Header Actions -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search brands..."
                        class="w-64 px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm"
                        @input="searchBrands"
                    />
                    <svg class="absolute right-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <select v-model="statusFilter" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <Link href="/admin/brands/create" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Brand
            </Link>
        </div>

        <!-- Brands Grid -->
        <div v-if="brands && brands.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div v-for="brand in brands" :key="brand.id" class="bg-white rounded-lg shadow-sm p-6 text-center hover:shadow-md transition-shadow">
                <!-- Logo -->
                <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-3">
                    <img v-if="brand.logo" :src="brand.logo" :alt="brand.name" class="w-12 h-12 object-contain" />
                    <span v-else class="text-2xl font-bold text-gray-400">{{ brand.name.charAt(0) }}</span>
                </div>

                <h4 class="font-semibold text-gray-800">{{ brand.name }}</h4>
                <p class="text-xs text-gray-500 mt-1">{{ brand.products_count || 0 }} products</p>

                <div class="mt-3 flex items-center justify-center gap-2">
                    <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full"
                        :class="brand.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                        {{ brand.is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <!-- Actions -->
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-center gap-3">
                    <Link :href="`/admin/brands/${brand.id}/edit`" class="text-teal-600 hover:text-teal-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </Link>
                    <button @click="toggleBrandStatus(brand.id, brand.is_active)" class="text-yellow-600 hover:text-yellow-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                    <button @click="deleteBrand(brand.id)" class="text-red-500 hover:text-red-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div v-else class="text-center py-16 bg-white rounded-lg shadow-sm">
            <p class="text-gray-500">No brands found</p>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    brands: {
        type: Array,
        default: () => []
    }
});

const search = ref('');
const statusFilter = ref('');

const searchBrands = () => {
    // Will implement later
};

const toggleBrandStatus = (id, currentStatus) => {
    if (confirm(`Are you sure you want to ${currentStatus ? 'deactivate' : 'activate'} this brand?`)) {
        console.log('Toggle status:', id);
    }
};

const deleteBrand = (id) => {
    if (confirm('Are you sure you want to delete this brand?')) {
        console.log('Delete brand:', id);
    }
};
</script>
