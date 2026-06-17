<template>
    <AdminLayout page-title="Dashboard">
        <!-- Admin content here -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h4>Total Revenue</h4>
                <p class="text-2xl font-bold">Rs. 0</p>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
</script>
