import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

// Import layouts
import CustomerLayout from './Layouts/CustomerLayout.vue';
import GuestLayout from './Layouts/GuestLayout.vue';
import  Navbar from './Components/Common/Navbar.vue';

createInertiaApp({
    title: (title) => `${title} - PakZone`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('CustomerLayout', CustomerLayout)
            .component('GuestLayout', GuestLayout)
            .component('Navbar', Navbar)

            .mount(el);
    },
    progress: {
        color: '#14B8A6',
    },
});
