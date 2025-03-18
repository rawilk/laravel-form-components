---
title: Form Group
sort: 4
---

## Introduction

The form group component can be used to encapsulate an input in order to render a label and error messages
automatically and consistently for you.

## Installation

To take full advantage of the `form-group` component, the following third-party libraries are required:

- Alpine.js

See [Third-Party Assets](/docs/laravel-form-components/{version}/installation#user-content-third-party-assets) on the installation guide for further setup information.

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
<x-form-group label="First name" name="first_name" :show-errors="false">
    ...
</x-form-group>
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

    <x-slot:help-text>Some helpful text...</x-slot:help-text>
</x-form-group>
```

## Hint

Similar to help text, you may provide a "hint" text to the user. This will render the "hint" text to the right of the label above an input,
or left-aligned below in input when the form-group is set to `inline`. We like to use this to let an end-user know that the input is
optional.

```html
<x-form-group label="First name" name="first_name" hint="Optional">
    ...
</x-form-group>
```

You can also have the component render the text `Optional` automatically for you by passing in `true` for the `optional` attribute.

```html
<x-form-group label="First name" name="first_name" optional> ... </x-form-group>
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

The `form-group--inline` utility class provided by this package splits group into a grid, giving the label
one column, and the input two columns across. If you use an input provided by this package, they default
to full width, but you can limit the width by utilizing a `max-w-*` utility class from tailwind on the element.

### Inline Group Borders

By default, the form-group component will render a border on top of each inline form group component after the first group.
You can prevent this behavior by passing in `false` to the `border` attribute.

```html
<x-form-group label="First name" name="first_name" inline :border="false">
    ...
</x-form-group>
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

The form-group component will now add a `mb-5` margin utility class to each form-group component, so each form-group has a
bit of breathing room from each other. The last form-group child in a container will have no margin bottom because of the `last:mb-0` utility class. If you don't want margins to be added to each form-group, you can do the following:

```html
<x-form-group label="First name" :margin-bottom="false"> ... </x-form-group>
```

> {tip} To help space your form elements evenly in a form, you could also use a `space-y-*` utility class
> provided by tailwind on the wrapping element (usually `<form>`). This **will take precedence** over the margin
> utility class added by the component.

## Label Ids

Thanks to our `x-form-group` directive, the labels inside a form-group component will have their id scoped using Alpine's `x-id` functionality. That means
every time a component inside the form group references the label's id (`$id('fc-label')`), it will always receive the correct id. The most common use case for this
for the custom-select component which relies on it this for setting the `aria-labelledby` attribute.

If you have a non-standard input, it is generally a best practice to set these accessibility attributes. Inside a form-group, you can always do the following the get
the label's id:

```html
<x-form-group label="Foo">
    <div :aria-labelledby="$id('fc-label')">...</div>
</x-form-group>
```

Both the label, and the aria-labelledby attribute will have `fc-label-1` for the attribute value.

## API Reference

### props

| prop              | description                                                                                                                          |
| ----------------- | ------------------------------------------------------------------------------------------------------------------------------------ |
| `name`            | The name of the input element inside the form group                                                                                  |
| `inputId`         | The ID of the input element inside the form group. Defaults to `name` if not set. Will be used for the `for` attribute on the label. |
| `label`           | Text for a label to render in the form group. Set value to `false` to hide the label                                                 |
| `inline`          | A boolean value indicating if the label and input should be inline with each other in a grid. Defaults to `false`                    |
| `showErrors`      | A boolean indicating whether or not to show error states and messages for the input. Defaults to `true`                              |
| `helpText`        | Helper text to display underneath the input and errors (if shown)                                                                    |
| `isCheckboxGroup` | A boolean value, that if set to `true`, will remove all padding from the top of the input element area. Defaults to `false`          |
| `marginBottom`    | A boolean value to indicate the form group should apply a margin bottom if it is not the last child. Defaults to `true`              |
| `border`          | A boolean value to indicate that an inline form group should show a border if it is not the first child. Defaults to `true`          |
| `hint`            | Provide a "hint" text, such as "Optional" for the user.                                                                              |
| `optional`        | Provides an indication to the user that the input is optional. Will set the `hint` attribute to "Optional" if not explicitly set     |

### slots

| slot       | description                                                                        |
| ---------- | ---------------------------------------------------------------------------------- |
| `hint`     | Provide a "hint" text, such as "Optional" for the user.                            |
| `helpText` | Helper text to display underneath the input and errors (if shown)                  |
| `after`    | Provides a place to put any custom markup towards the end of the main content area |

### config

The following configuration keys and values can be adjusted for common default behavior
you may want for the form-group element.

```php
'defaults' => [
    'global' => [
        // Show error states by default.
        'show_errors' => true,
    ],

    'form_group' => [
        // Apply a CSS class to the root form group element globally.
        'class' => null,

        // Apply a margin bottom by default to form groups (except for last child).
        'margin_bottom' => true,

        // Render a border on top of each form group by default.
        // Does not render on first of type form groups in a container.
        // This option only applies to inline form groups as well.
        'border' => true,

        // Make all form groups show the label inline with the input by default.
        'inline' => false,

        // Apply a CSS class to the form group label container globally.
        'label_container_class' => null,

        // Apply a CSS class to the form group content globally.
        'content_class' => null,
    ],
],
```

### directives

These directives are used internally by the component and aren't necessary for you to reach for yourself.

**x-form-group**

The main directive for the form group, and is applied to the root. This directive scopes the
id for a label using Alpine's `x-id` directive.

**x-form-group:label**

A directive used to attach a click event listener onto the label inside a form group. This click event listener will
give focus to a custom-select or quill rich text editor instance if one is present in the form group.
