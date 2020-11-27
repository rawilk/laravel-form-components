---
title: Input
sort: 3
---

## Introduction

The `input` component offers an easy way to set up any type of input field for your forms.
By simply setting its `name` attribute it also automatically defines the `id` and makes sure
old values are respected.

## Basic Usage

The most basic usage of the component exists in setting a `name` attribute.

```html
<x-input name="search" />
```

This will output the following HTML:

```html
<div class="form-text-container">
    <input class="form-input form-text" name="search" id="search" type="text" />
</div>
```

{.tip}
> **Note:** The class 'form-input' comes from Tailwind UI, so be sure to have those styles pulled
> into your project. The class 'form-text' is a custom style from this package, so be sure to include
> the package's stylesheet in your build as well.

By default a `text` type will be set for the input field as well as an `id` that allows
it to be easily referenced by a `label` element.

Of course, you can also specify a `type` and `id` attribute manually too:

```html
<x-input name="confirm_password" id="confirmPassword" type="password" />
```

This will output the following HTML:

```html
<div class="form-text-container">
    <input class="form-input form-text" name="confirm_password" id="confirmPassword" type="password" />
</div>
```

## Old Values

The `input` component also supports old values that were set. For example, you
might want to apply some validation in the backend and make sure the user doesn't
lose their input data when you show the form again with the validation errors.
When re-rendering the form, the `input` component will remember the old value.

```html
<input class="form-input form-text" name="search" id="search" type="text" value="Eloquent" />
```

**Note:** This doesn't apply when using `wire:model`, as livewire will take care of setting the value instead
and the component will not set the `value` attribute itself.

## Error Handling

All inputs are capable of detecting if there was a validation error thrown for the given field (based off the `name` attribute).
When there are errors for a field, the `aria-invalid` and `aria-describedby` attributes will be set on the input, and the class
`input-error` will be added to it, allowing you to add styles targeted towards it.

```html
<div class="form-text-container">
    <input class="form-input form-text input-error" 
           name="first_name"
           id="first_name"
           type="text"
           aria-invalid="true"
           aria-describedby="first_name-error"
    />
</div>
```

The actual error message won't be rendered from the input component itself, but it can be automatically rendered for you
by wrapping the `<x-input />` component inside of a `<x-form-group />` component. Please refer to the [form-group documentation](/docs/laravel-form-components/v2/components/form-group#error-handling) for more information.

The `aria-describedby` attribute takes the `name` attribute and appends `-error` to it, which will be the id given to the error message rendered by the `<x-form-group />` component. If you already have `aria-describedby` set on the input, the attribute
value will be merged with the error attribute value.

If you don't want error attributes to be added to the input, you may disable them via the `show-errors` attribute:

```html
<x-input name="search" :show-errors="false" />
```

## Addons

Both leading and trailing addons can easily be added to the input either by use of props or slots. When rendering the input,
only one type of leading addon and one type of trailing addon will be rendered at a time.

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
    <x-slot name="leadingAddon">https://</x-slot>
</x-input>
```

Both will result in:
```html
<div class="form-text-container">
    <span class="leading-addon">https://</span>
    
    <input class="form-input form-text has-leading-addon" name="url" id="url" type="text" />
</div>
```

### Inline Addon

Inline addon is similar to leading addon, however there is no background behind the text. You are also responsible
for setting the left padding of the input to allow for enough room for your text to fit at the beginning of the
input (defaults to `pl-16 sm:pl-14`) by setting the `inline-addon-padding` attribute.

You can set the inline addon by using the `inline-addon` attribute or the `inlineAddon` slot.

Via prop:
```html
<x-input name="url" inline-addon="https://" />
```

Via slot:
```html
<x-input name="url">
    <x-slot name="inlineAddon">https://</x-slot>
</x-input>
```

Both will output:
```html
<div class="form-text-container">
    <div class="inline-addon">
        <span>https://</span>
    </div>

    <input class="form-input form-text pl-16 sm:pl-14" name="url" id="url" type="text" />
</div>
```

### Leading Icon

Instead of text, you can prepend an icon to the input instead. The package is styled for 
[blade heroicon svgs](https://github.com/blade-ui-kit/blade-heroicons), but you are free
to use whatever icons you want to.

To prepend an icon, use the `leadingIcon` slot:

```html
<x-input name="url">
    <x-slot name="leadingIcon">
        icon svg...
    </x-slot>
</x-input>
```

This will output:

```html
<div class="form-text-container">
    <div class="leading-icon">icon svg...</div>

    <input class="form-input form-text has-leading-icon" name="url" id="url" type="text" />
</div>
```

### Trailing Addon

Like the inline addon, the trailing addon will add text directly inside of the input, but this time at the right
side of the input. Also like the inline addon, you will need to specify the padding yourself (defaults to `pr-12`)
by using the `trailing-addon-padding` attribute.

You can add a trailing addon by using either the `trailing-addon` attribute or the `trailingAddon` slot.

Via prop:
```html
<x-input name="amount" trailing-addon="USD" />
```

Via slot:
```html
<x-input name="amount">
    <x-slot name="trailingAddon">USD</x-slot>
</x-input>
```

Both will output:
```html
<div class="form-text-container">
    <input class="form-input form-text pr-12" name="amount" id="amount" type="text" />
    
    <div class="trailing-addon">
        <span>USD</span>
    </div>
</div>
```

### Trailing Icon

You can append an icon to an input similar to prepending one. You can do so using the `trailingIcon` slot:

```html
<x-input name="search">
    <x-slot name="trailingIcon">search icon...</x-slot>
</x-input>
```

This will output:
```html
<div class="form-text-container">
    <input class="form-input form-text has-trailing-icon" name="search" id="search" type="text" />

    <div class="trailing-icon">search icon...</div>
</div>
```

{.tip}
> **Note:** The leading and trailing addons can also be applied the same way to the textarea, select, email, and password
> inputs provided by this package.
