---
title: Label
sort: 11
---

## Introduction

The `label` component is a small and practical component to use in your forms.
When you set the `for` attribute, it'll generate a `label` tag for a subsequent
input field with the same `id` attribute.

This isn't a component you will usually reach for, as in most cases you will probably
want to use the `form-group` component to render the label and errors automatically
for you, but this component is available to use for other use cases you may have.

## Basic Usage

The most basic usage of the component is as follows:

```html
<x-label for="first_name" />
```

This will output:

```html
<label for="first_name" class="form-label">First name</label>
```

As you can see it'll generate the title within the `label` tag. It's important to note
that only keys with `_` are supported and no camelcased or other variants. You can of course
provide your own label in the default slot:

```html
<x-label for="first_name">My custom label</x-label>
```

This will output:
```html
<label for="first_name" class="form-label">My custom label</label>
```
