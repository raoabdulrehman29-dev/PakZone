<template>
    <AdminLayout page-title="Add Coupon">
        <div class="max-w-2xl">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Code -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Coupon Code *</label>
                        <div class="flex gap-2">
                            <input
                                v-model="form.code"
                                type="text"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all uppercase"
                                required
                                placeholder="SUMMER20"
                            />
                            <button type="button" @click="generateCode" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                                Generate
                            </button>
                        </div>
                        <p v-if="errors.code" class="text-sm text-red-600 mt-1">{{ errors.code }}</p>
                    </div>

                    <!-- Type & Value -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                            <select v-model="form.type" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                                <option value="percentage">Percentage</option>
                                <option value="fixed">Fixed Amount</option>
                                <option value="free_shipping">Free Shipping</option>
                            </select>
                            <p v-if="errors.type" class="text-sm text-red-600 mt-1">{{ errors.type }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Value *</label>
                            <input
                                v-model="form.value"
                                type="number"
                                step="0.01"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                                required
                                :placeholder="form.type === 'percentage' ? '20' : '500'"
                            />
                            <p v-if="errors.value" class="text-sm text-red-600 mt-1">{{ errors.value }}</p>
                        </div>
                    </div>

                    <!-- Min Order & Max Discount -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Order Amount</label>
                            <input
                                v-model="form.min_order_amount"
                                type="number"
                                step="0.01"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                                placeholder="0"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Discount</label>
                            <input
                                v-model="form.max_discount"
                                type="number"
                                step="0.01"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                                placeholder="Unlimited"
                            />
                        </div>
                    </div>

                    <!-- Usage Limits -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Usage Limit (Total)</label>
                            <input
                                v-model="form.usage_limit"
                                type="number"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                                placeholder="Unlimited"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Per User Limit</label>
                            <input
                                v-model="form.per_user_limit"
                                type="number"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                                placeholder="1"
                            />
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Date *</label>
                            <input
                                v-model="form.start_date"
                                type="datetime-local"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                                required
                            />
                            <p v-if="errors.start_date" class="text-sm text-red-600 mt-1">{{ errors.start_date }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End Date *</label>
                            <input
                                v-model="form.end_date"
                                type="datetime-local"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                                required
                            />
                            <p v-if="errors.end_date" class="text-sm text-red-600 mt-1">{{ errors.end_date }}</p>
                        </div>
                    </div>

                    <!-- Applies To -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Applies To</label>
                        <select v-model="form.applies_to" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                            <option value="all">All Products</option>
                            <option value="products">Specific Products</option>
                            <option value="categories">Specific Categories</option>
                        </select>
                    </div>

                    <!-- Active Status -->
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" v-model="form.is_active" class="rounded text-teal-600" />
                            Active
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50"
                        >
                            <span v-if="!form.processing">Save Coupon</span>
                            <span v-else>Saving...</span>
                        </button>
                        <Link href="/admin/coupons" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    errors: Object
});

const form = useForm({
    code: '',
    type: 'percentage',
    value: '',
    min_order_amount: 0,
    max_discount: '',
    usage_limit: '',
    per_user_limit: 1,
    start_date: '',
    end_date: '',
    applies_to: 'all',
    is_active: true
});

const generateCode = () => {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    for (let i = 0; i < 8; i++) {
        code += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    form.code = code;
};

const submit = () => {
    form.post('/admin/coupons');
};
</script>
