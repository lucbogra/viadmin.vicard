import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                inter: 'Inter',
                quicksand: 'Quicksand',
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navbar: {
                    900: "#1f2937",
                    800: "#111827",
                },
                primary: {
                    900: "#243262",
                    800: "#0a6189",
                    700: "#18529d",
                    600: "#2d6aab",
                    500: "#5490c6",
                },
                secondary: {
                    900: "#318baa",
                    800: "#4c86c4",
                    700: "#73a2ce",
                    600: "#96c0e0",
                    500: "#636f93",
                },
            },
            gridTemplateColumns: {
                // Simple 16 column grid
                '4': 'repeat(4, minmax(0, 1fr))',

            },
            gridColumn: {
                'span-2': 'span 2 / span 3',
                'span-3': 'span 3 / span 3',
                'span-4': 'span 4 / span 3',
                'span-5': 'span 5 / span 3',
                'span-6': 'span 6 / span 3',
            },
            spacing: {
                '36': '9rem',
                '40': '10rem',
                '44': '11rem',
                '48': '12rem',
                '52': '13rem',
                '56': '14rem',
                '60': '15rem',
                '64': '16rem',
                '68': '17rem',
                '72': '18rem',
                '76': '19rem',
                '80': '20rem',
                '84': '21rem',
                '88': '22rem',
                '92': '23rem',
                '96': '24rem',
                '100': '25rem',
                '128': '32rem',
            }
        },
    },

    plugins: [forms, typography],
};
