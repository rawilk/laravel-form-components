---
title: Customizing CSS
sort: 2
---

If you want to change the look of the form components to match the style of your own app, you have multiple options.

## Option 1: Use Your Own Tailwind CSS Configuration

You can import the `index.css` and run every `@apply` rule through your own `tailwind.config.js`.

```css
/* app.css */

@tailwind base;
@tailwind components;
@tailwind utilities;

@import "../../vendor/rawilk/laravel-form-components/resources/css/index.css";

/* override our styles here */
```

> {note} If you choose this option, make sure you have the [required variants](#user-content-required-variants) included in your `tailwind.config.js` configuration.

You may also import only the stylesheets you need instead of everything in the index.css file. Most components have their own stylesheets (i.e. `input.css` for input elements).

## Option 2: Copy the CSS To Your Own Project

If you want full-control, you can always copy each of the stylesheets from `resources/css` to your own project and go wild. In this example, we renamed the file to `custom/laravel-form-components.css`.
Beware: you will have to manually keep this CSS in sync with changes in future package updates:

```css
/* app.css */

... @import "custom/laravel-form-components.css";
```

Let's say you wanted to change the spacing in stacked checkbox groups. You could do so like this in the file you just created with the pasted in styles from the package:

```css
/* custom/laravel-form-components.css */

.form-checkbox-group--stacked {
    @apply space-y-2;

    /* styles from the package */
    /*@apply space-y-4;*/
}

...
```

## Tailwind Configuration

Some custom configuration is necessary to ensure our package's CSS compiles correctly, and that the components are styled correctly.

### Required Variants

If you choose [Option 1](#user-content-option-1-use-your-own-tailwind-css-configuration), you will need the following color variants added inside your `tailwind.config.js` file:

```js
// tailwind.config.js

const colors = require("tailwindcss/colors");

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

This will extend the default tailwind color palette to include the `slate` color variant. There are a few other colors you'll want to make sure you have in your color palette,
such as `blue` and `red`, so if you're using a custom color palette, make sure those colors are included in it. For a comprehensive overview of what colors and utility classes
you'll need in your Tailwind configuration for the package's styles to compile, you can refer to the [variables.css](https://github.com/rawilk/laravel-form-components/blob/{branch}/resources/css/variables.css) file.

### Plugins

The `@tailwindcss/forms` plugin is necessary to for some base styles to be applied to the form components. If you are using the
[switch-toggle](/docs/laravel-form-components/{version}/inputs/switch-toggle) component, you will want to include our custom `switch-toggle` plugin if you plan on rendering it with custom colors.

```js
// tailwind.config.js

module.exports = {
    // ...
    plugins: [
        require("@tailwindcss/forms"),

        // Only necessary if you're going to use the switch-toggle component with different colors
        require("./vendor/rawilk/laravel-form-components/resources/js/tailwind-plugins/switch-toggle"),

        // Only necessary if you're going to support dark mode
        require("./vendor/rawilk/laravel-form-components/resources/js/tailwind-plugins/dark-mode"),
    ],
};
```

### Purge CSS/Tailwind JIT

Purge CSS is useful for trimming out unused styles from your stylesheets to reduce your overall build size. To ensure
the class styles from this package don't get purged from your production build, you should add the following to your
purge css content configuration:

> {note} The following code snippet is for a TailwindCSS build configuration using a `tailwind.config.js` file in the build.

```js
module.exports = {
    // ...
    content: [
        // Typical laravel app purge css content
        "./app/**/*.php",
        "./resources/**/*.php",
        "./resources/**/*.js",

        // Make sure you add these lines
        "./vendor/rawilk/laravel-form-components/src/**/*.php",
        "./vendor/rawilk/laravel-form-components/resources/**/*.php",
        "./vendor/rawilk/laravel-form-components/resources/js/*.js",
    ],
};
```

Due to the dynamic nature of how some classes are rendered onto the markup, you may still find some of them being purged by Tailwind. Here's a few you may want to
add to your `safelist` to prevent from being purged:

```js
module.exports = {
    // ...
    safelist: [
        {
            pattern: /file-upload__input--*/,
        },
        {
            pattern: /switch-toggle--*/,
        },
        {
            pattern: /custom-select__button--*/,
        },
        {
            // For sizing, e.g. form-input--sm
            pattern: /form-input--*/,
        },
        {
            // For checkbox/radio sizing
            pattern: /form-choice--*/,
        },

        // For dark mode...
        {
            // quill editor classes
            pattern: /ql--*/,
        },
        "filepond--panel-root",
        "filepond--root",
    ],
};
```

You can of course be more selective in what you safelist. For example, instead of using a pattern for the `.form-input--` sizing classes, you could just explicitly add
`form-input--lg` to the safelist array instead of using a regex pattern.

## Variables

Some styling for components, such as text color and border colors, can be overridden with CSS variables. For example, if you wanted to override the border color for inputs,
you could add the following to your app's CSS file:

```css
... :root {
    --input-border-color: theme("colors.green.300");
    --input-dark-border-color: theme("colors.green.500");
}
```

> {note} Make sure to override any variables **after** you've imported the package's CSS.

For a full reference of the variables you can set in your CSS, please refer to the [variables.css](https://github.com/rawilk/laravel-form-components/blob/{branch}/resources/css/variables.css) file.

## Dark Mode

The package's components have also been styled for dark mode and will work with both the class based and OS based strategies. A custom dark mode selector is also supported too.

To opt in to dark mode, you will need to add the `dark-mode` plugin to your Tailwind configuration file. See [Plugins](#user-content-plugins) for more information. By default, all
components are styled for dark mode in this plugin. You may opt out of certain components being styled here if you're not using them. Here is an example of all the options you can
pass to the plugin:

```js
// tailwind.config.js

module.exports = {
    plugins: [
        // ...
        require("./vendor/rawilk/laravel-form-components/resources/js/tailwind-plugins/dark-mode")(
            {
                quill: false,
                filepond: false,
            },
        ),
    ],
};
```

For more information, please refer to [Tailwind's Dark Mode Documentation](https://tailwindcss.com/docs/dark-mode).
