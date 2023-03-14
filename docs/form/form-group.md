---
title: Form Group
sort: 4
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

The form group will default the input id to the `name` attribute, but you can specify a different id by
using the `input-id` attribute. The `name` attribute will be used for detecting and rendering errors
thrown by your backend validation.

```html
<x-form-group label="First name" name="first_name" input-id="firstName">
    Input element
</x-form-group>
```

## Error Handling

If errors are detected, they will automatically be rendered for you, and the `has-error` class will be added to the form
group root element for styling.

```html
<x-form-group label="First name" name="first_name">
    Input element
</x-form-group>
```

If you use any of the inputs provided by this package, the `aria-describedby` attribute will be set on the input
with the id given to the error message element.

You can disable the showing of error messages in the form group by setting the `show-errors` attribute to `false`:

```html
<x-form-group label="First name" name="first_name" :show-errors="false"
    >...</x-form-group
>
```

## Help Text

You can show form help text by either using the `help-text` attribute or the `helpText` slot:

Via prop:

```html
<x-form-group
    label="First name"
    name="first_name"
    help-text="Some helpful text..."
>
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

## Hint

Similar to help text, you may provide a "hint" text to the user. This will render the "hint" text to the right of the label above an input,
or left-aligned below in input when the form-group is set to `inline`. We like to use this to let an end-user know that the input is
optional.

```html
<x-form-group label="First name" name="first_name" hint="Optional"
    >...</x-form-group
>
```

You can also have the component render the text `Optional` automatically for you by passing in `true` for the `optional` attribute.

```html
<x-form-group label="First name" name="first_name" optional>...</x-form-group>
```

You can customize this text by modifying the config value for `optional_hint_text`.

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

The `form-group-inline` utility class provided by this package splits group into a grid, giving the label
one column, and the input two columns across. If you use an input provided by this package, they default
to full width, but you can limit the width by utilizing a `max-w-*` utility class from tailwind on the element.

### Inline Group Borders

As of v4, by default the form-group component will render a border on top of each inline form group component after the first group.
You can prevent this behavior by passing in `false` to the `border` attribute.

```html
<x-form-group label="First name" name="first_name" inline :border="false"
    >...</x-form-group
>
```

By default, the styles will add some padding to the label's column to center align it with the input, but that
may not always be desirable, such as when rendering form groups form checkbox groups. In cases like this, you can
set the `is-checkbox-group` attribute to `true`, and it will not add padding to the label column.

```html
<x-form-group label="First name" name="first_name" inline is-checkbox-group>
    Input element
</x-form-group>
```

## Margins

As of v4, the form-group component will now add a `mb-5` margin utility class to each form-group component, so each form-group has a little
bit of breathing room from each other. The last form-group child in a container will have no margin bottom because of the `last:mb-0` utility class. If you don't want margins to be added to each form-group, you can do the following:

```html
<x-form-group label="First name" :margin-bottom="false">...</x-form-group>
```

> {tip} To help space your form elements evenly in a form, you could also use a `space-y-*` utility class
> provided by tailwind on the wrapping element (usually `<form>`). This **will take precedence** over the margin
> utility class added by the component.
