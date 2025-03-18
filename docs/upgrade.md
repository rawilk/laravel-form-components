---
title: Upgrade
sort: 4
---

## Upgrading from v8 to v8.1.0

Although technically there is a breaking change in this version of v8, I've decided against bumping a major version number since the change does not affect functionality of the package.

### Dark Mode

To allow for more flexibility for dark mode configuration in Tailwind, a new `dark-mode` Tailwind plugin has been added, which you will need to add to your project's Tailwind config file.
If your app does not support dark mode, you don't need to worry about this change.

```js
// tailwind.config.js
module.exports = {
    plugins: [
        // ...
        require("./vendor/rawilk/laravel-form-components/resources/js/tailwind-plugins/dark-mode"),
    ],
};
```

The `dark-mode.css` file has also been removed, so if you were manually pulling that into your stylesheets, you will need to remove the reference to it.

## Upgrading from v7 to v8

Several breaking changes were introduced in v8. Please read the following carefully before upgrading. This list may not be fully comprehensive, so be sure to check the
[full changelog](https://github.com/rawilk/laravel-form-components/compare/v7.1.6...v8.0.0) for all changes that have been made. Feel free to PR any important changes that may be missing in this upgrade guide.

### Laravel Version

v8 of laravel-form-components now requires a minimum Laravel version of `9.0`. Be sure to update your project to at least that version.

### Config

If you have the package's config file published, be sure to update it to be compatible with the new config. Here are some notable changes to the config file in v8:

- `components` is now just a simple key/value array of component aliases to class names. Any config to a component done here is now moved to the `defaults` key.
- `defaults` has been added to allow setting default values for common component options. Be sure to refer to the [config file](https://github.com/rawilk/laravel-form-components/blob/main/config/form-components.php) for a complete list of available defaults.
- the `assets` key has been removed, as the package will no longer load in 3rd party cdn assets anymore. Be sure to load them in yourself if you were relying on this in your project.
- the `link_vendor_cdn_assets` key has also been removed.

### Blade Directives

In v8, the package will no longer pull in 3rd party CDN assets for you anymore. We have removed the `@fcScripts` and `@fcStyles` directives, since they are not needed anymore. We have also
renamed the `@fcJavaScript` directive to `@fcScripts`. This directive will only load the JS that is written by the package to power some components.

If using a directive isn't your style, you may also us the new `<fc:scripts />` self-closing tag to load in the package's JS.

### Styling

If you were overriding component definitions to modify their styles, you may not need to do that anymore. In v8, we have removed any Tailwind classes from the markup in the components,
and are instead using `@apply` in the package's CSS to apply the styles to custom class names. This should make it easier to override styles in your own project. Some custom class
names for components have changed as well, so if you are styling them in your own project, you will want to reference the component's markup to get the updated class names.

We've also introduced a number of CSS variables to our stylesheets, which you can override in your own project's CSS to customize many certain aspects of the components using variables instead.
A full reference to the CSS variables can be found in the [variables.css](https://github.com/rawilk/laravel-form-components/blob/{branch}/resources/css/variables.css) file.

### Checkbox Group

The `form-checkbox-group` CSS class is now always applied to the checkbox group component, whether it is stacked or not.

### Custom Select/Tree Select

The custom select component has been re-written in v8. Here are some notable differences:

- Customizing option display in the menu has changed. See [customizing the option display](/docs/laravel-form-components/{version}/selects/custom-select#user-content-customizing-the-option-display) for more info.
- Customizing the selected option has changed. See [customizing the selected option display](/docs/laravel-form-components/{version}/selects/custom-select#user-content-customizing-the-selected-option-display) for more info.
- `is_opt_group` has been deprecated for determining if an option is an "opt group" on custom-select. Provide a non-empty array of "children" on the option itself now. See [Opt Groups](/docs/laravel-form-components/{version}/selects/custom-select#user-content-opt-groups) for more info.
- The `name-value-manually-updated` listener has been removed, as it's not needed.
- `closeOnSelect` has been removed. The component will now automatically close on single selects, but stay open for multi-selects when selecting an option.
- If you were rendering "opt groups" for custom select, you should not flatten your array of options anymore. Custom select will now determine opt groups by the presence of `children` on an option now.

### Switch Toggle

The switch toggle component's markup has been simplified. It now uses a native checkbox input and a single div which relies on Tailwind's peer classes for styling. Some props, such
as `$labelPosition` have been removed. Please refer to the component's documentation for a complete rundown of how to use it in v8.

### FilePond

The way you define filepond callbacks has changed slightly. To define a callback now, you will want to use the `config` slot. Inside the slot, you will have access to
three JS variables: `instance`, `options`, and `pondOptions`. The `instance` variable is the Alpine data object for the component, and the `options` variable is the
options object that is passed to the component. Here's an example of how you could hook into Filepond's `oninit` callback:

```html
<x-slot:config> oninit() { console.log('init', instance); }, </x-slot:config>
```

If you were registering plugins in the `plugins` slot, you will need to move that logic somewhere else, as we have removed this slot. See [Plugins](/docs/laravel-form-components/{version}/files/filepond#user-content-plugins) for more information.

The `watch-value` attribute has been removed. Now any changes to a `wire:model` value will always be picked up by the component.

### Quill

Similar to the FilePond component, the way you define Quill callbacks and options has changed slightly. To define a callback now, you will want to use the `config` slot. You will have
access to the `instance` and `quillOptions` variables. `instance` is the Alpine data object for the component, and `quillOptions` is the options object that is passed to the component.
Here is an example of how you could define a handler for a custom toolbar button:

```html
<x-slot:config>
    toolbarHandlers: { variables: function (value) { const cursorPosition =
    this.quill.getSelection().index; this.quill.insertText(cursorPosition,
    value); this.quill.setSelection(cursorPosition +value.length); }, },
</x-slot:config>
```

If you were listening for a `quill-input` event to be dispatched from the component, you will need to change it to `input`. If you are using `x-model` to bind the value, you may
not need that listener at all since the component has changed how it dispatches and updates values in v8.

### QuillOptions

A `defaults` static constructor has been added to QuillOptions, which should always be used to when defining the Quill options you are using. If you are familiar with the
Password class in Laravel, this is similar to that. The `defaults` constructor can be used in a service provider to define default options you always want to use for Quill.
Here's a quick example of how you could force the "bold" button to always be hidden in your AppServiceProvider.

```php
public function boot()
{
    \Rawilk\FormComponents\Dto\QuillOptions::defaults([
        return (new \Rawilk\FormComponents\Dto\QuillOptions)->hideBold();
    ]);
}
```

Now when you go to use QuillOptions, you can just call `QuillOptions::defaults()`, and the bold toolbar button will always be hidden.

The `withToolbarButton` signature has changed in this configuration object. The `$handler` parameter has been removed in favor of defining the handler in the `config` slot
as shown above.

If you wanted to define a `variables` toolbar button for config example above for Quill, you would do it like this:

```php
QuillOptions::defaults()->withToolbarButton('variables', [
    'Option 1',
    'Option 2',
]);
```

Please refer to the Quill component documentation for more information on how to use this.

### Datepicker

If you need to define custom flatpickr callbacks, you need to use the `config` slot now. For example, if you need to define a custom callback for the `onOpen` event
that is fired by flatpickr, you would do it like this:

```html
<x-slot:config>
    onOpen: function (selectedDates, dateStr, instance) { // do something here.
    },
</x-slot:config>
```

See the [callbacks](/docs/laravel-form-components/{version}/inputs/date-picker#user-content-callbacks) section on date-picker for more information.

### Form Group

The CSS class given to a form group when it is considered inline has changed to `form-group--inline`.

The `custom-select-label` prop has been removed. Form group will automatically give focus to custom selects now when the label is clicked on.

### Timezone Region

The `\Rawilk\FormComponents\Support\TimeZoneRegion` class has been deprecated in favor of the `\Rawilk\FormComponents\Support\TimeZoneRegionEnum` class. If you are running Php 8.1 or higher,
it is recommended to update your code to use the enum class instead. If you are running an older version of Php, you can continue to use the old class, but it will be removed in a future
release.

### File Upload

The file upload component now renders as a native file upload element instead of using a custom button. Because of this, the `label` prop as been removed since the
text of a native file input is not customizable.

### Trailing Addons

The `trailing-addon` prop and slot will now behave like the `leading-addon` prop on components, which will render the text inside a light gray background next to the input.
If you want to the text to be inside the input, use the `trailing-inline-addon` prop/slot instead.

### Inline Addon Padding

The `inline-addon-padding` and `trailing-addon-padding` props have been removed for all inputs. To customize the padding on either side of the input when an inline addon is present,
override either the `--inline-addon-pl` or `--inline-addon-pr` CSS variables instead. Refer to [Inline Addon](/docs/laravel-form-components/{version}/advanced-usage/addons#user-content-inline-addon) for more information.

## Upgrading from v6 to v7

### Laravel Version

v7 of laravel-form-components now requires a minimum Laravel version of `8.70`. Be sure to update your project to at least that version.

### Styling

In v7 we have moved our styles to the `resources/css` directory of this package to help simplify things a little. By default, all styles from
the package are imported into the `index.css` stylesheet, which you can then reference in your own stylesheets. Be sure to update your stylesheet
reference to something like this:

```css
@import "../../vendor/rawilk/laravel-form-components/resources/css/index.css";
```

### Custom Select

The custom select component has been revamped in v7, and as a result some breaking changes were introduced. The following changes should be updated in your own codebase
to continue using this component:

- `textField` is now called `labelField`
- The `valueField` and `labelField` default values have changed to `id` and `name`, respectively
- The `min` and `max` props have changed to `minSelected` and `maxSelected`, respectively
- "Opt Group" options no longer need to contain the group's options, as they won't be rendered automatically. You should flatten your options to a single level now.
- `wire-listeners` is no longer included for updating dependant selects. Your dependant selects should be re-rendered to reflect an update to options now.

## Upgrading from v5 to v6

### Laravel Version

v6 of laravel-form-components now requires a minimum Laravel version of `8.56`. Be sure to update your project to at least that version.

### Overriding component views

In v6, you must publish any package views you want to override instead of specifying a different view in the config. This was done to help
simplify the package config and how the base `BladeComponent` class determines the view to render. You are still free to override any
component classes in the config, however.

### New Component Namespace

Not a breaking change, but the package now defines the `form-components` namespace in addition to providing aliases for each component
in the config. You will now be able to reference components either as `<x-form>` or as `<x-form-components::form>` if you choose to.

## Upgrading from v4 to v5

### Alpine upgrade

The biggest breaking change in version 5 is changing support from alpine.js v2 to v3. This should require only minimal effort however in terms of updating the package.
Based on the [upgrade guide](https://alpinejs.dev/upgrade-guide) from Alpine.js, here is what you should need to do if you are importing Alpine from NPM:

```js
import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
```

This won't affect you if you are using the CDN scripts from the [configuration](https://github.com/rawilk/laravel-form-components/blob/{branch}/config/form-components.php).

### Additional stylesheet option

If you choose to import the compiled styles for this package into your own stylesheets, you can now import a minified stylesheet instead if you want to:

```css
@import "../../vendor/rawilk/laravel-form-components/resources/js/laravel-form-components-styles/dist/styles.min.css";
```

See [customizing css](/docs/laravel-form-components/{version}/advanced-usage/customizing-css#user-content-option-2-override-only-portions-in-your-css) for more information.

## Upgrading from v3 to v4

Version 4 introduced some breaking changes, which are outlined below:

### Styling

In v4, laravel-form-components is now inlining a lot of the class names for form components instead of using `@apply` in a stylesheet with a custom class name. For backwards compatibility, the custom class names are still included with each component to prevent breaking any style overrides you may have written.

Another major change with the styling is laravel-form-components now uses a single `.css` stylesheet for any complex styles required instead of using `.sass` stylesheets. This will allow the usage of postcss and/or tailwind's JIT compiler in your projects with these styles. If you're still using SASS, you should still be able to pull the styles in as you were before; you'll just need to update the path to the stylesheet.

In addition, we have stopped using the `primary` and `danger` variant names in favor of `blue` and `red` respectively. Be sure to update your tailwind config and stylesheets accordingly.

For more info on styling, please see [the Customizing CSS section](/docs/laravel-form-components/{version}/advanced-usage/customizing-css).

### Added Dependencies

Some components, such as the `custom-select` component, have a dependency on `Popper.js` now for positioning the menu. This will require you to ensure that dependency is installed in your project. If you customized the package's configuration file, you should make sure you pull in any updates to the configuration as well.

See [the custom select docs](/docs/laravel-form-components/{version}/selects/custom-select#user-content-installation) for more information.

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
