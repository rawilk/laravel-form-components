---
title: Custom Select
sort: 8
---

## Introduction

Heavily based on [Tailwind UI's custom selects](https://tailwindui.com/components/application-ui/forms/select-menus), the `custom-select` component provides a nice alternative
to the native select menu. Using this menu will provide your select menus with search functionalities and
custom option markup while still providing usability functionalities such as keyboard navigation.

## Installation

The custom select component requires Alpine.js, as well as some custom JavaScript written into the package to work.
Ensure you have the proper [directives](/docs/laravel-form-components/{version}/installation#directives) in your layout file.
In production, we recommend you install and compile the JavaScript libraries before you deploy:

- [Alpine.js](https://github.com/alpinejs/alpine) `^2.7`

## Basic Usage

You can use the select menu by providing some basic options.

```html
<x-custom-select :options="['foo', 'bar']" />
```

This will output a custom select menu with options for `foo` and `bar`. The menu is toggled open and closed by using a `<button` element,
and renders each option in an `<li>` tag inside of a `<ul>`. We have done our best to include all of the necessary aria attributes for
accessiblity, but we are by no means accessibility experts. If you notice any accessibility issues, please submit a PR to the github
repository to fix them.

## Options

There are multiple ways ot provide options to the component. The primary way is to provide an array of options via the `options` attribute.
If you provide an array of strings, the component will use the strings as both the key and values of the options. For most cases however, you
should provide an array of keyed arrays for each option, or you can even pass in an array of Eloquent models as options.

```html
<x-custom-select :options="[
    ['value' => 'foo', 'text' => 'Foo'],
    ['value' => 'bar', 'text' => 'Bar'],
]" />

<!-- using models -->
<x-custom-select :options="[\App\Models\User::get(['id', 'name'])]" value-key="id" text-key="name" />
```

### Option Values & Text

By default, the component will look for a `value` key for the option value, and a `text` key for the option text. When you are using Eloquent models
for options, most of the time this won't work. For this reason, you can specify which keys the option should use for the value and text
of the option via `value-key` and `text-key`.

### Manually Creating Options

Instead of passing in options to the custom select component, you can also create your own options via the default slot in the component by
using the `custom-select-option` component. This component accepts an `option` attribute, and optionally a `value-key` attribute for the
option's value, and `text-key` attribute for the option's text content.

```html
<x-custom-select-option :option="$user" value-key="id" text-key="name" />
``` 

The `custom-select-option` also has a default slot which will allow you to customize the markup of the content of the option.

```html
<x-custom-select-option :option="$user" value-key="id" text-key="name">
    {{ $user->name }} <span class="text-xs">@{{ $user->email }}</span>
</x-custom-select-option>
```

In either case, you still need to provide the `option` attribute, and then any value/text mapping you need. The `option` attribute
is used by the package's JavaScript to help with keyboard navigation and also for local [filtering](#server-side-filtering) of options if you
have filters enabled on the select.

> {note} Any content you place inside of the option will also be displayed on the button when the option is selected.

### Disabling Options

You may disable specific options by providing a boolean value of true to the component:

```html
<x-custom-select-option :option="$option" disabled />
```

### Opt Groups

You can specify an option as an "optgroup" header by passing in a boolean true value to the `is-group` attribute:

```html
<x-custom-select-option is-group>Group Name</x-custom-select-option>
```

## Filtering

You may provide search functionality on a custom select by setting `filterable` on the component to `true`.

```html
<x-custom-select :options="$options" filterable />
```

This will provide basic search functionality, which will hide any non-matching options as the user types.

## Server-Side Filtering

If you use Livewire, you can easily add server-side filtering of options via a custom `wire:filter` attribute on the component.

```html
<x-custom-select :options="$options" filterable wire:filter="selectSearch" />
```

Behind-the-scenes, the custom select component will convert that to a `wire:model` on the filter input in the select and bind it to
your public property on your livewire component. From there, you can filter out your options based on the value of the filter. Modifiers
such as `.lazy` or `.defer` are also supported on the `wire:filter` attribute.

```html
<x-custom-select :options="$options" filterable wire:filter.lazy="selectSearch" />
```

## Multiple Select

You can easily make a select accept multiple selected options by using the `multiple` attribute.

```html
<x-custom-select :options="$options" multiple />
```

## Optional Selects

For times that you want to allow users to clear the select option(s), you can mark a custom select as `optional`. This
works for both single and multi-select modes, and provides a clear button next to the selected option text.

```html
<x-custom-select :options="$options" optional />
```

## Fixed Positioning

By default, the custom select menu is positioned absolutely. In most cases, this should be fine, but there
may be times where this breaks the layout of your form. In those cases, you may tell the menu to be
fixed positioned. This will tell the menu to calculate where the menu should be positioned when
it is opened.

```html
<x-custom-select :options="$options" fixed-position />
```

## Addons

The custom select component supports leading addons, but since there are already elements appended to the end
of the button trigger, trailing addons are not supported. For more information on addons, see [the input documentation](/docs/laravel-form-components/{version}/components/input#addons).
