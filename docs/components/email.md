---
title: Email
sort: 4
---

## Introduction

The `email` component offers an easy way to set up an email input field for your
forms. By simply setting its `name` attribute it also automatically sets your `id`
and makes sure old values are respected.

## Basic Usage

The most basic usage of the component is like this:

```html
<x-email name="email" />
```

This will output:

```html
<div class="form-text-container">
    <input class="form-input form-text" name="email" id="email" type="email" />
</div>
```

By default an `email` type will be set for the input field as well as an `id` that allows it to be
easily referenced by a `label` element.

Besides this, the email element behaves exactly the same as the [input component](/docs/laravel-form-components/v3/components/input).
