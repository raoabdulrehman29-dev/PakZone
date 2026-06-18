<template>
    <div v-if="totalPages > 1" class="flex items-center justify-center gap-1 mt-8">
        <!-- Previous Button -->
        <button
            @click="goToPage(currentPage - 1)"
            :disabled="currentPage <= 1"
            class="px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <!-- Page Numbers -->
        <button
            v-for="page in visiblePages"
            :key="page"
            @click="goToPage(page)"
            class="px-3 py-2 text-sm rounded-lg transition-colors min-w-[36px]"
            :class="{
                'bg-teal-600 text-white': currentPage === page,
                'text-gray-600 hover:bg-gray-100': currentPage !== page
            }"
        >
            {{ page }}
        </button>

        <!-- Next Button -->
        <button
            @click="goToPage(currentPage + 1)"
            :disabled="currentPage >= totalPages"
            class="px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    currentPage: {
        type: Number,
        required: true,
        default: 1
    },
    totalPages: {
        type: Number,
        required: true,
        default: 1
    },
    onPageChange: {
        type: Function,
        required: true
    }
});

const visiblePages = computed(() => {
    const pages = [];
    const total = props.totalPages;
    const current = props.currentPage;

    if (total <= 7) {
        // Show all pages
        for (let i = 1; i <= total; i++) {
            pages.push(i);
        }
    } else {
        // Show pages with ellipsis
        pages.push(1);

        if (current > 3) {
            pages.push('...');
        }

        const start = Math.max(2, current - 1);
        const end = Math.min(total - 1, current + 1);

        for (let i = start; i <= end; i++) {
            pages.push(i);
        }

        if (current < total - 2) {
            pages.push('...');
        }

        pages.push(total);
    }

    return pages;
});

const goToPage = (page) => {
    if (page < 1 || page > props.totalPages || page === props.currentPage) {
        return;
    }
    props.onPageChange(page);
};
</script>
