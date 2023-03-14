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

### Via Default Slot

Another way is to use the default slot on the component:

```html
<x-select name="state">
    <option value="al">Alabama</option>
    <option value="wi">Wisconsin</option>
</x-select>
```

> {note} When using the default slot, the select component will not be able to determine if the options in the slot are selected or not automatically for you.

### Via The Append Slot

You can also use the `append` slot if you are passing in options via the `options` attribute, and it will
add your slotted options **after** the passed in options:

```html
<x-select name="state" :options="['ny' => 'New York']">
    <x-slot name="append">
        <option value="al">Alabama</option>
        <option value="wi">Wisconsin</option>
    </x-slot>
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

## Reference

Since the select component extends the [input component](/docs/laravel-form-components/{version}/inputs/input), you are able
to do a lot of the same things you can with the input element, such as error handling and addons.
