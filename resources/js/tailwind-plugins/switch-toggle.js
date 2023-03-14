module.exports = function ({ addComponents, theme, config }) {
    const colors = config('theme.colors', {}),
          expectedVariants = ['50', '100', '200', '300', '400', '500', '600', '700', '800', '900'],
          toggles = {};

    for (const colorName in colors) {
        const color = colors[colorName];

        if (typeof color !== 'object') {
            continue;
        }

        if (! expectedVariants.every(key => Object.keys(color).includes(key))) {
            continue;
        }

        toggles[`.switch-toggle--${colorName}`] = {
            '--switch-toggle-bg-checked': color['600'],
            '--switch-toggle-ring-color': color['300'],
            '--switch-toggle-dark-ring-color': color['800'],
        };
    }

    addComponents(toggles);
};
