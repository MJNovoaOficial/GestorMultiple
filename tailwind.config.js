import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {

        darkMode: 'class',

        content: [
            "./resources/**/*.blade.php",
            "./resources/**/*.js",
            "./resources/**/*.vue",
        ],

        theme: {
            extend: {
                colors: {
                    sidebar: {
                        dark: '#0f172a',
                        light: '#f8fafc',
                    },

                    card: {
                        dark: '#1e293b',
                        light: '#ffffff',
                    }
                },

                spacing: {
                    '18': '4.5rem',
                }
            },
        },

        plugins: [forms],
};
