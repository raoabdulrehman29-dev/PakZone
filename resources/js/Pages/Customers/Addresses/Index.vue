<template>
    <CustomersLayout page-title="My Addresses" page-subtitle="Manage your shipping and billing addresses">
        <!-- Add Address Button -->
        <div class="mb-6">
            <Link href="/addresses/create" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Address
            </Link>
        </div>

        <!-- Addresses Grid -->
        <div v-if="addresses && addresses.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div v-for="address in addresses" :key="address.id" class="bg-white rounded-lg shadow-sm p-6 relative">
                <!-- Default Badge -->
                <span v-if="address.is_default" class="absolute top-3 right-3 px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                    Default
                </span>

                <div class="space-y-1 text-sm">
                    <p class="font-semibold text-gray-800">{{ address.name }}</p>
                    <p class="text-gray-600">{{ address.address }}</p>
                    <p class="text-gray-600">{{ address.city }}, {{ address.state }}</p>
                    <p class="text-gray-600">{{ address.country }} - {{ address.pincode }}</p>
                    <p class="text-gray-600">Phone: {{ address.phone }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ address.type || 'Shipping' }}</p>
                </div>

                <!-- Actions -->
                <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap gap-2">
                    <Link :href="`/addresses/${address.id}/edit`" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                        Edit
                    </Link>
                    <button
                        v-if="!address.is_default"
                        @click="setDefault(address.id)"
                        class="px-3 py-1 text-sm bg-teal-50 hover:bg-teal-100 text-teal-600 rounded-lg transition-colors"
                    >
                        Set as Default
                    </button>
                    <button
                        @click="deleteAddress(address.id)"
                        class="px-3 py-1 text-sm bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-16 bg-white rounded-lg shadow-sm">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <h3 class="text-xl font-medium text-gray-900">No addresses saved</h3>
            <p class="text-gray-500 mt-1">Add your first address for faster checkout</p>
            <Link href="/addresses/create" class="inline-block mt-4 px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors">
                Add Address →
            </Link>
        </div>
    </CustomersLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import CustomersLayout from '@/Layouts/CustomerLayout.vue';

const props = defineProps({
    addresses: {
        type: Array,
        default: () => []
    }
});

const setDefault = (id) => {
    console.log('Set default address:', id);
};

const deleteAddress = (id) => {
    if (confirm('Are you sure you want to delete this address?')) {
        console.log('Delete address:', id);
    }
};
</script>
