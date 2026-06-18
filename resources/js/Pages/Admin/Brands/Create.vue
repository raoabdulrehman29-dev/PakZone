<template>
    <AdminLayout page-title="Add Brand">
        <div class="max-w-2xl">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brand Name *</label>
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            required
                            placeholder="Apple"
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
                            placeholder="apple"
                        />
                    </div>

                    <!-- Logo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-teal-500 transition-colors cursor-pointer">
                            <input type="file" accept="image/*" @change="handleLogoUpload" class="hidden" ref="logoInput" />
                            <button @click="$refs.logoInput.click()" type="button" class="text-teal-600 hover:text-teal-700">
                                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm">Click to upload logo</span>
                            </button>
                        </div>
                        <div v-if="form.logo" class="mt-2">
                            <img :src="form.logo" class="w-20 h-20 object-contain border rounded-lg p-2" />
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea
                            v-model="form.description"
                            rows="3"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            placeholder="Brand description"
                        ></textarea>
                    </div>

                    <!-- Website -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                        <input
                            v-model="form.website"
                            type="url"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            placeholder="https://example.com"
                        />
                    </div>

                    <!-- Featured -->
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" v-model="form.is_featured" class="rounded text-teal-600" />
                            Featured Brand
                        </label>
                    </div>

                    <!-- Active Status -->
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" v-model="form.is_active" class="rounded text-teal-600" />
                            Active
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50"
                        >
                            <span v-if="!form.processing">Save Brand</span>
                            <span v-else>Saving...</span>
                        </button>
                        <Link href="/admin/brands" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    errors: Object
});

const logoInput = ref(null);

const form = useForm({
    name: '',
    slug: '',
    logo: null,
    description: '',
    website: '',
    is_featured: false,
    is_active: true
});

const handleLogoUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            form.logo = e.target.result;
        };
        reader.readAsDataURL(file);
    }
    logoInput.value.value = '';
};

const submit = () => {
    form.post('/admin/brands');
};
</script>
