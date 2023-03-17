---
title: Checkbox
sort: 6
---

## Introduction

The `checkbox` component offers an easy way to set up a checkbox input field in your forms.
By simple setting its `name` attribute it also automatically sets your `id` attribute and makes
sure old values are respected.

## Basic Usage

The most basic usage of the component exists in setting a `name` attribute:

```html
<x-checkbox name="remember_me" />
```

## Labels

You can easily add a label to a checkbox by using the `label` attribute, or by using the `default slot`:

Via prop:

```html
<x-checkbox name="remember_me" label="Remember" />
```

Via slot:

```html
<x-checkbox name="remember_me"> Remember me </x-checkbox>
```

By default, the label will be placed on the **right** if the checkbox, however you can have it placed on the left side instead by setting the `labelLeft` attribute
to `true`.

```html
<x-checkbox name="remember_me" label="Remember me" label-left />
```

This setting can be set globally in the [config](#user-content-config) or on a per-element basis like shown above.

## Description

You can also add a description (help text) for a checkbox by either setting the `description` attribute or
by using the `description` slot.

Via prop:

```html
<x-checkbox
    name="remember_me"
    label="Remember"
    description="Keep me logged in"
/>
```

```html
<x-checkbox name="remember_me" label="Remember">
    <x-slot:description>Keep me logged in</x-slot:description>
</x-checkbox>
```

By default, this will render the description underneath the label, however you can have it render it inline with the label by setting
the `inlineDescription` attribute to `true`.

```html
<x-checkbox
    name="remember_me"
    label="Remember"
    description="Keep me logged in"
    inline-description
/>
```

This will work on both left and right aligned labels, and can be set globally in the [config](#user-content-config) or on a per-element
basis like shown above.

## Old Values

The `checkbox` component also supports checked values that were set. For example,
you might want to apply some validation in the backend and make sure the user
doesn't lose their input data when you show them the form again with the validation errors.
When re-rendering the form, the `checkbox` component will remember the checked value (when not using `wire:model` or `x-model`):

```html
<input name="remember_me" id="remember_me" type="checkbox" checked />
```

## Sizing

The package offers three different sizes for checkbox and radio elements. By default, they will render as the "sm" size, but this can be changed globally
in the config file under `defaults.choice.size`. You can also set this on a per-element setting using the `size` attribute:

```html
<x-checkbox size="lg" />
```

The input sizes are utility classes, which means you can prefix them with screen size breakpoints for further flexibility on sizing your inputs. For example, if you want
your checkboxes to normally be the "sm" size, but on medium size screens and up, you want them to be "lg", you can set your size on the `container-class` prop:

```html
<x-checkbox container-class="md:form-choice--lg" />
```

## API Reference

### props

| prop | description                                                                                              |
| --- |----------------------------------------------------------------------------------------------------------|
| `name` | Name of the input                                                                                        |
| `id` | Id of the input. Defaults to name.                                                                       |
| `value` | Initial value of the input                                                                               |
| `label` | A label to display next to the checkbox                                                                  |
| `description` | Help text to display underneath the label                                                                |
| `checked` | A boolean value to indicate the checkbox should be checked                                               |
| `containerClass` | Defines a CSS class to apply to the **container** of the input                                           |
| `size` | Set the size of the checkbox element. Supported: `sm`, `md`, `lg`. Defaults to `sm`                      |
| `inlineDescription` | A boolean value indicating the description should be inline with the label. Defaults to `false`          |
| `labelLeft` | A boolean value indicating the label should be rendered to the left of the checkbox. Defaults to `false` |
| `extraAttributes` | Pass an array of HTML attributes to render on the checkbox                                               |

### slots

| slot | description                                                                    |
| --- |--------------------------------------------------------------------------------|
| `label` | A label to display next to the checkbox. Default slot accomplishes same thing. |
| `description` | Help text to display underneath the label. |

### config

The following configuration keys and values can be adjusted for common default behavior
you may want for the checkbox element.

```php
'defaults' => [
    'choice' => [
        // Automatically apply a CSS class to each checkbox/radio container.
        'container_class' => null,

        // Automatically apply a CSS class to each checkbox/radio input.
        'input_class' => null,

        // Supported: 'sm', 'md', 'lg' (defaults to 'sm' if null)
        'size' => null,

        // Show the description inline with the label by default.
        'inline_description' => false,

        // Render the label on the left side of the checkbox/radio by default.
        'label_left' => false,
    ],
],
```
