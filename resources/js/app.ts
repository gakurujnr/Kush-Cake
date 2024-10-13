import './bootstrap';
import '../css/app.css';
import type { DefineComponent } from "vue";

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
// @ts-expect-error
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./Pages/**/*.vue")
    ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            // .use(ZiggyVue)
            .use(ZiggyVue, (window as any).Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});