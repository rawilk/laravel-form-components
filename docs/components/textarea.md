---
title: Textarea
sort: 6
---

## Introduction

The `textarea` component offers an easy way to set up a textarea field for your forms.
By simply setting its `name` attribute it also automatically defines your `id` and makes
sure old values are respected.

## Basic Usage

The most basic usage of the component exists by setting a `name` attribute:

```html
<x-textarea name="about" />
```

This will output:

```html
<div class="form-text-container">
    <textarea name="about"
              id="about"
              class="form-input form-text" rows="3"></textarea>
</div>
```

By default a `rows` attribute will be set for the textarea field as well as an `id` that allows
it to be easily referenced by a `label` element. Of course, you can overwrite all of these
values as well:

```html
<x-textarea name="about" id="about_me" rows="5" />
```

This will output:

```html
<div class="form-text-container">
    <textarea name="about"
              id="about_me"
              class="form-input form-text" rows="5"></textarea>
</div>
```

## Old Values

The `textarea` component also supports old values that were set. For example, you
might want to apply some validation in the backend and make sure the user doesn't
lose their input data when you show the form again with the validation errors. Whe
re-rendering the form, the `textarea` component will remember the old value:

```html
<div class="form-text-container">
    <textarea name="about"
              id="about"
              class="form-input form-text" rows="3">About me text</textarea>
</div>
```

If you are using livewire, the textarea will allow livewire to set the value instead, however.

## Reference

Since the textarea component extends the [input component](/docs/laravel-form-components/v3/components/input), you are able
to do a lot of the same things you can with the input element, such as error handling and addons.
