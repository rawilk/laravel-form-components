---
title: Upgrade
sort: 4
---

## Upgrading from v3 to v4

Version 4 introduced some breaking changes, which are outlined below:

### Styling

In v4, laravel-form-components is now inlining a lot of the class names for form components instead of using `@apply` in a stylesheet with a custom class name. For backwards compatibility, the custom class names are still included with each component to prevent breaking any style overrides you may have written. 

Another major change with the styling is laravel-form-components now uses a single `.css` stylesheet for any complex styles required instead of using `.sass` stylesheets. This will allow the usage of postcss and/or tailwind's JIT compiler in your projects with these styles. If you're still using SASS, you should still be able to pull the styles in as you were before; you'll just need to update the path to the stylesheet.

In addition, we have stopped using the `primary` and `danger` variant names in favor of `blue` and `red` respectively. Be sure to update your tailwind config and stylesheets accordingly.

For more info on styling, please see [the Customizing CSS section](/docs/laravel-form-components/advanced-usage/customizing-css).

### Added Dependencies
Some components, such as the `custom-select` component, have a dependency on `Popper.js` now for positioning the menu. This will require you to ensure that dependency is installed in your project. If you customized the package's configuration file, you should make sure you pull in any updates to the configuration as well.

See [the custom select docs](/docs/laravel-form-components/v4/selects/custom-select#installation) for more information.

### Custom Select

One change for the custom-select component is it no longer has the `fixed-position` attribute on it. It now relies on Popper.js for positioning the menu.

### Form Group

One change for the form-group component is now all `inline` form-groups now render a border above each group after the first group. If you do not want borders to be rendered on inline groups, be sure to set `border` to `false`:

```html
<x-form-group label="My label" inline :border="false">...</x-form-group>
```

Another change is all form-groups have a `mb-5` margin bottom utility class added by default for spacing. The last form-group element will have a `sm:mb-0` utility class added to it so no extra margin is applied. You can prevent a margin from being added by setting the `margin-bottom` attribute to `false`:

```html
<x-form-group label="My label" :margin="false">...</x-form-group>
```

> {note} If you are using `space-y-*` utility classes for spacing, those will take precedence over the margin utilities added by the form-group component.

## Upgrading from v2 to v3

The only major requirement for upgrading from v2 is to ensure your server and/or local dev environment is running on php version 8. As with any release,
you should make sure you are re-compiling your css assets (if pulling in the package's styles) and also clear your cached views (`php artisan view:clear`)
to ensure the correct views are being used.

If you published the package's config file, make sure you update it to match any changes made to it.

## Upgrading from v1 to v2

Version 2 introduced some breaking changes, which are outlined below:

### Styling

To be compatible with TailwindCSS version 2, some changes were made to the stylesheets for laravel form components. There
were also some changes to how colors are referenced in both the blade templates and the sass files. V2 of `laravel-form-components`
is assuming you have the following variants configured in your `tailwind.config.js` file:

```js
const colors = require("tailwindcss/colors");

module.exports = {
    // ...
    theme: {
        colors: {
            "blue-gray": colors.blueGray,
        },

        extend: {
            colors: {
                primary: {
                    50: colors.blue["50"],
                    100: colors.blue["100"],
                    // continue all the way down to 900
                },
                danger: {
                    50: colors.red["50"],
                    // add keys for 50 - 900 as well
                },
            },

            outline: {
                "blue-gray": [`2px dotted ${colors.blueGray["500"]}`, "2px"],
            },
        },
    },
};
```

The above configuration is just an example of what this package requires from your tailwind configuration. You are of course free to configure
your colors however you want to, as long as you have variants configured for `primary`, `danger`, and `blue-gray`, and have the `blue-gray` outline
defined as well. If you do not want to configure these colors, you will need to style the form components yourself.

For more information, please see [the docs](https://tailwindcss.com/docs/customizing-colors).

### Custom Select

There have been major changes to the `<x-custom-select>` component.

#### Options

Rendering options through the default slot is no longer supported. You must pass in options via the `options` attribute for now on. "Optgroups" are now
specified by using the `label` key on an option object, and must have an `options` key on the object containing an array or collection of the group's options.

#### `value-key` and `text-key`

If you were using custom keys for the values and text of the options, you will now need to change your attributes from `value-key` to `value-field` and
`text-key` to `text-field` respectively.

#### `wire:filter`

The `wire:filter` attribute on the custom select has been changed to accept a method name from your livewire component instead. The livewire method
must return an array or collection of options.
