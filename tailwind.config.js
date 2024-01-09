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

            }
        },
    },

    plugins: [forms, typography],
};
