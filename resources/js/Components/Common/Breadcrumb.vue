<template>
    <nav class="text-sm text-gray-500 mb-4 overflow-x-auto" aria-label="Breadcrumb">
        <ol class="flex items-center gap-2 flex-nowrap">
            <!-- Home -->
            <li>
                <a href="/" class="hover:text-teal-600 transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Home
                </a>
            </li>

            <li v-for="(item, index) in items" :key="index" class="flex items-center gap-2">
                <span class="text-gray-300">/</span>

                <!-- Last item (current page) -->
                <span v-if="index === items.length - 1" class="text-gray-700 font-medium">
                    {{ item.label }}
                </span>

                <!-- Clickable items -->
                <a v-else :href="item.url" class="hover:text-teal-600 transition-colors">
                    {{ item.label }}
                </a>
            </li>
        </ol>
    </nav>
</template>

<script setup>
defineProps({
    items: {
        type: Array,
        required: true,
        validator: (value) => {
            return value.every(item => item.label && item.url);
        }
    }
});
</script>
