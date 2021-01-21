---
title: Form Group
sort: 2
---

## Introduction

The form group component can be used to encapsulate an input in order to render a label and error messages
automatically and consistently for you.

## Basic Usage

At its most basic usage, you can render the input group with a label and your markup inside it:

```html
<x-form-group label="First name" name="first_name">
    Input element
</x-form-group>
```

This will render output:

```html
<div class="form-group">
    <label for="first_name" class="form-label">First name</label>

    <div class="form-group__content">
        Input element    
    </div>
</div>
```

The form group will default the input id to the `name` attribute, but you can specify a different id by
using the `input-id` attribute. The `name` attribute will be used for detecting and rendering errors
thrown by your backend validation.

```html
<x-form-group label="First name" name="first_name" input-id="firstName">
    Input element
</x-form-group>
```

This will result in:
```html
<div class="form-group">
    <label for="firstName" class="form-label">First name</label>

    <div class="form-group__content">
        Input element
    </div>
</div>
```

## Error Handling

If errors are detected, they will automatically be rendered for you, and the `has-error` class will be added to the form
group root element for styling.

```html
<x-form-group label="First name" name="first_name">
    Input element
</x-form-group>
```

This will result in:

```html
<div class="form-group has-error">
    <label for="first_name" class="form-label">First name</label>

    <div class="form-group__content">
        Input element
    
        <p class="form-error" id="first_name-error">The error message...</p>
    </div>
</div>
```

If you use any of the inputs provided by this package, the `aria-describedby` attribute will be set on the input
with the id given to the error message element.

You can disable the showing of error messages in the form group by setting the `show-errors` attribute to `false`:

```html
<x-form-group label="First name" name="first_name" :show-errors="false">...</x-form-group>
```

## Help Text

You can show form help text by either using the `help-text` attribute or the `helpText` slot:

Via prop:
```html
<x-form-group label="First name" name="first_name" help-text="Some helpful text...">
    Input element
</x-form-group>
```

Via slot:
```html
<x-form-group label="First name" name="first_name">
    Input element

    <x-slot name="helpText">Some helpful text...</x-slot>
</x-form-group>
```

Both will result in:
```html
<div class="form-group">
    <label for="first_name" class="form-label">First name</label>

    <div class="form-group__content">
        Input element

        <p class="form-help" id="first_name-description">Some helpful text...</p>
    </div>
</div>
```

### Accessibility

If you use help text in the form group, you should also set the `aria-describedby` attribute to the id given
to the help text element on your input element. This will default to "{input_id}-description".

## Inline Form Groups

Instead of stacking the label on top of the input element, you can render them inline with each other. To make
a form group inline, set the `inline` attribute to `true`.

```html
<x-form-group label="First name" name="first_name" inline>
    Input element
</x-form-group>
```

This will output:
```html
<div class="form-group form-group-inline">
    <label for="first_name" class="form-label form-group__inline-label">First name</label>

    <div class="form-group__content form-group__content--inline">
        Input element
    </div>
</div>
```

The `form-group-inline` utility class provided by this package splits group into a grid, giving the label
one column, and the input two columns across. If you use an input provided by this package, they default
to full width, but you can limit the width by utilizing a `max-w-*` utility class from tailwind on the element.

If you want to render a border to the top of the inline form group you can use `border` attribute. **Note:** This only
applies to inline form groups.

```html
<x-form-group label="First name" name="first_name" inline border>
    Input element
</x-form-group>
```

This will output:
```html
<div class="form-group form-group-inline form-group-inline--border">
    <label for="first_name" class="form-label form-group__inline-label">First name</label>

    <div class="form-group__content form-group__content--inline">
        Input element
    </div>
</div>
```

By default, the styles will add some padding to the label's column to center align it with the input, but that
may not always be desirable, such as when rendering form groups form checkbox groups. In cases like this, you can
set the `is-checkbox-group` attribute to `true`, and it will not add padding to the label column.

```html
<x-form-group label="First name" name="first_name" inline is-checkbox-group>
    Input element
</x-form-group>
```

This will output:
```html
<div class="form-group form-group-inline">
    <label for="first_name" class="form-label">First name</label>

    <div class="form-group__content form-group__content--inline">
        Input element
    </div>
</div>
```

> {tip} To help space your form elements evenly in a form, you should use a `space-y-*` utility class
> provided by tailwind on the wrapping element (usually `<form>`).
