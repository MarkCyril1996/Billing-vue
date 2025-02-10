import './bootstrap'; // This is essential for bootstrapping your app
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy'; // For handling routes in Vue
import '../css/app.css'; // Importing the CSS once

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`, // Setting the document title dynamically
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`, // Dynamically resolves Vue pages from the Pages directory
            import.meta.glob('./Pages/**/*.vue') // Import all .vue files under the Pages directory
        ),
    setup({ el, App, props, plugin }) {
        // Create the Vue app instance and configure Inertia and Ziggy
        return createApp({ render: () => h(App, props) })
            .use(plugin)     // Use the Inertia plugin to manage page navigation
            .use(ZiggyVue)   // Use Ziggy for route handling (Laravel routes in Vue)
            .mount(el);      // Mount the app to the element in your HTML
    },
    
    progress: {
        color: '#4B5563',  // Custom progress bar color
    },
});
