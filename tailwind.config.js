import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class', // Activa el modo oscuro usando la clase "dark"

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#1E4D8B',
                    contrast: '#FFFFFF',
                },
                secondary: {
                    DEFAULT: '#4A90E2',
                    contrast: '#FFFFFF',
                },
                background: {
                    DEFAULT: '#F5F7FA',
                    dark: '#0D1117',
                },
                surface: {
                    DEFAULT: '#FFFFFF',
                    dark: '#111827',
                },
                text: {
                    DEFAULT: '#2C2C2C',
                    dark: '#E6EAF2',
                },
                muted: {
                    DEFAULT: '#6B7280',
                    dark: '#9CA3AF',
                },
                border: {
                    DEFAULT: '#E5E7EB',
                    dark: '#1F2937',
                },
                success: '#2ECC71',
                warning: '#E67E22',
                error: '#E74C3C',
            },
        },
    },

    plugins: [forms],
};
