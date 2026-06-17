<template>
    <div class="min-h-screen flex bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white fixed h-full overflow-y-auto">
            <div class="p-4 border-b border-gray-800">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-teal-600 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">Pak<span class="text-teal-400">Zone</span></span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Admin Panel</p>
            </div>

            <nav class="p-4 space-y-1">
                <Link href="/admin/dashboard" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </Link>
                <Link href="/admin/products" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                    Products
                </Link>
                <Link href="/admin/orders" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Orders
                </Link>
                <Link href="/admin/users" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Users
                </Link>
                <a href="/" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors mt-4 border-t border-gray-800 pt-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 12l4-4m-4 4l4 4"/>
                    </svg>
                    Back to Site
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Admin Header -->
            <header class="bg-white shadow-sm">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900">{{ pageTitle }}</h2>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500">{{ user?.name || 'Admin' }}</span>

                        <!-- ✅ WORKING LOGOUT BUTTON -->
                        <form @submit.prevent="logout">
                            <button
                                type="submit"
                                class="text-sm text-red-600 hover:text-red-700 transition-colors"
                            >
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Admin Content -->
            <main class="p-6">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';

defineProps({
    pageTitle: {
        type: String,
        default: 'Dashboard'
    },
    user: {
        type: Object,
        default: null
    }
});

const logout = () => {
    router.post('/logout', {}, {
        onSuccess: () => {
            // Optional: Redirect to home after logout
            window.location.href = '/';
        }
    });
};
</script>
