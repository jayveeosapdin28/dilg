import defaultTheme from 'tailwindcss/defaultTheme';


/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        container: {
            padding: {
                DEFAULT: '15px'
            }
        },
        screens:{
            sm: '640px',
            md: '768px',
            lg: '960px',
            xl: '1330px',
        },
        extend: {
            colors: {
                primary: {
                    '50': '#fff7ed',
                    '100': '#ffedd5',
                    '200': '#fed7aa',
                    '300': '#fdba74',
                    '400': '#fb923c',
                    '500': '#ea580c',
                    '600': '#ea580c',
                    '700': '#c2410c',
                    '800': '#9a3412',
                    '900': '#7c2d12',
                    '950': '#431407',
                },
                secondary: 'rgb(128,128,128)',
                accent: {
                    DEFAULT: 'rgb(255,112,0)',
                    secondary: 'rgb(255,172,74)',
                    tertiary: 'rgb(255,233,201)',
                },
                gray: 'rgb(232,240,241)',
                dark: '#1F2937',
            },
            fontFamily:{
                primary: 'Poppins'
            },
            fontWeight: {
                '100': 100,
                '200': 200,
                '300': 300,
                '400': 400,
                '500': 500,
                '600': 600,
                '700': 700,
                '800': 800,
                '900': 900,
            }
        },
    },

    plugins: [],
};
