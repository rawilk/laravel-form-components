---
title: Checkbox Group
sort: 5
---

## Introduction

The checkbox group allows you to quickly group related checkboxes or radio buttons together in your forms.
This is not a replacement for the form-group component, and should be used inside the form-group component
in your forms.

## Basic Usage

The most basic usage is like this:

```html
<x-checkbox-group>
    <x-checkbox />
    <x-checkbox />
</x-checkbox-group>
```

This will stack the checkboxes on top of each other.

## Inline Groups

By default, the `checkbox-group` is designed to stack your checkboxes and radio inputs, but you can display them inline
with each other, by setting the `stacked` attribute to `false`. This will display the checkboxes in rows of 3 columns.

```html
<x-checkbox-group :stacked="false">
    <x-checkbox />
    <x-checkbox />
</x-checkbox-group>
```

### Inline Group Columns

By default, the checkbox-group renders checkboxes in rows with 3 columns when it is rendered inline. To render a different amount of columns, you can specify the `grid-cols` attribute:

```html
<x-checkbox-group :stacked="false" grid-cols="5"> ... </x-checkbox-group>
```

## Sizing

For convenience, you can size all the radio or checkbox elements the same by using the `inputSize` attribute. If no size is provided, it will use
the config value for radios and checkboxes.

```html
<x-checkbox-group input-size="lg"> ... </x-checkbox-group>
```

For more information on the sizing, checkout the [Sizing](/docs/laravel-form-components/{version}/inputs/checkbox#user-content-sizing) documentation for checkboxes.

## API Reference

### props

| prop        | description                                                                                                 |
| ----------- | ----------------------------------------------------------------------------------------------------------- |
| `stacked`   | A boolean value indicating if the elements should be stacked, or placed in grid columns. Defaults to `true` |
| `gridCols`  | The number of grid columns to use for the elements. Requires `stacked` to be `true`. Defaults to `3`        |
| `inputSize` | The size to make all child inputs. Defaults to the config size for choice.                                  |

### config

The following configuration keys and values can be adjusted for common default behavior
you may want for the checkbox-group element.

```php
'defaults' => [
    'choice' => [
        // Supported: 'sm', 'md', 'lg' (defaults to 'sm' if null)
        'size' => null,
    ],
],
```
