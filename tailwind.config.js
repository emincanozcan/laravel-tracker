const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: ['./resources/views/**/*.blade.php', "./resources/js/**/*.vue"],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Roboto', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },
};
