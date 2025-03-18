---
title: Date Picker
sort: 8
---

## Introduction

The `date-picker` component offers an integration with [the flatpickr datepicker library](https://flatpickr.js.org/).
By using it, you can simply add a date and/or time picker to your form with one component.

## Installation

The `date-picker` component requires the following third-party libraries to work correctly:

- Alpine.js
- Flatpickr

See [Third-Party Assets](/docs/laravel-form-components/{version}/installation#user-content-third-party-assets) on the installation guide for further setup information.

Make sure you import flatpickr as `flatpickr` in your JavaScript, and make sure it's available globally:

```js
import flatpickr from "flatpickr";

window.flatpickr = flatpickr;
```

### Styling

If you pull the `flatpickr` package in via npm, you should import the styles into your stylesheet:

```css
@import "flatpickr/dist/flatpickr.min.css";
```

> {note} Be sure these styles are imported before the styles for this package, so we can override the styles for flatpickr correctly.

## Basic Usage

In its most basic usage, you can use it as a self-closing component and pass it a name:

```html
<x-date-picker name="birthday" />
```

The component sets a couple of nice defaults for your date picker.
The `placeholder` is automatically set the default format used by flatpickr, but this
can easily be changed by passing in the placeholder to the component.

By default, the date picker is set to open when you click the toggle icon, and it allows
you to type in the input as well. There is also a clear icon that gets inserted by default as well.
All of these options can be toggled on the component.

## Toggle Button

By default, a toggle button with a calendar icon is prepended to the input. Clicking this button will show the calendar
that flatpickr generates. If you want to prevent the button/icon from being displayed, you can set the value to an empty string:

```html
<x-date-picker toggle-icon="" />
```

> {note} If you disable the toggle button, be sure to set `click-opens` to `true` on the component. It is set to `true` by default in the config, unless you modified
> that value.

> {tip} You can change the icon that is used for the toggle button either by setting the `toggle-icon` attribute, or by changing
> it globally [in the config](#user-content-config).

## Clearing

The date picker component provides a way to clear the selected date out-of-the-box. All you need to do is set `clearable`
to `true` and an icon for clearing the input will be appended to the input.

```html
<x-date-picker name="birthday" clearable />
```

The icon defaults to `heroicon-m-x-mark`, but you can easily customize this icon either [in the config](#user-content-config), or by setting the `clear-icon` attribute to the icon you want.

## Options

You can pass in options to the date picker via the `options` attribute. This requires you to pass a PHP
array with scalar values. Below is an example where we set mode to "multiple" instead of the default "single" value:

```html
<x-date-picker name="birthday" :options="['mode' => 'multiple']" />
```

For a full reference of all options, please consult [the flatpickr documentation](https://flatpickr.js.org/options/).

> {tip} In this example, we set mode in the options array, however the component also accepts a prop called `mode`, which defaults to `single`.

### Click Opens

For convenience, we have added a `click-opens` (`clickOpens` option) boolean attribute to the component to easily toggle whether clicking on
the input should open the picker. By default, the component sets this value to `false` to allow typing into the input.
If you enable this option, be aware that you might lose the ability to type into the input.

This can be set globally and on a per-element basis.

### Allow Input

The boolean `allow-input` (`allowInput` option) attribute has been added for convenience to easily toggle whether
the user is allowed to enter a date directly into the input field. By default, the component sets this value to `true`.

This can be set globally and on a per-element basis.

### Enable Time

The boolean `enable-time` (`enableTime` option) attribute has been added for convenience to allow for a time picker
to be available as well. By default, the component sets this value to `false`.

This can be set globally and on a per-element basis.

### Format

If you pass a format (e.g. `Y-m-d`) attribute to the component, it will set the `dateFormat` option on flatpickr. This option
defines how the date is displayed in the input, but **also how it is sent to the server**.

This can be set globally and on a per-element basis.

> {note} Please note that only scalar values are supported. You cannot use any JavaScript language specific options
> like callbacks.

## Callbacks

Since the `options` attribute only accepts scalar values, the component offers a `config` slot that will allow you to
specify any option callbacks you need to. The slot will be rendered inside a JavaScript object which will be passed to our
component JavaScript.

```html
<x-date-picker name="birthday">
    <x-slot:config>
        onChange: (selectedDates, dateStr, instance) => { // ... }
    </x-slot:config>
</x-date-picker>
```

In the example above, we are injecting a callback for the `onChange` event fired by flatpickr into the flatpickr options object.
For more information on the callbacks available, please consult [the events api](https://flatpickr.js.org/events/).

> {note} The `onChange` callback is for demonstration purposes only. Our JavaScript is defining a callback for that event already, so it is not
> advised to define your own callback for it.

By default, the date picker component defines a callback for the `onOpen` event fired by flatpickr. Luckily, flatpickr allows an array of callbacks
to be used for this event. You may define your own callbacks for `onOpen` in the `config` slot, and our JavaScript append them to the callbacks array for
the event.

```html
<x-date-picker name="birthday">
    <x-slot:config>
        onOpen: [ function (selectedDates, dateStr, instance) { // do something
        }, ],
    </x-slot:config>
</x-date-picker>
```

In the example above, the `instance` parameter refers to the `flatpickr` instance.

## Addons

Like the other inputs, the date picker can also have leading and trailing addons, however by default you cannot add them.
To add leading addons, you must disable the toggle icon, and for trailing addons, you must set `clearable` to `false`.

See the [addons documentation](/docs/laravel-form-components/{version}/advanced-usage/addons) for more information.

## End Slot

The `end` slot will allow you to render any kind of HTML you need at the very end of the component's markup. Since it is rendered
inside the `x-data` markup, you will have access to the Alpine component data, as well as the `$datePicker` Alpine magic. This slot
shouldn't normally be required, but it's available should feel the need to get creative with your component logic.

See [$datePicker](#user-content-datepicker) for more info on the magic variable.

## API Reference

### props

| prop                  | description                                                                                                   |
| --------------------- | ------------------------------------------------------------------------------------------------------------- |
| `name`                | Name of the input                                                                                             |
| `id`                  | Id of the input. Defaults to name.                                                                            |
| `type`                | Type of input. Defaults to `text`                                                                             |
| `value`               | Value of the input. Gets omitted if `wire:model` or `x-model` is present                                      |
| `containerClass`      | Defines a CSS class to apply to the **container** of the input                                                |
| `size`                | Define a size for the input. Default size is `md`                                                             |
| `showErrors`          | If a validation error is present for the input, it will show the error state on the input                     |
| `extraAttributes`     | Pass an array of HTML attributes to render on the input                                                       |
| `leadingAddon`        | Render text on the left of the input                                                                          |
| `leadingIcon`         | Render an icon on the left of the input                                                                       |
| `inlineAddon`         | Render text inside the input on the left                                                                      |
| `trailingAddon`       | Render text on the right of the input                                                                         |
| `trailingInlineAddon` | Render text inside the input on the right                                                                     |
| `trailingIcon`        | Render an icon on the right of the input                                                                      |
| `options`             | An array of scalar values to configure flatpickr                                                              |
| `mode`                | The mode of date selection. Supports `single`, `multiple`, and `range`. Defaults to `single`                  |
| `clickOpens`          | Allow the date picker to open when the input element is clicked on.                                           |
| `allowInput`          | Allow user to enter a date into the input element directly.                                                   |
| `enableTime`          | Show a time picker                                                                                            |
| `format`              | Define a format for the date to send to the server                                                            |
| `toggleIcon`          | A name for an icon component to show for the toggle button                                                    |
| `clearable`           | If `true`, a button will be appended to the input to clear the value. Requires `clearIcon` to be set as well. |
| `clearIcon`           | The name of an icon component to display in the clear button                                                  |
| `placeholder`         | Text to show as a placeholder. Defaults to a translation key in package's translations.                       |

### slots

| slot                  | description                                                                                           |
| --------------------- | ----------------------------------------------------------------------------------------------------- |
| `before`              | Render HTML before the input and/or leading addons                                                    |
| `after`               | Render HTML after the input and/or trailing addons                                                    |
| `leadingAddon`        | Render text on the left of the input                                                                  |
| `leadingIcon`         | Render an icon on the left of the input                                                               |
| `inlineAddon`         | Render text inside the input on the left                                                              |
| `trailingAddon`       | Render text on the right of the input                                                                 |
| `trailingInlineAddon` | Render text inside the input on the right                                                             |
| `trailingIcon`        | Render an icon on the right of the input                                                              |
| `config`              | Allows you to define JavaScript callbacks for flatpickr. Slot is rendered inside a JavaScript object. |
| `end`                 | Render any kind of HTML at the end of the component markup, but inside of the `x-data` scope.         |

### config

The following configuration keys and values can be adjusted for common default behavior
you may want for the date picker element.

```php
'defaults' => [
    'global' => [
        // Show error states by default.
        'show_errors' => true,
    ],

    'input' => [
        // Supported: 'sm', 'md', 'lg'
        // Applies to all input types except for checkbox/radios and custom select.
        'size' => 'md',

        // Classes applied by default to input parent div.
        // Will also apply to select.
        'container_class' => null,

        // Base input classes applied by default.
        'input_class' => null,
    ],

    'date_picker' => [
        // Allow date picker to open from clicking on the input by default.
        'click_opens' => false,

        // Allow user to modify the text of the input by default.
        'allow_input' => true,

        // Enable the time picker by default.
        'enable_time' => false,

        // Set the default date format. (defaults to y-m-d)
        'format' => null,

        // Set an icon to show on the date picker for an "open" button by default.
        // Set to null to hide it.
        'toggle_icon' => 'heroicon-m-calendar',

        // Allow date pickers to be cleared by a clear button by default.
        'clearable' => true,

        // Set an icon to show on the date picker's clear button by default.
        'clear_icon' => 'heroicon-m-x-mark',

        // Set the default placeholder text for the date picker.
        // For best results, use a translation key as it will be translated automatically by the component.
        'placeholder' => 'form-components::messages.date_picker_placeholder',
    ],
],
```

### $datePicker

A magic variable that exposes information about the current state of the date picker. Under normal use,
you shouldn't need to access this variable. The `end` slot is a convenient way to access it.

| Property     | Description                                                  |
| ------------ | ------------------------------------------------------------ |
| `isDisabled` | A boolean indicating if the date picker is disabled          |
| `flatpickr`  | Exposes the `flatpickr` instance on the component            |
| `hasValue`   | A boolean indicating if the date picker has a value selected |
| `open()`     | A callable that opens up the date picker                     |
