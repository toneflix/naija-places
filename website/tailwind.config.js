/** @type {import('tailwindcss').Config} */
import forms from '@tailwindcss/forms'
module.exports = {
    darkMode: 'selector',
    content: [
        "./.vitepress/**/*.vue",
        "./docs/*.md",
        "./docs/world/*.md",
        "/*.md",
    ],
    theme: {
        extend: {
            colors: {
                'accent': '#07bafd',
                'primary': '#137110',
                'secondary': '#e1ae01',
            },
        },
    },
    plugins: [
        forms(),
    ],
}
