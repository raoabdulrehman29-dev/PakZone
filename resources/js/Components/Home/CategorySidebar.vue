<template>
    <div class="bg-white rounded-lg shadow-sm p-4">
        <!-- Categories Dropdown -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                All Categories
            </h3>
            <div class="space-y-1">
                <div v-for="category in categories" :key="category.id" class="relative">
                    <button
                        @click="toggleCategory(category.id)"
                        class="w-full flex items-center justify-between px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors"
                    >
                        <span class="flex items-center gap-2">
                            <span v-if="category.icon" class="text-lg">{{ category.icon }}</span>
                            {{ category.name }}
                            <span v-if="category.product_count" class="text-xs text-gray-400">({{ category.product_count }})</span>
                        </span>
                        <svg
                            class="w-4 h-4 text-gray-400 transition-transform duration-200"
                            :class="{ 'rotate-180': expandedCategories.includes(category.id) }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Sub-categories -->
                    <div v-if="expandedCategories.includes(category.id)" class="ml-6 space-y-1">
                        <label v-for="sub in category.children" :key="sub.id"
                               class="flex items-center gap-2 px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-50 rounded-lg cursor-pointer transition-colors">
                            <input
                                type="checkbox"
                                :value="sub.id"
                                v-model="selectedSubCategories"
                                @change="handleFilterChange"
                                class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                            >
                            {{ sub.name }}
                            <span v-if="sub.product_count" class="text-xs text-gray-400">({{ sub.product_count }})</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="border-t border-gray-200 pt-4">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">Filters</h3>

            <!-- Price Range -->
            <div class="mb-4">
                <h4 class="text-xs font-medium text-gray-600 mb-2">Price Range</h4>
                <div class="flex items-center gap-2">
                    <input
                        type="number"
                        v-model.number="priceMin"
                        placeholder="Min"
                        @input="handleFilterChange"
                        min="0"
                        class="w-1/2 px-2 py-1 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-teal-500 focus:border-transparent"
                    >
                    <span class="text-gray-400">-</span>
                    <input
                        type="number"
                        v-model.number="priceMax"
                        placeholder="Max"
                        @input="handleFilterChange"
                        min="0"
                        class="w-1/2 px-2 py-1 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-teal-500 focus:border-transparent"
                    >
                </div>
            </div>

            <!-- Condition -->
            <div class="mb-4">
                <h4 class="text-xs font-medium text-gray-600 mb-2">Condition</h4>
                <div class="space-y-1.5">
                    <label v-for="condition in conditions" :key="condition.value"
                           class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer hover:text-gray-800 transition-colors">
                        <input
                            type="checkbox"
                            :value="condition.value"
                            v-model="selectedConditions"
                            @change="handleFilterChange"
                            class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                        >
                        {{ condition.label }}
                    </label>
                </div>
            </div>

            <!-- Ratings -->
            <div class="mb-4">
                <h4 class="text-xs font-medium text-gray-600 mb-2">Customer Rating</h4>
                <div class="space-y-1.5">
                    <label v-for="star in [4,3,2,1]" :key="star"
                           class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer hover:text-gray-800 transition-colors">
                        <input
                            type="checkbox"
                            :value="star"
                            v-model="selectedRatings"
                            @change="handleFilterChange"
                            class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                        >
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-400">★</span>
                            <span>{{ star }}+</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- In Stock -->
            <div class="mb-4">
                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer hover:text-gray-800 transition-colors">
                    <input
                        type="checkbox"
                        v-model="inStockOnly"
                        @change="handleFilterChange"
                        class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                    >
                    In Stock Only
                </label>
            </div>
        </div>

        <!-- Services Section -->
        <div class="border-t border-gray-200 pt-4 mt-4">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">Services</h3>
            <div class="space-y-2">
                <div class="flex items-center gap-3 text-sm text-gray-600">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Free Delivery</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-600">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Pay on Delivery</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-600">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <span>Secure Payments</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-600">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>7-Day Returns</span>
                </div>
            </div>
        </div>

        <!-- Apply Filters Button -->
        <button
            @click="applyFilters"
            class="w-full mt-6 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors shadow-md"
        >
            Apply Filters
        </button>

        <!-- Clear Filters Button -->
        <button
            @click="clearFilters"
            class="w-full mt-2 px-4 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-lg transition-colors"
        >
            Clear All Filters
        </button>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    categories: {
        type: Array,
        default: () => []
    },
    activeFilters: {
        type: Object,
        default: () => ({})
    }
});

// ============================================
// STATE
// ============================================
const expandedCategories = ref([]);
const selectedSubCategories = ref([]);
const priceMin = ref('');
const priceMax = ref('');
const selectedConditions = ref([]);
const selectedRatings = ref([]);
const inStockOnly = ref(false);

// ============================================
// DATA
// ============================================
const conditions = [
    { value: 'new', label: 'New' },
    { value: 'used', label: 'Used' },
    { value: 'refurbished', label: 'Refurbished' }
];

// ============================================
// EMITS
// ============================================
const emit = defineEmits(['apply-filters', 'clear-filters']);

// ============================================
// METHODS
// ============================================
const toggleCategory = (id) => {
    const index = expandedCategories.value.indexOf(id);
    if (index > -1) {
        expandedCategories.value.splice(index, 1);
    } else {
        expandedCategories.value.push(id);
    }
};

const handleFilterChange = () => {
    // Auto-apply filters after a small delay (debounce)
    clearTimeout(window.filterTimeout);
    window.filterTimeout = setTimeout(() => {
        applyFilters();
    }, 300);
};

const applyFilters = () => {
    const filters = {
        sub_categories: selectedSubCategories.value.length > 0 ? selectedSubCategories.value.join(',') : null,
        price_min: priceMin.value || null,
        price_max: priceMax.value || null,
        conditions: selectedConditions.value.length > 0 ? selectedConditions.value.join(',') : null,
        ratings: selectedRatings.value.length > 0 ? selectedRatings.value.join(',') : null,
        in_stock: inStockOnly.value ? 1 : null
    };

    // Remove null/empty values
    Object.keys(filters).forEach(key => {
        if (filters[key] === null || filters[key] === '' || filters[key] === undefined) {
            delete filters[key];
        }
    });

    emit('apply-filters', filters);
};

const clearFilters = () => {
    selectedSubCategories.value = [];
    priceMin.value = '';
    priceMax.value = '';
    selectedConditions.value = [];
    selectedRatings.value = [];
    inStockOnly.value = false;

    emit('clear-filters');
};
</script>

<style scoped>
/* Smooth transitions */
.transition-colors {
    transition-property: color, background-color, border-color;
    transition-duration: 200ms;
}

.transition-transform {
    transition-property: transform;
    transition-duration: 200ms;
}

/* Custom scrollbar for category list */
.space-y-1 {
    max-height: 400px;
    overflow-y: auto;
}

.space-y-1::-webkit-scrollbar {
    width: 4px;
}

.space-y-1::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.space-y-1::-webkit-scrollbar-thumb {
    background: #14b8a6;
    border-radius: 4px;
}

.space-y-1::-webkit-scrollbar-thumb:hover {
    background: #0d9488;
}
</style>
