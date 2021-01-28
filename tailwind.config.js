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
                'sans': ['Fira Sans', "sans-serif"],
                'serif': ['Libre Baskerville', "serif"],
                'logo': ['Cormorant Garamond', "serif"],
            },
            fontSize: {
                'xs': '.75rem',
                'sm': '.875rem',
                'base': '1rem',
                'lg': '1.125rem',
                'xl': '1.25rem',
                '2xl': '1.5rem',
                '3xl': '1.875rem',
                '4xl': '2.25rem',
                '5xl': '3rem',
                '6xl': '4rem',
                '7xl': '5rem',
                '13': '13px',
            },

            colors: {
                gray: {
                    '50': '#FAFAFA',
                    // '100': '#F5F5F5',
                    '100': '#eeeeee',
                    '200': '#E5E5E5',
                    '300': '#D4D4D4',
                    // '400': '#A3A3A3',
                    '400': '#979797',
                    '500': '#737373',
                    '600': '#525252',
                    '700': '#404040',
                    '800': '#262626',
                    '900': '#171717',
                }
            },
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
    },

    plugins: [require('@tailwindcss/ui')],
};
