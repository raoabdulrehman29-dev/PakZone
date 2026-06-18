<template>
    <CustomersLayout page-title="My Reviews" page-subtitle="Manage your product reviews">
        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                <p class="text-2xl font-bold text-gray-900">{{ stats.total || 0 }}</p>
                <p class="text-xs text-gray-500">Total Reviews</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                <p class="text-2xl font-bold text-green-600">{{ stats.approved || 0 }}</p>
                <p class="text-xs text-gray-500">Approved</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                <p class="text-2xl font-bold text-yellow-600">{{ stats.pending || 0 }}</p>
                <p class="text-xs text-gray-500">Pending</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                <p class="text-2xl font-bold text-teal-600">{{ stats.average_rating || 0 }}</p>
                <p class="text-xs text-gray-500">Average Rating</p>
            </div>
        </div>

        <!-- Reviews List -->
        <div v-if="reviews && reviews.length > 0" class="space-y-4">
            <div v-for="review in reviews" :key="review.id" class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex flex-wrap items-start justify-between gap-2">
                    <div class="flex-1">
                        <!-- Product Info -->
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                <img :src="review.product?.image || 'https://via.placeholder.com/50x50?text=No+Image'"
                                     :alt="review.product?.name"
                                     class="w-full h-full object-cover"
                                />
                            </div>
                            <div>
                                <a :href="`/product/${review.product?.slug}`" class="font-medium text-gray-800 hover:text-teal-600 transition-colors">
                                    {{ review.product?.name }}
                                </a>
                                <div class="flex items-center gap-2 mt-1">
                                    <StarRating :rating="review.rating" />
                                    <span class="text-xs text-gray-500">{{ formatDate(review.created_at) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Review Content -->
                        <p v-if="review.title" class="font-medium text-gray-700">{{ review.title }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ review.comment }}</p>

                        <!-- Review Images -->
                        <div v-if="review.images && review.images.length > 0" class="flex gap-2 mt-2">
                            <div v-for="(image, index) in review.images" :key="index" class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden">
                                <img :src="image" alt="Review image" class="w-full h-full object-cover" />
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="mt-2">
                            <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full"
                                :class="{
                                    'bg-green-100 text-green-800': review.status === 'approved',
                                    'bg-yellow-100 text-yellow-800': review.status === 'pending',
                                    'bg-red-100 text-red-800': review.status === 'rejected'
                                }">
                                {{ review.status || 'Pending' }}
                            </span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <Link v-if="review.status === 'pending'"
                              :href="`/reviews/${review.id}/edit`"
                              class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                            Edit
                        </Link>
                        <button
                            @click="deleteReview(review.id)"
                            class="px-3 py-1 text-sm bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-16 bg-white rounded-lg shadow-sm">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
            <h3 class="text-xl font-medium text-gray-900">No reviews yet</h3>
            <p class="text-gray-500 mt-1">Start reviewing products you've purchased</p>
            <Link href="/orders" class="inline-block mt-4 px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors">
                View Your Orders →
            </Link>
        </div>
    </CustomersLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import CustomersLayout from '@/Layouts/CustomerLayout.vue';
import StarRating from '@/Components/Shared/StarRating.vue';

const props = defineProps({
    reviews: {
        type: Array,
        default: () => []
    },
    stats: {
        type: Object,
        default: () => ({
            total: 0,
            approved: 0,
            pending: 0,
            average_rating: 0
        })
    }
});

const formatDate = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('en-PK', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

const deleteReview = (id) => {
    if (confirm('Are you sure you want to delete this review?')) {
        console.log('Delete review:', id);
    }
};
</script>
