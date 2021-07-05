---
title: Password
sort: 3
---

## Introduction

The `password` component offers an easy way to set up a password input field for your forms. By simply setting the `name` attribute it also automatically defines your `id` and the `type` attribute.

## Requirements

By default, the component shows a toggle icon, which allows the user to show and hide the password. The use of this feature requires:

- AlpineJS
- Blade Heroicons (different icons can be specified in the config file)
- Proper tailwind configuration

As of version 1.4.10, you will need to specify a `focus-within` utility for the `box-shadow` styles so that focus can be properly shown
on the password inputs that are toggleable. In your `tailwind.config.js` file, you should add the following variant to it:

```js
module.exports = {
    // ...
    variants: {
        boxShadow: ['responsive', 'hover', 'focus', 'focus-within'],
    },
}
```

> {note} If you are using Tailwind's JIT, you shouldn't need to specify these variants anymore.

See the [Tailwind documentation](https://tailwindcss.com/docs/pseudo-class-variants#focus-within) for more information.

## Basic Usage

The most basic usage of the component is as follows:

```html
<x-password name="password" />
```

The show and hide icons can be configured via config:

```php
'components' => [
    ...
    'password' => [
        ...
        'show_password_icon' => 'heroicon-s-eye',
        'hide_password_icon' => 'heroicon-o-eye-off',
    ],
    ...
],
```

## Show Password Toggle

If you do not want to show the toggle icon for the input, you can disable it by setting `show-toggle` to `false`. You should also disable it if you don't have alpine or blade heroicons installed.

```html
<x-password name="password" :show-toggle="false" />
```

## Old Values

Unlike the other inputs, the password component will not set the value unless the password is flashed to the session by your backend.

## Addons

Like the other inputs, the password input can also have leading addons, but since the package
includes a password toggle as a trailing icon addon, you are not able to add a trailing addon
to the password input. If you need a trailing addon, you should use the input component instead.

See the [input documentation](/docs/laravel-form-components/{version}/inputs/input#addons) for more information.
