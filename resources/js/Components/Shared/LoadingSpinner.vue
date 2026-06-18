<template>
    <div class="flex flex-col items-center justify-center py-12" :class="containerClass">
        <div class="relative">
            <!-- Outer ring -->
            <div class="w-12 h-12 border-4 border-gray-200 rounded-full"></div>

            <!-- Spinning ring -->
            <div class="absolute inset-0 w-12 h-12 border-4 border-teal-600 rounded-full border-t-transparent animate-spin"></div>
        </div>

        <p v-if="message" class="mt-4 text-sm text-gray-500">{{ message }}</p>
    </div>
</template>

<script setup>
defineProps({
    message: {
        type: String,
        default: 'Loading...'
    },
    containerClass: {
        type: String,
        default: ''
    }
});
</script>
