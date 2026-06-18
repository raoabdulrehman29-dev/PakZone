<template>
    <Teleport to="body">
        <div v-if="isOpen" class="fixed inset-0 z-50 overflow-y-auto">
            <!-- Backdrop -->
            <div
                class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"
                @click="close"
            ></div>

            <!-- Modal -->
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all"
                    :class="sizeClass"
                >
                    <!-- Close Button -->
                    <button
                        @click="close"
                        class="absolute right-4 top-4 text-gray-400 hover:text-gray-600 transition-colors z-10"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <!-- Header -->
                    <div v-if="title" class="px-6 pt-6 pb-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">{{ title }}</h3>
                    </div>

                    <!-- Content -->
                    <div class="px-6 py-4">
                        <slot />
                    </div>

                    <!-- Footer -->
                    <div v-if="$slots.footer" class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    isOpen: {
        type: Boolean,
        required: true
    },
    title: {
        type: String,
        default: ''
    },
    size: {
        type: String,
        default: 'md', // sm, md, lg, xl
        validator: (value) => ['sm', 'md', 'lg', 'xl'].includes(value)
    },
    closeOnBackdrop: {
        type: Boolean,
        default: true
    }
});

const emit = defineEmits(['close']);

const sizeClass = computed(() => {
    const classes = {
        sm: 'max-w-sm',
        md: 'max-w-md',
        lg: 'max-w-lg',
        xl: 'max-w-xl'
    };
    return classes[props.size] || 'max-w-md';
});

const close = () => {
    if (props.closeOnBackdrop) {
        emit('close');
    }
};
</script>
