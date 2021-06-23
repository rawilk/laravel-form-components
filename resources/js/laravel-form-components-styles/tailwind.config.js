const colors = require('tailwindcss/colors');

module.exports = {
    // purge: false,

    theme: {
        extend: {
            colors: {
                'blue-gray': colors.blueGray,
                'cool-gray': colors.coolGray,
            }
        }
    }
};
