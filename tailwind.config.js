const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },

        colors: {
            gray: {
                '50': '#FAFAFA',
                '100': '#F5F5F5',
                '200': '#E5E5E5',
                '300': '#D4D4D4',
                '400': '#A3A3A3',
                '500': '#737373',
                '600': '#525252',
                '700': '#404040',
                '800': '#262626',
                '900': '#171717',
            }
        },

        fontFamily: {
            'sans': ['Nanum Gothic', "sans-serif"],
            'serif': ['Libre Baskerville', "serif"],
            'logo': ['Cormorant Garamond', "serif"],
        }
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
    },

    plugins: [require('@tailwindcss/ui')],
};
