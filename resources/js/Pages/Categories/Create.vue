<template>
    <AdminLayout page-title="Add Category">
        <div class="max-w-2xl">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category Name *</label>
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            required
                            placeholder="Electronics"
                        />
                        <p v-if="errors.name" class="text-sm text-red-600 mt-1">{{ errors.name }}</p>
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input
                            v-model="form.slug"
                            type="text"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            placeholder="electronics"
                        />
                        <p class="text-xs text-gray-400 mt-1">Leave empty to auto-generate from name</p>
                        <p v-if="errors.slug" class="text-sm text-red-600 mt-1">{{ errors.slug }}</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea
                            v-model="form.description"
                            rows="3"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            placeholder="Category description"
                        ></textarea>
                    </div>

                    <!-- Parent Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Parent Category</label>
                        <select v-model="form.parent_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                            <option value="">None (Top Level)</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Icon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Icon (Emoji or Font Awesome)</label>
                        <input
                            v-model="form.icon"
                            type="text"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            placeholder="📱"
                        />
                    </div>

                    <!-- Active Status -->
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" v-model="form.is_active" class="rounded text-teal-600" />
                            Active
                        </label>
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                        <input
                            v-model="form.sort_order"
                            type="number"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            placeholder="0"
                        />
                    </div>

                    <!-- SEO -->
                    <div class="border-t border-gray-200 pt-4">
                        <h4 class="font-medium text-gray-800 mb-3">SEO Settings</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">SEO Title</label>
                                <input
                                    v-model="form.seo_title"
                                    type="text"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                                    placeholder="Meta title"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">SEO Description</label>
                                <textarea
                                    v-model="form.seo_description"
                                    rows="2"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                                    placeholder="Meta description"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50"
                        >
                            <span v-if="!form.processing">Save Category</span>
                            <span v-else>Saving...</span>
                        </button>
                        <Link href="/admin/categories" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    categories: {
        type: Array,
        default: () => []
    },
    errors: Object
});

const form = useForm({
    name: '',
    slug: '',
    description: '',
    parent_id: '',
    icon: '',
    is_active: true,
    sort_order: 0,
    seo_title: '',
    seo_description: ''
});

const submit = () => {
    form.post('/admin/categories');
};
</script>
