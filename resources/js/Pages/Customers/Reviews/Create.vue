<template>
    <CustomersLayout page-title="Write a Review" page-subtitle="Share your experience with this product">
        <div class="max-w-2xl">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <!-- Product Info -->
                <div class="flex items-center gap-4 pb-4 border-b border-gray-200 mb-4">
                    <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                        <img :src="product?.image || 'https://via.placeholder.com/80x80?text=No+Image'"
                             :alt="product?.name"
                             class="w-full h-full object-cover"
                        />
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">{{ product?.name }}</h4>
                        <p class="text-sm text-gray-500">Order #{{ order_number }}</p>
                    </div>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Rating -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Your Rating</label>
                        <div class="flex items-center gap-1">
                            <button
                                v-for="star in 5"
                                :key="star"
                                @click="form.rating = star"
                                type="button"
                                class="text-3xl transition-colors"
                                :class="star <= form.rating ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-200'"
                            >
                                ★
                            </button>
                            <span class="ml-2 text-sm text-gray-500">{{ form.rating }}/5</span>
                        </div>
                        <p v-if="errors.rating" class="text-sm text-red-600 mt-1">{{ errors.rating }}</p>
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Review Title</label>
                        <input
                            v-model="form.title"
                            type="text"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            placeholder="Great product!"
                        />
                        <p v-if="errors.title" class="text-sm text-red-600 mt-1">{{ errors.title }}</p>
                    </div>

                    <!-- Comment -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
                        <textarea
                            v-model="form.comment"
                            rows="5"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all resize-none"
                            placeholder="Share your experience with this product..."
                            required
                        ></textarea>
                        <p v-if="errors.comment" class="text-sm text-red-600 mt-1">{{ errors.comment }}</p>
                    </div>

                    <!-- Images -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Add Photos (Optional)</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-teal-500 transition-colors cursor-pointer">
                            <input type="file" multiple accept="image/*" @change="handleFileUpload" class="hidden" ref="fileInput" />
                            <button @click="$refs.fileInput.click()" type="button" class="text-teal-600 hover:text-teal-700">
                                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm">Click to upload images</span>
                            </button>
                            <p class="text-xs text-gray-500 mt-1">Upload up to 5 images (Max 2MB each)</p>
                        </div>
                        <div v-if="form.images.length > 0" class="flex gap-2 mt-2">
                            <div v-for="(image, index) in form.images" :key="index" class="relative">
                                <img :src="image.preview" class="w-16 h-16 object-cover rounded-lg" />
                                <button @click="removeImage(index)" type="button" class="absolute -top-1 -right-1 p-0.5 bg-red-500 text-white rounded-full">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <span v-if="!form.processing">Submit Review</span>
                            <span v-else>Submitting...</span>
                        </button>
                        <Link href="/reviews" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </CustomersLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import CustomersLayout from '@/Layouts/CustomerLayout.vue';

const props = defineProps({
    product: {
        type: Object,
        required: true
    },
    order_number: {
        type: String,
        required: true
    },
    errors: Object
});

const fileInput = ref(null);

const form = useForm({
    rating: 0,
    title: '',
    comment: '',
    images: []
});

const handleFileUpload = (event) => {
    const files = event.target.files;
    for (let file of files) {
        if (form.images.length >= 5) {
            alert('You can upload up to 5 images');
            break;
        }
        const reader = new FileReader();
        reader.onload = (e) => {
            form.images.push({
                file: file,
                preview: e.target.result
            });
        };
        reader.readAsDataURL(file);
    }
    fileInput.value.value = '';
};

const removeImage = (index) => {
    form.images.splice(index, 1);
};

const submit = () => {
    // Handle form submission
    console.log('Submitting review:', form);
};
</script>
