import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
    head: [
        ['link', { rel: 'icon', href: '/docs/logo.png' }],
        ['link', {
            rel: 'stylesheet',
            href: 'https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css',
            integrity: 'sha512-OQDNdI5rpnZ0BRhhJc+btbbtnxaj+LdQFeh0V9/igiEPDiWE2fG+ZsXl0JEH+bjXKPJ3zcXqNyP4/F/NegVdZg==',
            crossorigin: 'anonymous',
            referrerpolicy: 'no-referrer'
        }],
    ],
    title: "Naija Places API",
    cleanUrls: true,
    assetsDir: 'doc-assets',
    description: "One api to rule them all, query all states, Local government areas, Wards, Polling Units and Towns in Nigeria.",
    themeConfig: {
        // https://vitepress.dev/reference/default-theme-config
        logo: '/docs/logo.png',
        nav: [
            { text: 'Home', link: '/' },
            { text: 'Demo', link: '/demo' },
            { text: 'Portal', link: '/portal/home' },
        ],

        sidebar: [
            {
                text: 'Usage',
                items: [
                    { text: 'Api Documentation', link: '/api-documentation' },
                    { text: 'States', link: '/docs/states' },
                    { text: 'LGAs', link: '/docs/lgas' },
                    { text: 'Wards', link: '/docs/wards' },
                    { text: 'Polling Units', link: '/docs/units' },
                    { text: 'Towns and Cities', link: '/docs/cities' },
                ]
            }
        ],

        socialLinks: [
            { icon: 'github', link: 'https://github.com/toneflix/naija-places' }
        ],
        footer: {
            message: 'Released under the MIT License.',
            copyright: 'Copyright © ' + (new Date().getFullYear()) + ' Toneflix'
        },
        lastUpdated: {
            text: 'Last updated',
            formatOptions: {
                dateStyle: 'full',
                timeStyle: 'medium'
            }
        }
    }
})
