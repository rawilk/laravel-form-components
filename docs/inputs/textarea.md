---
title: Textarea
sort: 2
---

## Introduction

The `textarea` component offers an easy way to set up a textarea field for your forms.
By simply setting its `name` attribute it also automatically defines your `id` and makes
sure old values are respected.

## Requirements

If you want to take advantage of the auto-resize functionality of the component, you will need the following installed:

- Alpine.js

See [Third-Party Assets](/docs/laravel-form-components/{version}/installation#user-content-third-party-assets) on the installation guide for further setup information.

## Basic Usage

The most basic usage of the component exists by setting a `name` attribute:

```html
<x-textarea name="about" />
```

By default, a `rows` attribute will be set for the textarea field as well as an `id` that allows
it to be easily referenced by a `label` element. Of course, you can overwrite all of these
values as well:

```html
<x-textarea name="about" id="about_me" rows="5" />
```

## Old Values

The `textarea` component also supports old values that were set. For example, you
might want to apply some validation in the backend and make sure the user doesn't
lose their input data when you show the form again with the validation errors. Whe
re-rendering the form, the `textarea` component will remember the old value:

```html
<div class="form-text-container ...">
    <textarea name="about" id="about" class="form-input form-text ..." rows="3">
About me text</textarea
    >
</div>
```

If you are using livewire, the textarea will allow livewire to set the value instead, however.

## Auto Resize

You can have the textarea auto-resize its height based on its content length. This is enabled by default in the config, but you
can either disable it there or on a per-element basis with the `autoResize` prop:

```html
<x-textarea :auto-resize="false" />
```

Behind-the-scenes, the component will make use of our custom `x-textarea-resize` directive to handle automatically resizing the
textarea for you.

## API Reference

### props

| prop                  | description                                                                               |
| --------------------- | ----------------------------------------------------------------------------------------- |
| `name`                | Name of the textarea                                                                      |
| `id`                  | Id of the input. Defaults to name.                                                        |
| `type`                | Type of input. Defaults to `text`                                                         |
| `value`               | Value of the input. Gets omitted if `wire:model` or `x-model` is present                  |
| `containerClass`      | Defines a CSS class to apply to the **container** of the input                            |
| `size`                | Define a size for the textarea. Default size is `md`                                      |
| `showErrors`          | If a validation error is present for the input, it will show the error state on the input |
| `extraAttributes`     | Pass an array of HTML attributes to render on the textarea                                |
| `leadingAddon`        | Render text on the left of the textarea                                                   |
| `leadingIcon`         | Render an icon on the left of the textarea                                                |
| `inlineAddon`         | Render text inside the textarea on the left                                               |
| `trailingAddon`       | Render text on the right of the textarea                                                  |
| `trailingInlineAddon` | Render text inside the textarea on the right                                              |
| `trailingIcon`        | Render an icon on the right of the textarea                                               |
| `autoResize`          | Resize the textarea automatically as the user types into it. Defaults to config value.    |

### slots

| slot                  | description                                           |
| --------------------- | ----------------------------------------------------- |
| `before`              | Render HTML before the textarea and/or leading addons |
| `after`               | Render HTML after the textarea and/or trailing addons |
| `leadingAddon`        | Render text on the left of the textarea               |
| `leadingIcon`         | Render an icon on the left of the textarea            |
| `inlineAddon`         | Render text inside the textarea on the left           |
| `trailingAddon`       | Render text on the right of the textarea              |
| `trailingInlineAddon` | Render text inside the textarea on the right          |
| `trailingIcon`        | Render an icon on the right of the textarea           |

### config

The following configuration keys and values can be adjusted for common default behavior
you may want for the textarea element.

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

    'textarea' => [
        // How many rows should the textarea have by default.
        'rows' => 3,

        // Automatically resize the textarea based on content length.
        'auto_resize' => true,
    ],
],
```
