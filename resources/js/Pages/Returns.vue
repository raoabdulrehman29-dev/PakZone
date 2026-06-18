<template>
    <CustomerLayout>
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Returns Policy</h1>
            <p class="text-sm text-gray-500 mb-6">Our commitment to your satisfaction</p>

            <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">30-Day Return Policy</h3>
                    <p class="text-gray-600 mt-2">We want you to be completely satisfied with your purchase. If you're not happy with your order, you can return it within 30 days of delivery for a full refund.</p>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <h4 class="font-semibold text-gray-900">Return Conditions</h4>
                    <ul class="list-disc list-inside text-gray-600 mt-2 space-y-1">
                        <li>Items must be in original condition</li>
                        <li>All original packaging and tags must be intact</li>
                        <li>Return shipping is free for Prime members</li>
                        <li>Refunds processed within 5-7 business days</li>
                    </ul>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <h4 class="font-semibold text-gray-900">How to Return</h4>
                    <ol class="list-decimal list-inside text-gray-600 mt-2 space-y-1">
                        <li>Log in to your account</li>
                        <li>Go to "My Orders"</li>
                        <li>Select the order and click "Return"</li>
                        <li>Print the return label</li>
                        <li>Drop off at nearest courier</li>
                    </ol>
                </div>

                <div class="bg-teal-50 p-4 rounded-lg">
                    <p class="text-sm text-teal-700">Need help? <a href="/contact" class="font-medium hover:underline">Contact our support team</a></p>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>

<script setup>
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
</script>
