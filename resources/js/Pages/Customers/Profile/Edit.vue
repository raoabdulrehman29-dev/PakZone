<template>
    <CustomerLayout page-title="Edit Profile" page-subtitle="Update your account information">
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
                        />
                        <p v-if="errors.name" class="text-sm text-red-600 mt-1">{{ errors.name }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input
                            v-model="form.email"
                            type="email"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            required
                        />
                        <p v-if="errors.email" class="text-sm text-red-600 mt-1">{{ errors.email }}</p>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input
                            v-model="form.phone"
                            type="tel"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            placeholder="03XX-XXXXXXX"
                        />
                        <p v-if="errors.phone" class="text-sm text-red-600 mt-1">{{ errors.phone }}</p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50"
                        >
                            <span v-if="!form.processing">Save Changes</span>
                            <span v-else>Saving...</span>
                        </button>
                        <Link href="/profile" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </CustomerLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    errors: Object
});

const form = useForm({
    name: props.user.name || '',
    email: props.user.email || '',
    phone: props.user.phone || '',
});

const submit = () => {
    form.put('/profile');
};
</script>
