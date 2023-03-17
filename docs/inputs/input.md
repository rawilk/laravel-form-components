---
title: Input
sort: 1
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

By default, a `text` type will be set for the input field as well as an `id` that allows
it to be easily referenced by a `label` element.

Of course, you can also specify a `type` and `id` attribute manually too:

```html
<x-input name="confirm_password" id="confirmPassword" type="password" />
```

## Old Values

The `input` component also supports old values that were set. For example, you
might want to apply some validation in the backend and make sure the user doesn't
lose their input data when you show the form again with the validation errors.
When re-rendering the form, the `input` component will remember the old value.

```html
<input
    class="form-input form-text"
    name="search"
    id="search"
    type="text"
    value="Eloquent"
/>
```

> {note} This doesn't apply when using `wire:model` or `x-model`, as livewire or alpine will take care of setting the value instead
> and the component will not set the `value` attribute itself.

## Error Handling

All inputs are capable of detecting if there was a validation error thrown for the given field (based off the `name` attribute).
When there are errors for a field, the `aria-invalid` and `aria-describedby` attributes will be set on the input, and the class
`input-error` will be added to it, allowing you to add styles targeted towards it.

```html
<div class="form-text-container ...">
    <input
        class="form-input form-text input-error ..."
        name="first_name"
        id="first_name"
        type="text"
        aria-invalid="true"
        aria-describedby="first_name-error"
    />
</div>
```

The actual error message won't be rendered from the input component itself, but it can be automatically rendered for you
by wrapping the `<x-input />` component inside an `<x-form-group />` component. Please refer to the [form-group documentation](/docs/laravel-form-components/{version}/form/form-group#user-content-error-handling) for more information.

The `aria-describedby` attribute takes the `name` attribute and appends `-error` to it, which will be the id given to the error message rendered by the `<x-form-group />` component. If you already have `aria-describedby` set on the input, the attribute
value will be merged with the error attribute value.

If you don't want error attributes to be added to the input, you may disable them via the `show-errors` attribute:

```html
<x-input name="search" :show-errors="false" />
```

> {tip} If you find yourself setting the `show-errors` prop to `false` every time, you may set the global `show_errors` config setting to `false` under the `defaults`
> configuration key.

## Addons

The input component supports all the available addons this package offers. Header over to the [Addons](/docs/laravel-form-components/{version}/advanced-usage/addons) documentation
for an in-depth guide on how to use them.

## Sizing

The package offers three input sizes configured for you out-of-the-box: sm, md, and lg. Inputs by default are configured to render as a "md" sized input, but this can be changed
globally in the config file under `defaults.input.size`. This setting will also affect textareas, native selects, native file upload, and the date picker element. You can also
set the size on a per-element basis using the `size` prop:

```html
<x-input size="lg" />
```

The input sizes are utility classes, which means you can prefix them with screen size breakpoints for further flexibility on sizing your inputs. For example, if you want
your inputs to normally be the "md" size, but on medium size screens and up, you want them to be "lg", you can set your size on the `container-class` prop:

```html
<x-input container-class="md:form-input--lg" />
```

If you want to use your own size utility classes, you will need to define them in your app's CSS. For a quick override on the amount of padding given to each size, you can override the following CSS
variables:

```css
:root {
    --input-padding-y: theme("spacing[2.5]");
    --input-padding-x: theme("spacing.3");
    --input-padding-y-sm: theme("spacing.2");
    --input-padding-x-sm: theme("spacing.2");
    --input-padding-y-lg: theme("spacing.4");
    --input-padding-x-lg: theme("spacing.4");
}
```

## API Reference

### props

| prop                  | description                                                                               |
| --------------------- | ----------------------------------------------------------------------------------------- |
| `name`                | Name of the input                                                                         |
| `id`                  | Id of the input. Defaults to `name`.                                                      |
| `type`                | Type of input. Defaults to `text`                                                         |
| `value`               | Value of the input. Gets omitted if `wire:model` or `x-model` is present                  |
| `containerClass`      | Defines a CSS class to apply to the **container** of the input                            |
| `size`                | Define a size for the input. Default size is `md`                                         |
| `showErrors`          | If a validation error is present for the input, it will show the error state on the input |
| `extraAttributes`     | Pass an array of HTML attributes to render on the input                                   |
| `leadingAddon`        | Render text on the left of the input                                                      |
| `leadingIcon`         | Render an icon on the left of the input                                                   |
| `inlineAddon`         | Render text inside the input on the left                                                  |
| `trailingAddon`       | Render text on the right of the input                                                     |
| `trailingInlineAddon` | Render text inside the input on the right                                                 |
| `trailingIcon`        | Render an icon on the right of the input                                                  |

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
you may want for the input element.

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
],
```
