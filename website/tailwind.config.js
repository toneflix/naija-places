/** @type {import('tailwindcss').Config} */
import forms from '@tailwindcss/forms'
module.exports = {
    darkMode: 'selector',
    content: [
        "./.vitepress/**/*.vue",
        "./**/*.md",
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
