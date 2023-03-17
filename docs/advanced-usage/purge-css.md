---
title: Purge CSS
sort: 1
---

## Production Use

Purge CSS is useful for trimming out unused styles from your stylesheets to reduce your overall build size. To ensure
the class styles from this package don't get purged from your production build, you should add the following to your
purge css content configuration:

> {note} The following code snippet is for a TailwindCSS build configuration using a `tailwind.config.js` file in the build.

```js
module.exports = {
    // ...
    purge: {
        content: [
            // Typical laravel app purge css content
            './app/**/*.php',
            './resources/**/*.php',
            './resources/**/*.js',
            
            // Make sure you add these lines
            './vendor/rawilk/laravel-form-components/src/**/*.php',
            './vendor/rawilk/laravel-form-components/resources/**/*.php',
        ],
    },
};
```

If some styles are still being purged, it may be useful to wrap the import statement of the package's stylesheet
in a `/* purgecss start ignore */`:

```css
/* purgecss start ignore */
@import "../../vendor/rawilk/laravel-form-components/resources/sass/form-components";
/* purgecss end ignore */
```

> {tip} Please refer to [styling](/docs/laravel-form-components/{version}/installation#user-content-styling) for more information.
