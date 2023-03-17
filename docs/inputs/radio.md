---
title: Radio
sort: 7
---

## Introduction

The `radio` component offers an easy way to set up a radio input field in your forms.
By simple setting its `name` attribute it also automatically sets your `id` attribute and makes
sure old values are respected.

## Basic Usage

The most basic usage of the component exists in setting a `name` attribute:

```html
<x-radio name="tier" id="tier_1" value="tier_1" />
<x-radio name="tier" id="tier_2" value="tier_2" />
```

## Labels

You can easily add a label to a radio by using the `label` attribute, or by using the `default slot`:

Via prop:

```html
<x-radio name="tier" id="tier_1" value="tier_1" label="Tier 1" />
<x-radio name="tier" id="tier_2" value="tier_2" label="Tier 2" />
```

Via slot:

```html
<x-radio name="tier" id="tier_1" value="tier_1"> Tier 1 </x-radio>
<x-radio name="tier" id="tier_2" value="tier_2"> Tier 2 </x-radio>
```

By default, the label will be placed on the **right** if the radio, however you can have it placed on the left side instead by setting the `labelLeft` attribute
to `true`.

```html
<x-radio name="tier" id="tier_1" value="tier_1" label="Tier 1" label-left />
```

## Description

You can also add a description (help text) for a radio by either setting the `description` attribute or
by using the `description` slot.

Via prop:

```html
<x-radio
    name="tier"
    id="tier_1"
    value="tier_1"
    label="Tier 1"
    description="Our most basic tier"
/>
```

```html
<x-radio name="tier" id="tier_1" value="tier_1" label="Tier 1">
    <x-slot:description>Our most basic tier</x-slot:description>
</x-radio>
```

By default, this will render the description underneath the label, however you can have it render it inline with the label by setting
the `inlineDescription` attribute to `true`.

```html
<x-radio
    name="tier"
    id="tier_1"
    label="Tier 1"
    value="tier_1"
    description="Our most basic tier"
    inline-description
/>
```

## Old Values

The `radio` component also supports checked values that were set. For example,
you might want to apply some validation in the backend and make sure the user
doesn't lose their input data when you show them the form again with the validation errors.
When re-rendering the form, the `radio` component will remember the checked value (when not using `wire:model`):

```html
<input name="tier" id="tier_1" value="tier_1" type="radio" checked />
```

## Sizing

The package offers three different sizes for checkbox and radio elements. By default, they will render as the "sm" size, but this can be changed globally
in the config file under `defaults.choice.size`. You can also set this on a per-element setting using the `size` attribute:

```html
<x-radio size="lg" />
```

The input sizes are utility classes, which means you can prefix them with screen size breakpoints for further flexibility on sizing your inputs. For example, if you want
your radios to normally be the "sm" size, but on medium size screens and up, you want them to be "lg", you can set your size on the `container-class` prop:

```html
<x-radio container-class="md:form-choice--lg" />
```

## API Reference

Since the radio component is just an extension of checkbox, their API is the same. Checkout the full
[Checkbox API Reference](/docs/laravel-form-components/{version}/inputs/checkbox#user-content-api-reference) for more information.
