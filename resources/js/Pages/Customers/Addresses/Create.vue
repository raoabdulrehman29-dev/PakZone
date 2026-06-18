<template>
    <CustomersLayout page-title="Add Address" page-subtitle="Add a new address">
        <div class="max-w-2xl">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            required
                            placeholder="John Doe"
                        />
                        <p v-if="errors.name" class="text-sm text-red-600 mt-1">{{ errors.name }}</p>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input
                            v-model="form.phone"
                            type="tel"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            required
                            placeholder="03XX-XXXXXXX"
                        />
                        <p v-if="errors.phone" class="text-sm text-red-600 mt-1">{{ errors.phone }}</p>
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <input
                            v-model="form.address"
                            type="text"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            required
                            placeholder="Street address"
                        />
                        <p v-if="errors.address" class="text-sm text-red-600 mt-1">{{ errors.address }}</p>
                    </div>

                    <!-- City & State -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input
                                v-model="form.city"
                                type="text"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                                required
                                placeholder="Karachi"
                            />
                            <p v-if="errors.city" class="text-sm text-red-600 mt-1">{{ errors.city }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                            <input
                                v-model="form.state"
                                type="text"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                                placeholder="Sindh"
                            />
                        </div>
                    </div>

                    <!-- Country & Pincode -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <select
                                v-model="form.country"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            >
                                <option value="Pakistan">Pakistan</option>
                                <option value="India">India</option>
                                <option value="UAE">UAE</option>
                                <option value="UK">UK</option>
                                <option value="USA">USA</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                            <input
                                v-model="form.pincode"
                                type="text"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                                required
                                placeholder="12345"
                            />
                            <p v-if="errors.pincode" class="text-sm text-red-600 mt-1">{{ errors.pincode }}</p>
                        </div>
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address Type</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" v-model="form.type" value="shipping" class="text-teal-600" />
                                Shipping
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" v-model="form.type" value="billing" class="text-teal-600" />
                                Billing
                            </label>
                        </div>
                    </div>

                    <!-- Default Address -->
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" v-model="form.is_default" class="rounded text-teal-600" />
                            Set as default address
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50"
                        >
                            <span v-if="!form.processing">Save Address</span>
                            <span v-else>Saving...</span>
                        </button>
                        <Link href="/addresses" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </CustomersLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import CustomersLayout from '@/Layouts/CustomerLayout.vue';

const props = defineProps({
    errors: Object
});

const form = useForm({
    name: '',
    phone: '',
    address: '',
    city: '',
    state: '',
    country: 'Pakistan',
    pincode: '',
    type: 'shipping',
    is_default: false,
});

const submit = () => {
    form.post('/addresses');
};
</script>
