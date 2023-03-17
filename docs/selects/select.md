---
title: Select
sort: 1
---

## Introduction

The `select` component offers an easy way to provide select menus in your forms.
By simply setting the `name` attribute it also automatically defines your `id`
and makes sure old values are respected.

## Basic Usage

The most basic usage of the component involves setting a `name` attribute:

```html
<x-select name="state" />
```

Of course, the `id` attribute can easily be overridden:

```html
<x-select name="state" id="state_id" />
```

## Options

There are multiple ways to provide options to the component. The primary way is to provide an array of options as
key/value pairs. This will allow the select component to automatically determine which option should be selected
(as long as you're not using `wire:model`) for you.

### Via Attribute

```html
<x-select name="state" :options="['al' => 'Alabama', 'wi' => 'Wisconsin']" />
```

You can also provide more complex arrays for the options too.

```html
<x-select 
    name="user"
    :options="[
        ['id' => 1, 'name' => 'User 1'],
        ['id' => 2, 'name' => 'User 2'],
    ]"
>
</x-select>
```

This will set each option's value to the `id`, and the text of the option to the `name`. You can of course customize these fields for each select with the
`valueField` and `labelField` attributes:

```html
<x-select 
    name="user"
    :options="[
        ['value' => 1, 'text' => 'User 1'],
        ['value' => 2, 'text' => 'User 2'],
    ]"
    value-field="value"
    label-field="text"
>
</x-select>
```

You are also able to pass in an array of Eloquent Models to the select as well:

```html
<x-select name="user" :options="\App\Models\User::all()" />
```

### Via Default Slot

Another way to provide options is to use the default slot on the component:

```html
<x-select name="state">
    <option value="al" @selected($component->isSelected('al'))>Alabama</option>
    <option value="wi" @selected($component->isSelected('wi'))>Wisconsin</option>
</x-select>
```

> {note} When using the default slot, the select component will not be able to determine if the options in the slot are selected or not automatically for you. You may
> use the `isSelected` method on the component though for convenience.

### Via The Append Slot

You can also use the `append` slot if you are passing in options via the `options` attribute, and it will
add your slotted options **after** the passed in options:

```html
<x-select name="state" :options="['ny' => 'New York']">
    <x-slot:append>
        <option value="al">Alabama</option>
        <option value="wi">Wisconsin</option>
    </x-slot:append>
</x-select>
```

### Combining Methods

You can also pass in options using multiple methods. For example, if you pass options in using the `options`
attribute, and also via the default slot, your slotted options will be rendered **before** the passed in options:

```html
<x-select name="state" :options="['ny' => 'New York']">
    <option value="al">Alabama</option>
    <option value="wi">Wisconsin</option>
</x-select>
```

## Multiple Select

You can easily create a multiple select by setting `multiple` to `true`:

```html
<x-select
    name="state"
    :options="['al' => 'Alabama', 'wi' => 'Wisconsin']"
    multiple
/>
```

## Opt Groups

The select component can automatically render options as an `<optgroup>` for you without you needing to manually
render the options yourself. The component will check for a `children` property on the option (name of property is configurable).
If it is present, and is not an empty array, the component will render the parent option as an `<optgroup>`, and then loop through
each of the children and render them as normal options.

> {note} The children options should have the same property structure as the parent option does.
 
## Addons

The select component supports most of the available addons this package offers. Header over to the [Addons](/docs/laravel-form-components/{version}/advanced-usage/addons) documentation
for an in-depth guide on how to use them.

## API Reference

### props

| prop | description                                                                                |
| --- |--------------------------------------------------------------------------------------------|
| `name` | Name of the select                                                                         |
| `id` | Id of the select. Defaults to `name`.                                                      |
| `value` | Value of the select. Gets omitted if `wire:model` or `x-model` is present                  |
| `containerClass` | Defines a CSS class to apply to the **container** of the select                            |
| `size` | Define a size for the select. Default size is `md`                                         |
| `showErrors` | If a validation error is present for the select, it will show the error state on the input |
| `extraAttributes` | Pass an array of HTML attributes to render on the select                                   |
| `leadingAddon` | Render text on the left of the select                                                      |
| `leadingIcon` | Render an icon on the left of the select                                                   |
| `inlineAddon` | Render text inside the input on the select                                                 |
| `trailingAddon` | Render text on the right of the select                                                     |
| `trailingInlineAddon` | Render text inside the input on the select                                                 |
| `trailingIcon` | Render an icon on the right of the select                                                  |
| `multiple` | Allow muti-select mode |
| `options` | An array or Collection of options to render |
| `valueField` | Property on an option to use for the value |
| `labelField` | Property on an option to use for the text |
| `disabledField` | Property on an option to use to determine if it is disabled |
| `childrenField` | Property on an option to determine if it has children. Will render as an `<optgroup>` if children is present and not empty |

### slots 

| slot | description                                               |
| --- |-----------------------------------------------------------|
| `append` | Render options after passed in options have been rendered |
| `before` | Render HTML before the select and/or leading addons       |
| `after` | Render HTML after the select and/or trailing addons       |
| `leadingAddon` | Render text on the left of the select                     |
| `leadingIcon` | Render an icon on the left of the select                  |
| `inlineAddon` | Render text inside the select on the left                 |
| `trailingAddon` | Render text on the right of the select                    |
| `trailingInlineAddon` | Render text inside the select on the right                |
| `trailingIcon` | Render an icon on the right of the select                 |

### config

The following configuration keys and values can be adjusted for common default behavior
you may want for the select element.

```php
'defaults' => [
    'global' => [
        // Show error states by default.
        'show_errors' => true,    
        
        // Set the fields to use by default for properties on options in select components.
        'value_field' => 'id',
        'label_field' => 'name',
        'disabled_field' => 'disabled',
        'children_field' => 'children',
    ],

    'input' => [
        // Supported: 'sm', 'md', 'lg'
        // Applies to all input types except for checkbox/radios and custom select.
        'size' => 'md',

        // Classes applied by default to input parent div.
        // Will also apply to select.
        'container_class' => null,
    ],
    
    'select' => [
        // Automatically apply a CSS class to each select.
        'input_class' => null,
    ],
],
```
