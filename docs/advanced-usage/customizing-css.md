---
title: Customizing CSS
sort: 1
---

If you want to change the look of the form components to match the style of your own app, you have multiple options.

## Option 1: Use Your Own Tailwind CSS Configuration
Instead of importing/linking the pre-built `dist/styles.css` from the package, you can import the `src/styles.css` and run every `@apply` rule through your own `tailwind.config.js`.

```css
/* app.css */

@tailwind base;
@tailwind components;
@tailwind utilities;

@import '../../vendor/rawilk/laravel-form-components/resources/js/laravel-form-components-styles/src/styles.css';

/* override our styles here */
```

> {note} If you choose this option, make sure you have the [required variants](#user-content-required-variants) included in your `tailwind.config.js` configuration.

## Option 2: Override Only Portions In Your CSS
If you only want to tinker with certain aspects of the components but like to keep the CSS in sync with future package updates, nothing stops you from overriding only certain CSS rules with your own tweaks. Most DOM elements have their own custom class names.

Let's say your inputs aren't rounded, and you want to remove the border radius from them. To do that, you can write your own CSS for this class:

```css
/* app.css */
...

@import '../../vendor/rawilk/laravel-form-components/resources/js/laravel-form-components-styles/dist/styles.css';
/* or */
@import '../../vendor/rawilk/laravel-form-components/resources/js/laravel-form-components-styles/dist/styles.min.css';

.form-text {
    @apply rounded-none;
}
```

## Option 3: Copy the CSS To Your Own Project
If you want full-control, you can always copy the `src/styles.css` to your own project and go wild. In this example, we renamed the file to `custom/laravel-form-components.css`.
Beware: you will have to manually keep this CSS in sync with changes in future package updates:

```css
/* app.css */

...

@import 'custom/laravel-form-components.css';
```

Let's say you wanted to change the background color of disabled inputs. You could do so like this in the file you just created with the pasted in styles from the package:

```css
/* custom/laravel-form-components.css */

input[disabled],
textarea[disabled],
select[disabled] {
    @apply bg-gray-100;
    
    /* default styles from the package */
    /*@apply bg-blue-gray-50 cursor-not-allowed;*/
}

...
```

## Required Variants
If you choose [Option 1](#user-content-option-1-use-your-own-tailwind-css-configuration), you will need the following color variants added inside your `tailwind.config.js` file:

```js
// tailwind.config.js

const colors = require('tailwindcss/colors');

module.exports = {
    // ...
    theme: {
        extend: {
            colors: {
                'blue-gray': colors.blueGray,
                'cool-gray': colors.coolGray,
            },
        },
    },
};
```

This will extend the default tailwind color palette to include the `blue-gray` and `cool-gray` color variants.

> {note} If you have a custom color palette configured, you will need to make sure you have the `blue` and `red` colors configured as well, with all
> levels available (`50` through `900`).

Certain components make use of a custom utility class called `outline-blue-gray`, which adds a 2px dotted outline around the element when focused. If you opt to not add this outline variant to your configuration, it will not affect building the CSS since the package's stylesheet does not reference it; the outline variant is only rendered directly onto the elements it's used for. If you want the outline to show up, you can add the following to your `tailwind.config.js` file:

```js
// tailwind.config.js

const colors = require('tailwindcss/colors');

module.exports = {
    // ...
    
    theme: {
        extend: {
            colors: {
                // see above snippet for colors
                // ...
            },
            
            outline: {
                'blue-gray': [`2px dotted ${colors.blueGray['500']}`, '2px'],
            },
        },
    },
};
```

## Purge CSS/Tailwind JIT

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
            './vendor/rawilk/laravel-form-components/resources/js/*.js',
        ],
    },
};
```

This configuration should also work when using the JIT compiler from Tailwind.

If some styles are still being purged, it may be useful to wrap the import statement of the package's stylesheet
in a `/* purgecss start ignore */`:

```css
/* purgecss start ignore */
@import '../../vendor/rawilk/laravel-form-components/resources/js/laravel-form-components-styles/dist/styles.css';
/* or */
@import '../../vendor/rawilk/laravel-form-components/resources/js/laravel-form-components-styles/dist/styles.min.css';
/* purgecss end ignore */
```
