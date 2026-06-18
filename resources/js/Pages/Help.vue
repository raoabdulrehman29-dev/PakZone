<template>
    <CustomerLayout>
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Frequently Asked Questions</h1>
            <p class="text-sm text-gray-500 mb-6">Find answers to common questions</p>

            <div class="space-y-4">
                <div v-for="(faq, index) in faqs" :key="index" class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <button
                        @click="toggleFaq(index)"
                        class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors"
                    >
                        <span class="font-medium text-gray-800 text-left">{{ faq.question }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': openFaqs.includes(index) }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div v-if="openFaqs.includes(index)" class="px-6 pb-4">
                        <p class="text-gray-600">{{ faq.answer }}</p>
                    </div>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>

<script setup>
import { ref } from 'vue';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';

const openFaqs = ref([]);

const faqs = [
    {
        question: 'How do I place an order?',
        answer: 'Simply browse products, add items to your cart, and proceed to checkout. Fill in your delivery details and payment method to complete your order.'
    },
    {
        question: 'What payment methods do you accept?',
        answer: 'We accept Cash on Delivery, Credit/Debit Cards, JazzCash, EasyPaisa, and Bank Transfers.'
    },
    {
        question: 'How long does delivery take?',
        answer: 'Standard delivery takes 3-5 business days. Express delivery takes 1-2 business days. Same-day delivery is available in select cities.'
    },
    {
        question: 'Can I cancel my order?',
        answer: 'Yes, you can cancel your order within 24 hours of placing it. Go to "My Orders" and click "Cancel Order".'
    },
    {
        question: 'How do I track my order?',
        answer: 'Log in to your account, go to "My Orders", and click "Track Order" on your desired order.'
    },
    {
        question: 'Do you offer returns?',
        answer: 'Yes, we offer a 30-day return policy. Items must be in original condition with all packaging intact.'
    },
];

const toggleFaq = (index) => {
    const position = openFaqs.value.indexOf(index);
    if (position > -1) {
        openFaqs.value.splice(position, 1);
    } else {
        openFaqs.value.push(index);
    }
};
</script>
