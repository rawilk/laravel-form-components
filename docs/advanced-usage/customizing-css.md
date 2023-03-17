---
title: Customizing CSS
sort: 1
---

If you want to change the look of the form components to match the style of your own app, you have multiple options.

## Option 1: Use Your Own Tailwind CSS Configuration
You can import the `index.css` and run every `@apply` rule through your own `tailwind.config.js`.

```css
/* app.css */

@tailwind base;
@tailwind components;
@tailwind utilities;

@import '../../vendor/rawilk/laravel-form-components/resources/css/index.css';

/* override our styles here */
```

> {note} If you choose this option, make sure you have the [required variants](#user-content-required-variants) included in your `tailwind.config.js` configuration.

You may also import only the stylesheets you need instead of everything in the index.css file. Most components have their own stylesheets (i.e. `input.css` for input elements).

## Option 2: Copy the CSS To Your Own Project
If you want full-control, you can always copy the each of the stylesheets from `resources/css` to your own project and go wild. In this example, we renamed the file to `custom/laravel-form-components.css`.
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
    /*@apply bg-slate-50 cursor-not-allowed;*/
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
                slate: colors.slate,
            },
        },
    },
};
```

This will extend the default tailwind color palette to include the `slate` color variant.

> {note} If you have a custom color palette configured, you will need to make sure you have the `blue` and `red` colors configured as well, with all
> levels available (`50` through `900`).

Certain components make use of a custom utility class called `outline-slate`, which adds a 2px dotted outline around the element when focused. If you opt to not add this outline variant to your configuration, it will not affect building the CSS since the package's stylesheet does not reference it; the outline variant is only rendered directly onto the elements it's used for. If you want the outline to show up, you can add the following to a stylesheet in a `@layer utilities`:

```css
@layer utilities {
    .outline-slate {
        outline: 2px dotted theme('colors.slate.400');
        outline-offset: 2px;
    }
}
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
@import '../../vendor/rawilk/laravel-form-components/resources/css/index.css';
/* purgecss end ignore */
```
