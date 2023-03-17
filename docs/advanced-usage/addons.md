---
title: Addons
sort: 1
---

## Introduction

Addons provide a way to prepend or append text or an icon to an input. Both leading and trailing addons can be added to the input either by use of props or slots.
When rendering the input, only one type of leading and one type of trailing addon will be rendered at a time.

In the examples shown on this page, we will be using the `input` component, however addons will work with most other components as well.

## Leading Addons

There are three types of "leading" addons offered by this package: leading addon, inline addon, and leading icon. Each of these will be rendered somewhere
on the left side of an input element.

### Leading Addon

A leading addon will be rendered as text on top of a light gray background at the beginning of the input. To render a leading
addon, specify the text either in the `leading-addon` attribute or the `leadingAddon` slot.

Via prop:

```html
<x-input name="url" leading-addon="https://" />
```

Via slot:

```html
<x-input name="url">
    <x-slot:leading-addon>https://</x-slot:leading-addon>
</x-input>
```

### Inline Addon

Inline addon is similar to leading addon, however there is no background behind the text. You are also responsible
for setting the left padding of the input to allow for enough room for your text to fit at the beginning of the
input.

You can set the inline addon by using the `inline-addon` attribute or the `inlineAddon` slot.

Via prop:

```html
<x-input name="url" inline-addon="https://" />
```

Via slot:

```html
<x-input name="url">
    <x-slot:inline-addon>https://</x-slot:inline-addon>
</x-input>
```

To modify the padding, you should use a custom class on the input. Since this padding value is controlled via a [variable](/docs/laravel-form-components/{version}/advanced-usage/customizing-css#user-content-variables),
you could just use an [arbitrary value](https://tailwindcss.com/docs/adding-custom-styles#using-arbitrary-values) in a custom class name:

```html
<x-input
    name="url"
    inline-addon="https://"
    class="![--inline-addon-pl:theme(spacing.4)]"
/>
```

This is the equivalent of `pl-4` on the input. However, it's recommended to override the variable value instead. If you do it this way, you need to be sure to make the rule
`!important` (prefix the class name with `!`) so it actually overrides the variable value.

### Leading Icon

Instead of text, you can prepend an icon to the input instead. The package is styled for
[blade heroicon svgs](https://github.com/blade-ui-kit/blade-heroicons), but you are free
to use whatever icons you want to.

To prepend an icon, you can use the `leading-icon` prop, or the `leadingIcon` slot:

Via prop:

```html
<x-input name="url" leading-icon="heroicon-m-at-symbol" />
```

Via slot:

```html
<x-input name="url">
    <x-slot:leading-icon>
        <x-heroicon-m-at-symbol />
    </x-slot:leading-icon>
</x-input>
```

If you pass the icon name via prop, the component will use the `<x-dynamic-component />` component behind-the-scenes to render the component for convenience.

## Trailing Addons

There are three types of "trailing" addons offered by this package: trailing addon, trailing inline addon, and trailing icon. These all behave like the leading addon version of them, except now they
will be on the right side of the input element.

### Trailing Addon

Like the leading addon, the trailing addon will render text inside a light gray background at the end of the input this time. To render a trailing addon,
specify text in either the `trailing-addon` prop or the `trailingAddon` slot.

Via prop:

```html
<x-input name="url" trailing-addon="lbs" />
```

Via slot:

```html
<x-input name="url">
    <x-slot:trailing-addon>lbs</x-slot:trailing-addon>
</x-input>
```

### Trailing Inline Addon

Like the inline addon, the trailing inline addon will add text directly inside the input, but this time on the right
side of the input. Also like the inline addon, you may need to specify a custom padding amount for the input.

You can add a trailing inline addon by using either the `trailing-inline-addon` attribute or the `trailingInlineAddon` slot.

Via prop:

```html
<x-input name="amount" trailing-inline-addon="USD" />
```

Via slot:

```html
<x-input name="amount">
    <x-slot:trailing-inline-addon>USD</x-slot:trailing-inline-addon>
</x-input>
```

To adjust the amount of padding on the right side on the input, you should override the `--inline-addon-pr` CSS variable. See [Inline Addon](#user-content-inline-addon)
for an example on how to this.

### Trailing Icon

You can append an icon to an input similar to prepending one. You can do so using either the `trailing-icon` prop or the `trailingIcon` slot:

Via prop:

```html
<x-input name="url" trailing-icon="heroicon-m-magnifying-glass" />
```

Via slot:

```html
<x-input name="url">
    <x-slot:trailing-icon>
        <x-heroicon-m-magnifying-glass />
    </x-slot:trailing-icon>
</x-input>
```

If you pass the icon name via prop, the component will use the `<x-dynamic-component />` component behind-the-scenes to render the component for convenience.

## Before Slot

The `before` slot allows you the flexibility to render any kind of HTML you need to directly before the input element. If you have a leading addon on the input, it will render before that markup.

```html
<x-input>
    <x-slot:before>
        <div>Before slot content</div>
    </x-slot:before>
</x-input>
```

## After Slot

The `after` slot allows you the flexibility to render any kind of HTML you need to directly after the input element. If you have a trailing addon on the input, it will render after that markup.

```html
<x-input>
    <x-slot:after>
        <div>After slot content</div>
    </x-slot:after>
</x-input>
```

## Addon Slot Attributes

All types of leading and trailing addons (except the before and after slots) are able to render custom HTML attributes onto the addon markup for you. The only
requirement is that you use the named slot for the addon, and not the prop.

The following example will add an id and an attribute called data-foo onto the leading addon markup for the input.

```html
<x-input>
    <x-slot:leading-addon id="hello-world" data-foo="bar">
        Hello world
    </x-slot:leading-addon>
</x-input>
```

Those attributes will be rendered onto the `<span>` that wraps `Hello world` and **not** onto the input itself.
