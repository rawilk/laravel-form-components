---
title: Checkbox Group
sort: 9
---

## Introduction

The checkbox group allows you to quickly group related checkboxes or radio buttons together in your forms.
This is not a replacement for the form-group component, and should be used inside of the form-group component
in your forms.

## Basic Usage

The most basic usage is like this:

```html
<x-checkbox-group>
    checkbox 1
    checkbox 2
</x-checkbox-group>
```

This will output:

```html
<div class="space-y-4">
    checkbox 1
    checkbox 2
</div>
```

## Inline Groups

By default, the `checkbox-group` is designed to stack your checkboxes and radio inputs, but you can display them inline
with each other, by setting the `stacked` attribute to `false`. This will display the checkboxes in rows of 3 columns.

```html
<x-checkbox-group :stacked="false">
    checkbox 1
    checkbox 2
</x-checkbox-group>
```

This will output:
```html
<div class="form-checkbox-group">
    checkbox 1
    checkbox 2
</div>
```

If you want a different amount of columns for your groups, you should override the `.form-checkbox-group` class in
your stylesheets.
