---
title: Timezone Select
sort: 3
---

## Introduction

Form Components for Laravel provides a simple way to render a select with timezones. This kind of input can be useful when you need to allow users
to choose what timezone they are in. The timezone select extends the regular select component, so anything you can do with the normal select
can be done with the timezone select.

## Installation

If you choose to render the timezone select as a `custom-select`, the following third-party libraries will need to be installed:

- Alpine.js
- Alpine [Focus Plugin](https://alpinejs.dev/plugins/focus)
- Popper

See [Third-Party Assets](/docs/laravel-form-components/{version}/installation#user-content-third-party-assets) on the installation guide for further setup information.

## Basic Usage

The most basic usage of the timezone select involves setting a name attribute:

```html
<x-timezone-select name="timezone" />
```

## Excluding Regions

You may not always want or need to show a list of every timezone region. You can specify a specific region or group or regions to
be rendered either by using the `timezone_subset` config option, or the `only` prop for a per-case basis.

Via config:

```php
...
'timezone_subset' => [\Rawilk\FormComponents\Support\TimeZoneRegionEnum::America->value],
```

> {note} If you are using php 8.0, you'll need to use the `\Rawilk\FormComponents\Support\TimeZoneRegion` class instead. Note that this
> class is deprecated and will be removed in future versions if php 8.0 support is dropped.

Via prop:

```html
<x-timezone-select name="timezone" :only="['America']" />
```

With both methods, you can use a boolean value `false` to include every timezone region available.

## Custom Select Support

The timezone select can be rendered either as a native select input, or by using the
[custom-select component](/docs/laravel-form-components/{version}/selects/custom-select). To use the custom-select
component, simply pass in a true boolean value for the `use-custom-select` attribute on the timezone select.

```html
<x-timezone-select use-custom-select />
```

By default, the timezone select is configured to use the `custom-select` component, so you'll need to make sure you have
the required third-party assets [installed](#user-content-installation).

## Addons

The timezone select component supports most of the available addons this package offers. Head over to the [Addons](/docs/laravel-form-components/{version}/advanced-usage/addons) documentation
for an in-depth guide on how to use them.

## API Reference

### props

| prop                  | description                                                                                                                             |
| --------------------- | --------------------------------------------------------------------------------------------------------------------------------------- |
| `name`                | Name of the select                                                                                                                      |
| `id`                  | Id of the select. Defaults to `name`.                                                                                                   |
| `value`               | Initial value of the select                                                                                                             |
| `containerClass`      | Defines a CSS class to apply to the **container** of the select                                                                         |
| `size`                | Define a size for the select. Default size is `md`                                                                                      |
| `showErrors`          | If a validation error is present for the select, it will show the error state on the select                                             |
| `extraAttributes`     | Pass an array of HTML attributes to render on the select                                                                                |
| `leadingAddon`        | Render text on the left of the input                                                                                                    |
| `leadingIcon`         | Render an icon on the left of the input                                                                                                 |
| `inlineAddon`         | Render text inside the input on the left                                                                                                |
| `trailingAddon`       | Render text on the right of the input                                                                                                   |
| `trailingInlineAddon` | Render text inside the input on the right                                                                                               |
| `trailingIcon`        | Render an icon on the right of the input                                                                                                |
| `multiple`            | A boolean indicating that multiple timezones can be selected                                                                            |
| `only`                | Specify a subset of timezones to render. Set to `false` for all. Can be a string, or array of strings containing timezone region names. |

Custom select only props.

| prop                 | description                                                                                  |
| -------------------- | -------------------------------------------------------------------------------------------- |
| `useCustomSelect`    | A boolean indicating whether or not to render the select using the `custom-select` component |
| `minSelected`        | In a multi-select, the minimum amount of timezones that must be selected                     |
| `maxSelected`        | In a multi-select, the maximum amount of timezones that may be selected                      |
| `optional`           | A boolean indicating the select is optional                                                  |
| `searchable`         | A boolean indicating the select is filterable                                                |
| `clearable`          | A boolean indicating the value of the select can be cleared                                  |
| `alwaysOpen`         | A boolean value indicating that the menu should always be open                               |
| `buttonIcon`         | A name of an icon component to use for the arrows on the right of the trigger                |
| `clearIcon`          | A name of an icon component to render in the clear button                                    |
| `placeholder`        | Placeholder text to show in the trigger when no option is selected.                          |
| `optionSelectedIcon` | A name of an icon component to render next to an option in the menu when it is selected      |

### slots

| slot                  | description                                         |
| --------------------- | --------------------------------------------------- |
| `before`              | Render HTML before the select and/or leading addons |
| `after`               | Render HTML after the select and/or trailing addons |
| `leadingAddon`        | Render text on the left of the select               |
| `leadingIcon`         | Render an icon on the left of the select            |
| `inlineAddon`         | Render text inside the select on the left           |
| `trailingAddon`       | Render text on the right of the select              |
| `trailingInlineAddon` | Render text inside the select on the right          |
| `trailingIcon`        | Render an icon on the right of the select           |

### config

The following configuration keys and values can be adjusted for common default behavior
you may want for the timezone-select element.

```php
'defaults' => [
    'global' => [
        // Show error states by default.
        'show_errors' => true,
    ],

    'input' => [
        // Supported: 'sm', 'md', 'lg'
        // Applies to all input types except for checkbox/radios.
        'size' => 'md',
    ],

    'custom_select' => [
        // Apply a CSS class by default to the root element of the custom select.
        // Note: this will also apply to tree-select as well.
        'container_class' => null,

        // Apply a CSS class by default to the custom select button.
        'input_class' => null,

        // Apply a CSS class by default to the custom select menu.
        'menu_class' => null,

        // Make custom selects searchable by default.
        'searchable' => true,

        // Make custom selects clearable by default.
        // Will not show the clear button if the select is not optional.
        'clearable' => true,

        // Make custom selects optional by default. When marked as optional, custom select
        // will allow you to clear out its value, unless it has a minimum amount of options
        // required in a multi-select.
        'optional' => false,

        // Set the default icon to use to show that an option is selected.
        // Set to null to disable it.
        'option_selected_icon' => 'heroicon-m-check',

        // Define the name of the icon to show on the custom select button by default.
        // Set to null to hide it.
        'button_icon' => 'heroicon-m-chevron-down',

        // Define the default clear icon that will show on the custom select button and
        // multi-select selected options. Set to null to hide it.
        'clear_icon' => 'heroicon-m-x-mark',

        // In a multi-select, this is the minimum amount of options that must be selected.
        // Set to null or 0 to disable it.
        'min_selected' => null,

        // In a multi-select, this is the maximum amount of options that can be selected.
        // Set to null to disable it.
        'max_selected' => null,
    ],

    'timezone_select' => [
        // Use the custom select component by default for the timezone select.
        'use_custom_select' => true,
    ],
],
```
