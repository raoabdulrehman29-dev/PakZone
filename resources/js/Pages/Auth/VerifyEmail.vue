<template>
    <GuestLayout page-title="Verify Your Email" page-subtitle="Please confirm your email address">
        <div class="space-y-4">
            <!-- Info Message -->
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm text-blue-700">
                            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            <div v-if="verificationSent" class="p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                A new verification link has been sent to your email address.
            </div>

            <!-- Resend Button -->
            <button
                @click="resendVerification"
                :disabled="form.processing"
                class="w-full bg-gradient-to-r from-teal-600 to-teal-500 hover:from-teal-700 hover:to-teal-600 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-lg shadow-teal-500/30 hover:shadow-teal-500/40 disabled:opacity-70 disabled:cursor-not-allowed"
            >
                <span v-if="!form.processing">Resend Verification Email</span>
                <span v-else class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Sending...
                </span>
            </button>

            <!-- Logout -->
            <div class="text-center">
                <form @submit.prevent="logout" class="inline">
                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 transition-colors hover:underline">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    status: String,
    verificationSent: Boolean,
});

const form = useForm({});

const resendVerification = () => {
    form.post('/email/verification-notification');
};

const logout = () => {
    form.post('/logout');
};
</script>
