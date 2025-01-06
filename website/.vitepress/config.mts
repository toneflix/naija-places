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
        ['script', { async: 'true', src: 'https://www.googletagmanager.com/gtag/js?id=G-2ST41R32R3', }],
        [
            'script',
            {},
            `window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-2ST41R32R3');`
        ],
        ['meta', {
            name: 'auto',
            content: 'Toneflix Code.',
        }],
        ['meta', {
            name: 'keywords',
            content: 'Country, State, City, Countries, States, Cities, API, Local Government Areas, Wards, Polling Units, World, Nigeria, Naija, Places, Location',
        }],
        ['meta', {
            name: 'description',
            content: 'One api to rule them all, query all states, Local government areas, Wards, Polling Units and Towns in Nigeria + all world regions, countries, states and cities.',
        }],
    ],
    title: "Toneflix Places API",
    cleanUrls: true,
    assetsDir: 'doc-assets',
    description: "One api to rule them all, query all states, Local government areas, Wards, Polling Units and Towns in Nigeria + all world regions, countries, states and cities.",
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
                ]
            },
            {
                text: 'Naija Geolocation',
                items: [
                    { text: 'States', link: '/docs/states' },
                    { text: 'LGAs', link: '/docs/lgas' },
                    { text: 'Wards', link: '/docs/wards' },
                    { text: 'Polling Units', link: '/docs/units' },
                    { text: 'Towns and Cities', link: '/docs/cities' },
                ]
            },
            {
                text: 'World Geolocation',
                items: [
                    { text: 'Regions', link: '/docs/world/regions' },
                    { text: 'Subregions', link: '/docs/world/subregions' },
                    { text: 'Countries', link: '/docs/world/countries' },
                    { text: 'States', link: '/docs/world/states' },
                    { text: 'Cities', link: '/docs/world/cities' },
                ]
            },
            {
                text: 'Car API',
                link: '/docs/cars',
                items: [
                    { text: 'Countries/Origins', link: '/docs/cars/countries' },
                    { text: 'Make Years', link: '/docs/cars/years' },
                    { text: 'Manufacturers', link: '/docs/cars/manufacturers' },
                    { text: 'Vehicles', link: '/docs/cars/vehicles' },
                    { text: 'Derivatives', link: '/docs/cars/derivatives' },
                    { text: 'Mileages', link: '/docs/cars/mileages' },
                    { text: 'Engines', link: '/docs/cars/engines' },
                    { text: 'Models', link: '/docs/cars/models' },
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
