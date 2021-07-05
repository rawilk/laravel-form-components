---
title: Date Picker
sort: 8
---

## Introduction

The `date-picker` component offers an integration with [the flatpickr datepicker library](https://flatpickr.js.org/).
By using it, you can simply add a date and/or time picker to your form with one component.

## Installation

While the `date-picker` component works out-of-the-box when you've [set the directives](/docs/laravel-form-components//{version}/installation#directives),
we recommend that you install and compile the JavaScript libraries before you deploy to production:

- [Alpine.js](https://github.com/alpinejs/alpine) `^2.8`
- [Flatpickr](https://flatpickr.js.org/) `^4.6.9`

Make sure you import flatpickr as `flatpickr` in your JavaScript, and make sure it's available globally:

```js
import flatpickr from 'flatpickr';

window.flatpickr = flatpickr;
```

### Styling

If you pull the `flatpickr` package in via npm, you should import the styles into your stylesheet:

```css
@import '~flatpickr/dist/flatpickr.min.css';
```

Be sure these styles are imported before the styles for this package so we can override the styles for flatpickr correctly.

## Basic Usage

In its most basic usage, you can use it as a self-closing component and pass it a name:

```html
<x-date-picker name="birthday" />
```

This will output the following HTML *(inline JS has been omitted)*
```html
<div class="form-text-container">
    <span class="leading-addon cursor-pointer"
          role="button"
          title="Select a date"
    >
        toggle icon    
    </span>

    <input
        class="form-input form-text has-leading-addon has-trailing-icon"
        name="birthday"
        id="birthday"
        placeholder="Y-m-d"
    />
</div>
```

As you can see, the component sets a couple of nice defaults for your date picker.
The `placeholder` is automatically set the default format used by flatpickr, but this
can easily be changed by passing in the placeholder to the component.

By default, the date picker is set to only open when you click the toggle icon, and it allows
you to type in the input as well. There is also a clear icon that gets inserted by default as well.
All of these options can be toggled on the component.

## Toggle Button

By default, a toggle button with a calendar icon is prepended to the input. Clicking this button will show the calendar
that flatpickr generates. If you want to prevent the button/icon from being displayed, you can set the value to `false`:

```html
<x-date-picker :toggle-icon="false" />
```

> {note} If you disable the toggle button, be sure to set `click-opens` to `true` on the component.

> {tip} You can also change the icon that is used for the toggle button either by setting the `toggle-icon` attribute, or by changing
> it globally [in the config](https://github.com/rawilk/laravel-form-components/blob/{branch}/config/form-components.php#L103).

## Clearing

The date picker component provides a way to clear the selected date out of the box. All you need to do is set `clearable`
to `true` and an icon for clearing the input will be appended to the input.

```html
<x-date-picker name="birthday" clearable />
```

The icon defaults to `heroicon-o-x-circle`, but you can easily customize this icon either [in the config](https://github.com/rawilk/laravel-form-components/blob/{branch}/config/form-components.php#L109), or by setting the `clear-icon` attribute to the icon you want.

## Options

You can pass in options to the date picker via the `options` attribute. This requires you to pass a PHP
array with scalar values. Below is an example where we set mode to "multiple" instead of the default "single" value:

```html
<x-date-picker name="birthday" :options="['mode' => 'multiple']" />
```

For a full reference of all options, please consult [the flatpickr documentation](https://flatpickr.js.org/options/).

### Click Opens

For convenience, we have added a `click-opens` (`clickOpens` option) boolean attribute to the component to easily toggle whether clicking on
the input should open the picker. By default, the component sets this value to `false` to allow typing into the input.
If you enable this option, be aware that you might lose the ability to type into the input.

### Allow Input

The boolean `allow-input` (`allowInput` option) attribute has been added for convenience to easily toggle whether
the user is allowed to enter a date directly into the input field. By default, the component sets this value to `true`.

### Enable Time

The boolean `enable-time` (`enableTime` option) attribute has been added for convenience to allow for a time picker
to be available as well. By default, the component sets this value to `false`.

### Format

If you pass a format (e.g. `Y-m-d`) attribute to the component, it will set the `dateFormat` option on flatpickr. This option
defines how the date is displayed in the input, but **also how it is sent to the server**.

> {note} Please note that only scalar values are supported. You cannot use any JavaScript language specific options
> like callbacks.

## Callbacks

Since the `options` attribute only accepts scalar values, the component offers a `optionsSlot` slot that will allow you to
specify any option callbacks you need to:

```html
<x-date-picker name="birthday">
    <x-slot name="optionsSlot">
        onOpen: (selectedDates, dateStr, instance) => {
            // ...
        }
    </x-slot>
</x-date-picker>
```

In the example above, we are injecting a callback for the `onOpen` event fired by flatpickr into the flatpickr options object.
For more information on the callbacks available, please consult [the events api](https://flatpickr.js.org/events/).

## Addons

Like the other inputs, the date picker can also have leading and trailing addons, however by default you cannot add them.
To add leading addons, you must disable the toggle icon, and for trailing addons, you must set `clearable` to `false`.

See the [input documentation](/docs/laravel-form-components//{version}/components/input#addons) for more information.
