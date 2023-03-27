module.exports = darkMode => {
    // Example: { darkMode: ['class', '.is-dark'] }
    if (Array.isArray(darkMode)) {
        return darkMode[0] === 'class'
            ? darkMode[1] ?? '.dark'
            : '@media (prefers-color-scheme: dark)';
    }

    return darkMode === 'class'
        ? '.dark'
        : '@media (prefers-color-scheme: dark)';
};
