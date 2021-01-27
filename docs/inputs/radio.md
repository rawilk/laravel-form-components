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

This will output:

```html
<div class="choice-container">
    <div class="choice-input">
        <input class="form-radio"
               name="tier"
               id="tier_1"
               type="radio"
               value="tier_1" 
        />
    </div>

    <div class="choice-label">
        <label for="tier_1"></label>
    </div>
</div>
<div class="choice-container">
    <div class="choice-input">
        <input class="form-radio"
               name="tier"
               id="tier_2"
               type="radio"
               value="tier_2" 
        />
    </div>

    <div class="choice-label">
        <label for="tier_2"></label>
    </div>
</div>
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
<x-radio name="tier" id="tier_1" value="tier_1">
    Tier 1
</x-radio>
<x-radio name="tier" id="tier_2" value="tier_2">
    Tier 2
</x-radio>
```

Both will output:
```html
<div class="choice-container">
    <div class="choice-input">
        <input class="form-radio"
               name="tier"
               id="tier_1"
               type="radio"
               value="tier_1" 
        />
    </div>

    <div class="choice-label">
        <label for="tier_1">Tier 1</label>
    </div>
</div>
<div class="choice-container">
    <div class="choice-input">
        <input class="form-radio"
               name="tier"
               id="tier_2"
               type="radio"
               value="tier_2" 
        />
    </div>

    <div class="choice-label">
        <label for="tier_2">Tier 2</label>
    </div>
</div>
```

## Description

You can also add a description (help text) for a radio by either setting the `description` attribute or 
by using the `description` slot.

Via prop:
```html
<x-radio name="tier" id="tier_1" value="tier_1" label="Tier 1" description="Our most basic tier" />
```

```html
<x-checkbox name="tier" id="tier_1" value="tier_1" label="Tier 1">
    <x-slot name="description">Our most basic tier</x-slot>
</x-checkbox>
```

Both will output:
```html
<div class="choice-container">
    <div class="choice-input">
        <input class="form-radio"
               name="tier"
               id="tier_1"
               type="radio"
               value="tier_1" 
        />
    </div>

    <div class="choice-label">
        <label for="tier_1">Tier 1</label>
    
        <p class="choice-description">Our most basic tier</p>
    </div>
</div>
```

## Old Values

The `radio` component also supports checked values that were set. For example,
you might want to apply some validation in the backend and make sure the user
doesn't lose their input data when you show them the form again with the validation errors.
When re-rendering the form, the `radio` component will remember the checked value (when not using `wire:model`):

```html
<input name="tier" id="tier_1" value="tier_1" type="radio" checked />
```
