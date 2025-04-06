/// <reference types="vite/client" />

interface ImportMeta {
    glob<T = unknown>(pattern: string, options?: { eager?: boolean }): Record<string, T>;
}

import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import type { DefineComponent } from 'vue'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
    title: (title: string) => `${title} - ${appName}`,
    resolve: (name: string) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)

        vueApp.mount(el)

        return vueApp // ✅ Return the app instance, not the mount result
    },
    progress: {
        color: '#4B5563',
    },
})
