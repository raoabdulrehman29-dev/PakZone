<template>
    <div class="min-h-screen flex flex-col bg-gray-50">
        <!-- Navbar -->
        <Navbar
            :user="$page.props.auth.user"
            :cart-count="$page.props.cart_count || 0"
            :categories="$page.props.categories || []"
        />

        <!-- Page Header (Optional) -->
        <div v-if="pageTitle" class="bg-white border-b border-gray-200">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <h1 class="text-2xl font-bold text-gray-900">{{ pageTitle }}</h1>
                <p v-if="pageSubtitle" class="text-sm text-gray-500 mt-1">{{ pageSubtitle }}</p>
            </div>
        </div>

        <!-- Main Content - Center Aligned with proper padding -->
        <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-12">
            <slot />
        </main>

        <!-- Footer -->
        <Footer />
    </div>
</template>

<script setup>
import Navbar from '@/Components/Common/Navbar.vue';
import Footer from '@/Components/Common/Footer.vue';

defineProps({
    pageTitle: {
        type: String,
        default: ''
    },
    pageSubtitle: {
        type: String,
        default: ''
    }
});
</script>
