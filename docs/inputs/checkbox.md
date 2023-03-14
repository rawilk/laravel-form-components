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
    <x-slot name="description">Keep me logged in</x-slot>
</x-checkbox>
```

## Old Values

The `checkbox` component also supports checked values that were set. For example,
you might want to apply some validation in the backend and make sure the user
doesn't lose their input data when you show them the form again with the validation errors.
When re-rendering the form, the `checkbox` component will remember the checked value (when not using `wire:model`):

```html
<input name="remember_me" id="remember_me" type="checkbox" checked />
```
