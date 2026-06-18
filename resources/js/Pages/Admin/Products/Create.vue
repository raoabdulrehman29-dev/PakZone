<template>
    <AdminLayout page-title="Add Product">
        <form @submit.prevent="submit" class="max-w-4xl">
            <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            required
                        />
                        <p v-if="errors.name" class="text-sm text-red-600 mt-1">{{ errors.name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SKU *</label>
                        <input
                            v-model="form.sku"
                            type="text"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            required
                        />
                        <p v-if="errors.sku" class="text-sm text-red-600 mt-1">{{ errors.sku }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                        <select
                            v-model="form.category_id"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            required
                        >
                            <option value="">Select Category</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <p v-if="errors.category_id" class="text-sm text-red-600 mt-1">{{ errors.category_id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brand *</label>
                        <select
                            v-model="form.brand_id"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            required
                        >
                            <option value="">Select Brand</option>
                            <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                                {{ brand.name }}
                            </option>
                        </select>
                        <p v-if="errors.brand_id" class="text-sm text-red-600 mt-1">{{ errors.brand_id }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price *</label>
                        <input
                            v-model="form.price"
                            type="number"
                            step="0.01"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            required
                        />
                        <p v-if="errors.price" class="text-sm text-red-600 mt-1">{{ errors.price }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sale Price</label>
                        <input
                            v-model="form.sale_price"
                            type="number"
                            step="0.01"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                        />
                        <p v-if="errors.sale_price" class="text-sm text-red-600 mt-1">{{ errors.sale_price }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stock *</label>
                        <input
                            v-model="form.stock"
                            type="number"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            required
                        />
                        <p v-if="errors.stock" class="text-sm text-red-600 mt-1">{{ errors.stock }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Low Stock Threshold</label>
                        <input
                            v-model="form.low_stock_threshold"
                            type="number"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                        />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                    <textarea
                        v-model="form.short_description"
                        rows="2"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Description</label>
                    <textarea
                        v-model="form.description"
                        rows="5"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select v-model="form.status" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" v-model="form.featured" class="rounded text-teal-600" />
                            Featured Product
                        </label>
                    </div>
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" v-model="form.best_seller" class="rounded text-teal-600" />
                            Best Seller
                        </label>
                    </div>
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product Images</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-teal-500 transition-colors cursor-pointer">
                        <input type="file" multiple accept="image/*" @change="handleImageUpload" class="hidden" ref="imageInput" />
                        <button @click="$refs.imageInput.click()" type="button" class="text-teal-600 hover:text-teal-700">
                            <svg class="w-10 h-10 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm">Click to upload product images</span>
                        </button>
                    </div>
                    <div v-if="form.images.length > 0" class="flex flex-wrap gap-2 mt-2">
                        <div v-for="(image, index) in form.images" :key="index" class="relative">
                            <img :src="image.preview" class="w-20 h-20 object-cover rounded-lg border" />
                            <button @click="removeImage(index)" type="button" class="absolute -top-1 -right-1 p-0.5 bg-red-500 text-white rounded-full">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Variants -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Variants (Optional)</label>
                    <button type="button" @click="addVariant" class="text-sm text-teal-600 hover:text-teal-700">
                        + Add Variant
                    </button>
                    <div v-for="(variant, index) in form.variants" :key="index" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3 p-4 bg-gray-50 rounded-lg">
                        <div>
                            <input v-model="variant.type" placeholder="Type (size, color)" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" />
                        </div>
                        <div>
                            <input v-model="variant.value" placeholder="Value (e.g., Large)" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" />
                        </div>
                        <div class="flex items-center gap-2">
                            <input v-model="variant.stock" type="number" placeholder="Stock" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" />
                            <button @click="removeVariant(index)" type="button" class="text-red-500 hover:text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
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
                        <span v-if="!form.processing">Save Product</span>
                        <span v-else>Saving...</span>
                    </button>
                    <Link href="/admin/products" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                        Cancel
                    </Link>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    categories: {
        type: Array,
        default: () => []
    },
    brands: {
        type: Array,
        default: () => []
    },
    errors: Object
});

const imageInput = ref(null);

const form = useForm({
    name: '',
    sku: '',
    category_id: '',
    brand_id: '',
    price: '',
    sale_price: '',
    stock: 0,
    low_stock_threshold: 10,
    short_description: '',
    description: '',
    status: 'draft',
    featured: false,
    best_seller: false,
    images: [],
    variants: []
});

const handleImageUpload = (event) => {
    const files = event.target.files;
    for (let file of files) {
        const reader = new FileReader();
        reader.onload = (e) => {
            form.images.push({
                file: file,
                preview: e.target.result
            });
        };
        reader.readAsDataURL(file);
    }
    imageInput.value.value = '';
};

const removeImage = (index) => {
    form.images.splice(index, 1);
};

const addVariant = () => {
    form.variants.push({ type: '', value: '', stock: 0 });
};

const removeVariant = (index) => {
    form.variants.splice(index, 1);
};

const submit = () => {
    form.post('/admin/products');
};
</script>
