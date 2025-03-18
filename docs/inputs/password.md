---
title: Password
sort: 3
---

## Introduction

The `password` component offers an easy way to set up a password input field for your forms. By simply setting the `name` attribute it also automatically defines your `id` and the `type` attribute.

## Requirements

By default, the component shows a toggle icon, which allows the user to show and hide the password. The use of this feature requires:

- Alpine.js
- Blade Heroicons (different icons can be specified in the config file)

See [Third-Party Assets](/docs/laravel-form-components/{version}/installation#user-content-third-party-assets) on the installation guide for further setup information.

## Basic Usage

The most basic usage of the component is as follows:

```html
<x-password name="password" />
```

## Icons

The show and hide icons shown on the toggle button can be set using the `showPasswordIcon` and `hidePasswordIcon` props on the component. By default, they will be set to the value on the config
file for the password input; see [config](#user-content-config) below.

```html
<x-password
    name="password"
    show-password-icon="heroicon-m-eye"
    hide-password-icon="heroicon-m-eye-slash"
/>
```

## Show Password Toggle

If you do not want to show the toggle icon for the input, you can disable it by setting `show-toggle` to `false`. You should also disable it if you don't have alpine or blade heroicons installed.
This can also be done globally via config; see [config](#user-content-config) below.

```html
<x-password name="password" :show-toggle="false" />
```

## Initially Show Password

If you don't want the password to be masked when the input is rendered for the first time, you may pass in `true` for the `intiallyShowPassword` prop.

```html
<x-password initially-show-password />
```

## Old Values

Unlike the other inputs, the password component will not set the value unless the password is flashed to the session by your backend.

## Addons

Like the other inputs, the password input can also have leading addons, but since the package
includes a password toggle as a trailing icon addon, you are not able to add a trailing addon
to the password input. If you need a trailing addon, you should use the input component instead.

See the [addons documentation](/docs/laravel-form-components/{version}/advanced-usage/addons) for more information.

## API Reference

### props

| prop                    | description                                                                                               |
| ----------------------- | --------------------------------------------------------------------------------------------------------- |
| `name`                  | Name of the input                                                                                         |
| `id`                    | Id of the input. Defaults to name.                                                                        |
| `type`                  | Type of input. Defaults to `text`                                                                         |
| `value`                 | Value of the input. Gets omitted if `wire:model` or `x-model` is present                                  |
| `containerClass`        | Defines a CSS class to apply to the **container** of the input                                            |
| `size`                  | Define a size for the input. Default size is `md`                                                         |
| `showErrors`            | If a validation error is present for the input, it will show the error state on the input                 |
| `extraAttributes`       | Pass an array of HTML attributes to render on the input                                                   |
| `leadingAddon`          | Render text on the left of the input                                                                      |
| `leadingIcon`           | Render an icon on the left of the input                                                                   |
| `inlineAddon`           | Render text inside the input on the left                                                                  |
| `trailingAddon`         | Render text on the right of the input                                                                     |
| `trailingInlineAddon`   | Render text inside the input on the right                                                                 |
| `trailingIcon`          | Render an icon on the right of the input                                                                  |
| `showToggle`            | A boolean value to indicate whether or not the toggle button should be shown. Defaults to config value.   |
| `showPasswordIcon`      | A name of the icon to show when the password is masked. Defaults to config value.                         |
| `hidePasswordIcon`      | A name of the icon to show when the password is not masked. Defaults to config value.                     |
| `initiallyShowPassword` | A boolean value indicating if the password should be masked or not on initial render. Defaults to `false` |

> {note} If `showToggle` is `true`, the password component will **not** render any trailing addons, as it needs that spot for the toggle button.

### slots

| slot                  | description                                        |
| --------------------- | -------------------------------------------------- |
| `before`              | Render HTML before the input and/or leading addons |
| `after`               | Render HTML after the input and/or trailing addons |
| `leadingAddon`        | Render text on the left of the input               |
| `leadingIcon`         | Render an icon on the left of the input            |
| `inlineAddon`         | Render text inside the input on the left           |
| `trailingAddon`       | Render text on the right of the input              |
| `trailingInlineAddon` | Render text inside the input on the right          |
| `trailingIcon`        | Render an icon on the right of the input           |

### config

The following configuration keys and values can be adjusted for common default behavior
you may want for the password element.

```php
'defaults' => [
    'global' => [
        // Show error states by default.
        'show_errors' => true,
    ],

    'input' => [
        // Supported: 'sm', 'md', 'lg'
        // Applies to all input types except for checkbox/radios and custom select.
        'size' => 'md',

        // Classes applied by default to input parent div.
        // Will also apply to select.
        'container_class' => null,

        // Base input classes applied by default.
        'input_class' => null,
    ],

    'password' => [
        // Show the password reveal button by default.
        'show_toggle' => true,

        // Icon shown when password is hidden.
        'show_icon' => 'heroicon-m-eye',

        // Icon shown when password is revealed.
        'hide_icon' => 'heroicon-m-eye-slash',
    ],
],
```
