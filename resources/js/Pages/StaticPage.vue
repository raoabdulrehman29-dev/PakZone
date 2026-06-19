<template>
    <CustomerLayout>
        <section class="bg-white rounded-lg shadow-sm p-6 sm:p-8">
            <h1 class="text-2xl font-bold text-gray-900">{{ title }}</h1>
            <p class="mt-3 text-gray-600 max-w-3xl">{{ description }}</p>
            <Link href="/products" class="inline-flex mt-6 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors">
                Browse Products
            </Link>
        </section>
    </CustomerLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';

defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        default: '',
    },
});
</script>
