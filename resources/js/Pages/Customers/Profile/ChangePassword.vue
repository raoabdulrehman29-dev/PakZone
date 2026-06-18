<template>
    <CustomerLayout page-title="Change Password" page-subtitle="Update your password">
        <div class="max-w-2xl">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Current Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                        <input
                            v-model="form.current_password"
                            :type="showCurrentPassword ? 'text' : 'password'"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            required
                        />
                        <p v-if="errors.current_password" class="text-sm text-red-600 mt-1">{{ errors.current_password }}</p>
                    </div>

                    <!-- New Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input
                            v-model="form.password"
                            :type="showNewPassword ? 'text' : 'password'"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            placeholder="Min 8 characters"
                            required
                        />
                        <p v-if="errors.password" class="text-sm text-red-600 mt-1">{{ errors.password }}</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input
                            v-model="form.password_confirmation"
                            :type="showConfirmPassword ? 'text' : 'password'"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            required
                        />
                    </div>

                    <!-- Show Password Toggle -->
                    <div class="flex items-center gap-4 text-sm">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" v-model="showCurrentPassword" class="rounded text-teal-600" />
                            Show Current
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" v-model="showNewPassword" class="rounded text-teal-600" />
                            Show New
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" v-model="showConfirmPassword" class="rounded text-teal-600" />
                            Show Confirm
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50"
                        >
                            <span v-if="!form.processing">Update Password</span>
                            <span v-else>Updating...</span>
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
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';

const props = defineProps({
    errors: Object
});

const showCurrentPassword = ref(false);
const showNewPassword = ref(false);
const showConfirmPassword = ref(false);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put('/profile/password');
};
</script>
