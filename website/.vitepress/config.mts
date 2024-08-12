import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
    title: "Naija Places API",
    description: "One api to rule them all, query all states, Local government areas, Wards, Polling Units and Towns in Nigeria.",
    themeConfig: {
        // https://vitepress.dev/reference/default-theme-config
        nav: [
            { text: 'Home', link: '/' },
            { text: 'Portal', link: '/portal' }
        ],

        sidebar: [
            {
                text: 'Usage',
                items: [
                    { text: 'Api Documentation', link: '/api-documentation' },
                    { text: 'States', link: '/states' },
                    { text: 'LGAs', link: '/lgas' },
                    { text: 'Wards', link: '/wards' },
                    { text: 'Polling Units', link: '/units' },
                    { text: 'Towns and Cities', link: '/cities' },
                ]
            }
        ],

        socialLinks: [
            { icon: 'github', link: 'https://github.com/toneflix/vitepress' }
        ]
    }
})
