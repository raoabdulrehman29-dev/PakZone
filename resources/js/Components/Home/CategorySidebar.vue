<template>
    <div class="bg-white rounded-lg shadow-sm p-4">
        <!-- Categories -->
         <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">
                Categories
            </h3>
            <div class="space-y-2 max-h-60 overflow-y-auto">
                <template v-for="category in categories" :key="category.id">
                    <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                        <input
                            type="checkbox"
                            :value="category.id"
                            v-model="selectedCategories"
                            @change="applyFilters"
                            class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                        >
                        {{ category.name }}
                        <span class="text-xs text-gray-400">({{ category.products_count || 0 }})</span>
                    </label>
                    <label v-for="child in category.children || []" :key="child.id"
                           class="ml-5 flex items-center gap-2 text-sm text-gray-500 hover:text-gray-900 cursor-pointer">
                        <input
                            type="checkbox"
                            :value="child.id"
                            v-model="selectedCategories"
                            @change="applyFilters"
                            class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                        >
                        {{ child.name }}
                        <span class="text-xs text-gray-400">({{ child.products_count || 0 }})</span>
                    </label>
                </template>
            </div>
        </div>

        <!-- Price Range -->
        <div class="mb-4 border-t border-gray-200 pt-4">
            <h4 class="text-xs font-medium text-gray-600 mb-2">Price Range</h4>
            <div class="flex items-center gap-2">
                <input
                    type="number"
                    v-model.number="priceMin"
                    placeholder="Min"
                    @input="applyFilters"
                    class="w-1/2 px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                />
                <span class="text-gray-400">-</span>
                <input
                    type="number"
                    v-model.number="priceMax"
                    placeholder="Max"
                    @input="applyFilters"
                    class="w-1/2 px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                />
            </div>
        </div>

        <!-- Ratings -->
        <div class="mb-4 border-t border-gray-200 pt-4">
            <h4 class="text-xs font-medium text-gray-600 mb-2">Rating</h4>
            <div class="space-y-1.5">
                <label v-for="star in [4,3,2,1]" :key="star"
                       class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                    <input
                        type="checkbox"
                        :value="star"
                        v-model="selectedRatings"
                        @change="applyFilters"
                        class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                    >
                    <div class="flex items-center">
                        <span v-for="s in 5" :key="s" class="text-sm">
                            <span v-if="s <= star" class="text-yellow-400">★</span>
                            <span v-else class="text-gray-300">★</span>
                        </span>
                        <span class="text-xs text-gray-400 ml-1">&amp; up</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- In Stock -->
        <div class="border-t border-gray-200 pt-4">
            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                <input
                    type="checkbox"
                    v-model="inStockOnly"
                    @change="applyFilters"
                    class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                >
                In Stock Only
            </label>
        </div>

        <!-- Buttons -->
        <button @click="applyFilters" class="w-full mt-4 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors">
            Apply Filters
        </button>
        <button @click="clearFilters" class="w-full mt-2 px-4 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
            Clear All
        </button>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    categories: { type: Array, default: () => [] },
    activeFilters: { type: Object, default: () => ({}) }
});

const selectedCategories = ref([]);
const selectedRatings = ref([]);
const priceMin = ref('');
const priceMax = ref('');
const inStockOnly = ref(false);
let filterTimeout = null;

const applyFilters = () => {
    clearTimeout(filterTimeout);
    filterTimeout = setTimeout(() => {
        const filters = {
            categories: selectedCategories.value.length ? selectedCategories.value.join(',') : null,
            ratings: selectedRatings.value.length ? selectedRatings.value.join(',') : null,
            price_min: priceMin.value || null,
            price_max: priceMax.value || null,
            in_stock: inStockOnly.value ? 1 : null
        };

        // Remove null values
        Object.keys(filters).forEach(key => {
            if (filters[key] === null) {
                delete filters[key];
            }
        });

        router.get('/products', filters, {
            preserveState: true,
            preserveScroll: true
        });
    }, 300);
};

const clearFilters = () => {
    selectedCategories.value = [];
    selectedRatings.value = [];
    priceMin.value = '';
    priceMax.value = '';
    inStockOnly.value = false;
    router.get('/products', {}, { preserveState: true });
};
</script>
