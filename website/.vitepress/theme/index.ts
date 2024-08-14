// https://vitepress.dev/guide/custom-theme
import { h } from 'vue'
import type { Theme } from 'vitepress'
import DefaultTheme from 'vitepress/theme'
import { createPinia } from "pinia";
import { createPersistedState } from 'pinia-plugin-persistedstate'
import './style.css'
import './css/custom.css'
import 'notiflix/dist/notiflix-3.2.7.min.css'

export default {
    extends: DefaultTheme,
    Layout: () => {
        return h(DefaultTheme.Layout, null, {
            // https://vitepress.dev/guide/extending-default-theme#layout-slots
        })
    },
    enhanceApp ({ app, router, siteData }) {
        const pinia = createPinia();
        pinia.use(createPersistedState({
            auto: true,
        }))
        app.use(pinia);

        const comps = import.meta.glob('./components/**/*.vue', { eager: true })

        Object.entries(comps).forEach(([path, definition]) => {
            if (path) {
                const name = path.split('/').pop()?.replace(/\.\w+$/, '')
                if (name) {
                    app.component(name, (<{ default: () => any }>definition).default)
                }
            }

        })
    }
} satisfies Theme
