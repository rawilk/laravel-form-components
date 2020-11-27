---
title: Upgrade
sort: 4
---

## Upgrading from v1 to v2

Version 2 introduced some breaking changes, which are outlined below:

### Styling

To be compatible with TailwindCSS version 2, some changes were made to the stylesheets for laravel form components. There
were also some changes to how colors are referenced in both the blade templates and the sass files. V2 of `laravel-form-components`
is assuming you have the following variants configured in your `tailwind.config.js` file:

```js
const colors = require('tailwindcss/colors');

module.exports = {
    // ...
    theme: {
        colors: {
            'blue-gray': colors.blueGray,
        },

        extend: {
            colors: {
                primary: {
                    50: colors.blue['50'],
                    100: colors.blue['100'],
                    // continue all the way down to 900
                },
                danger: {
                    50: colors.red['50'],
                    // add keys for 50 - 900 as well
                }
            },
    
            outline: {
                'blue-gray': [`2px dotted ${colors.blueGray['500']}`, '2px'],            
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
