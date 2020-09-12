---
title: Form Error
sort: 11
---

## Introduction

The `form-error` component provides an easy way to work with Laravel's `$error` message bag
in its Blade views. You can use it to display error messages for form fields.

This isn't a component you will usually reach for, as in most cases you will probably
want to use the `form-group` component to render the label and errors automatically
for you, but this component is available to use for other use cases you may have.

## Basic Usage

Imagine we have the following validation error:

```php
['first_name' => 'Incorrect first name.']
```

The most basic usage of the `form-error` component exists in using it as a self-closing component
using a `name` attribute:

```html
<x-form-error name="first_name" />
```

This will output:

```html
<p class="form-error" id="first_name-error">
    Incorrect first name.
</p>
```

As you can see it'll pick the error message from the `$error` message bag and
render it in the view. If the message isn't set, the HTML isn't rendered.

It also sets the input id automatically from the `name` attribute, but you can easily override it by
setting the `input-id` attribute to the relevant input's id. The input id is used in the `id` attribute,
which can be referenced by an `aria-describedby` attribute on your input element.

## Composing The Content

You can also opt to composing how the rendered content looks too. This allows you to make use of hte component's
`messages()` method to render multiple validation errors at the same time.

Let's assume we have the following validation errors:

```php
[
    'first_name' => [
        'Incorrect first name.',
        'Needs at least 5 characters.',
    ]
]
```

Now we'll use the component's slot and its `messages()` method to render an unordered list of the errors:

```html
<x-form-error tag="ul" name="first_name">
    @foreach ($component->messages($errors) as $error)
        <li>{{ $error }}</li>
    @endforeach
</x-form-error>
```

We also specified the `tag` attribute to change the element tag from the default `p` tag to a `ul` tag.

This will output:

```html
<ul class="form-error" id="first_name-error">
    <li>Incorrect first name.</li>
    <li>Needs at least 5 characters.</li>
</ul>
```

As you can see we need to pass in the `$errors` message bag to the `messages()`
method of the component to grab all the messages for our field. Then we loop over
them and render them.
