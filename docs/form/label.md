---
title: Label
sort: 2
---

## Introduction

The `label` component is a small and practical component to use in your forms.
When you set the `for` attribute, it'll generate a `label` tag for a subsequent
input field with the same `id` attribute.

This isn't a component you will usually reach for, as in most cases you will probably
want to use the `form-group` component to render the label and errors automatically
for you, but this component is available to use for other use cases you may have.

> {note} All labels will be provided an id with Alpine's `$id` magic helper. This helps certain components like
> custom-select provide accurate accessibility attributes when in a form-group.

## Requirements

Since the label makes use of Alpine's `$id` magic helper, you will need Alpine.js installed. All labels will get the following attribute applied:

```html
:id="$id('fc-label')"
```

If the ID is not setting on the label, ensure you are placing the label inside some kind of `x-data` scope.

See [Third-Party Assets](/docs/laravel-form-components/{version}/installation#user-content-third-party-assets) on the installation guide for further setup information.

## Basic Usage

The most basic usage of the component is as follows:

```html
<x-label for="first_name" />
```

It's important to note
that only keys with `_` are supported and no camelCased or other variants. You can of course
provide your own label in the default slot:

```html
<x-label for="first_name">My custom label</x-label>
```

## API Reference

### props

| prop  | description                                             |
| ----- | ------------------------------------------------------- |
| `for` | The name (or id) of the input element the label is for. |
