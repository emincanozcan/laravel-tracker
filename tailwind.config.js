const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: ['./resources/views/**/*.blade.php', "./resources/js/**/*.vue"],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },
};
