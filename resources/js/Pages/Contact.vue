<template>
    <CustomerLayout>
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Contact Us</h1>
            <p class="text-sm text-gray-500 mt-1">We'd love to hear from you</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Information -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Get in Touch</h3>

                    <!-- Phone -->
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-10 h-10 bg-teal-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Phone</p>
                            <a href="tel:+923191087089" class="text-sm text-gray-500 hover:text-teal-600 transition-colors">
                                +92 319 1087089
                            </a>
                            <br>
                            <a
                                href="https://wa.me/923191087089"
                                target="_blank"
                                class="inline-flex items-center gap-1 mt-1 text-sm text-green-600 hover:text-green-700 transition-colors"
                            >
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                WhatsApp
                            </a>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-10 h-10 bg-teal-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Email</p>
                            <a href="mailto:raoabdulrehman29@gmail.com" class="text-sm text-gray-500 hover:text-teal-600 transition-colors">
                                raoabdulrehman29@gmail.com
                            </a>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-teal-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Address</p>
                            <p class="text-sm text-gray-500">Pakistan</p>
                        </div>
                    </div>
                </div>

                <!-- Working Hours -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Working Hours</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Monday - Friday</span>
                            <span class="text-gray-700">9:00 AM - 6:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Saturday</span>
                            <span class="text-gray-700">10:00 AM - 4:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Sunday</span>
                            <span class="text-gray-400">Closed</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Send us a Message</h3>

                    <form @submit.prevent="submitForm" class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200"
                                    placeholder="John Doe"
                                    required
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input
                                    v-model="form.email"
                                    type="email"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200"
                                    placeholder="you@example.com"
                                    required
                                />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <input
                                v-model="form.subject"
                                type="text"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200"
                                placeholder="How can we help?"
                                required
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea
                                v-model="form.message"
                                rows="5"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 resize-none"
                                placeholder="Write your message here..."
                                required
                            ></textarea>
                        </div>

                        <button
                            type="submit"
                            :disabled="submitting"
                            class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-teal-600 to-teal-500 hover:from-teal-700 hover:to-teal-600 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg disabled:opacity-70 disabled:cursor-not-allowed"
                        >
                            <span v-if="!submitting">Send Message</span>
                            <span v-else class="flex items-center justify-center gap-2">
                                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Sending...
                            </span>
                        </button>
                    </form>

                    <!-- Success Message -->
                    <div v-if="success" class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-green-600">Your message has been sent successfully! We'll get back to you soon.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>

<script setup>
import { ref } from 'vue';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';

const form = ref({
    name: '',
    email: '',
    subject: '',
    message: ''
});

const submitting = ref(false);
const success = ref(false);

const submitForm = async () => {
    submitting.value = true;
    success.value = false;

    // Simulate sending
    await new Promise(resolve => setTimeout(resolve, 1500));

    // Here you would send the data to your backend
    console.log('Form submitted:', form.value);

    // Reset form
    form.value = {
        name: '',
        email: '',
        subject: '',
        message: ''
    };

    submitting.value = false;
    success.value = true;

    // Hide success message after 5 seconds
    setTimeout(() => {
        success.value = false;
    }, 5000);
};
</script>
