/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/tightenco/ziggy/src/*.php",
    ],
    theme: {
        extend: {
            colors: {
                teal: {
                    50: '#f0fdfa',
                    100: '#ccfbf1',
                    200: '#99f6e4',
                    300: '#5eead4',
                    400: '#2dd4bf',
                    500: '#14b8a6',
                    600: '#0d9488',
                    700: '#0f766e',
                    800: '#115e59',
                    900: '#134e4a',
                },
                orange: {
                    500: '#f97316',
                    600: '#ea580c',
                },
            },
            fontFamily: {
                sans: ['Figtree', 'sans-serif'],
            },
            container: {
                center: true,
                padding: '1rem',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};
