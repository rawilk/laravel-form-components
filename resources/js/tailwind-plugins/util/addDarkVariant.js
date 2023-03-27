module.exports = (rootObject, selector, darkModeSelector, styles) => {
    if (darkModeSelector === '@media (prefers-color-scheme: dark)') {
        if (! rootObject.hasOwnProperty(selector)) {
            rootObject[selector] = {};
        }

        rootObject[selector][darkModeSelector] = styles;

        return;
    }

    if (! rootObject.hasOwnProperty(darkModeSelector)) {
        rootObject[darkModeSelector] = {};
    }

    rootObject[darkModeSelector][selector] = styles;
};
