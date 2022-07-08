const defaultTheme = require('tailwindcss/defaultTheme');
module.exports = {
    content: [           
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {},
    },
    variants: {
        extend: {
            opacity: ['responsive', 'hover', 'focus', 'disabled'],
        },
    },
    plugins: [
        require('@tailwindcss/aspect-ratio'),
    ],
};