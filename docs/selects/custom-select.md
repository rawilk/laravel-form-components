---
title: Custom Select
sort: 2
---

## Introduction

Heavily based on [Tailwind UI's custom selects](https://tailwindui.com/components/application-ui/forms/select-menus), the `custom-select` component provides a nice alternative
to the native select menu. Using this menu will provide your select menus with search functionalities and
custom option markup while still providing usability functionalities such as keyboard navigation.

## Installation

The custom select component requires Alpine.js and Popper.js, as well as some custom JavaScript written into the package to work.
Ensure you have the proper [directives](/docs/laravel-form-components/installation#directives) in your layout file.
In production, we recommend you install and compile the JavaScript libraries before you deploy:

-   [Alpine.js](https://github.com/alpinejs/alpine) `^3.8`
-   [Popper.js](https://popper.js.org/) `^2.9.1`

> {tip} See the [JavaScript Dependencies section](/docs/laravel-form-components/{version}/installation#javascript-dependencies) for more information on installing them.

## Basic Usage

You can use the select menu by providing some basic options.

```html
<x-custom-select :options="['foo', 'bar']" />
```

This will output a custom select menu with options for `foo` and `bar`. The menu is toggled open and closed by using a `<div>` element with a `role="button"` attribute,
and renders each option in an `<li>` tag inside of a `<ul>`. We have done our best to include all of the necessary aria attributes for
accessiblity, but we are by no means accessibility experts. If you notice any accessibility issues, please submit a PR to the github
repository to fix them.

## Options

The custom select component accepts either an array or collection via the `options` attribute. You may also render the options yourself via the default slot in the component.
If you provide an array of strings, the component will use the strings as both the key and values of the options. For most cases however, you
should provide an array of keyed arrays for each option, or you can even pass in an array of Eloquent models as options.

```html
<x-custom-select
    :options="[
    ['id' => 'foo', 'name' => 'Foo'],
    ['id' => 'bar', 'name' => 'Bar'],
]"
/>

<!-- using models -->
<x-custom-select :options="\App\Models\User::get(['id', 'name'])" />
```

### Option Values & Text

By default, the component will look for an `id` key for the option value, and a `name` key for the option text. When you are using Eloquent models
for options, sometimes this won't work. For this reason, you can specify which keys the option should use for the value and label
of the option via `value-field` and `label-field`.

### Customizing the option display

If you want more control over the display of an option, you can render your options manually in a `@foreach` loop and use the
`<x-custom-select-option>` component to render each option.

```html
<x-custom-select name="foo">
    @foreach ($options as $option)
    <x-custom-select-option
        value="{{ $option->id }}"
        label="{{ $option->name }}"
    >
        <span class="italic">{{ $option->name }}</span>
    </x-custom-select-option>
    @endforeach
</x-custom-select>
```

> {note} It is important to still pass in the `label` prop to each option as our JavaScript will use that to determine the
> text to display for the selected option.

### Customizing the selected option display

By default, when an option is selected it will display the same text that is provided to it on the `label` prop on the select's trigger.
If you want to display something different for the selected option, you may provide a value to the `selected-label` prop on the option.
This is also possible when not using the options slot on the select by specifying the `selected-label-field` prop on the custom select.

```html
<x-custom-select
    name="foo"
    :options="[
        ['id' => 'foo', 'name' => 'Foo', 'short_name' => 'F'],
        ['id' => 'bar', 'name' => 'Bar', 'short_name' => 'B'],
    ]"
    selected-label-field="short_name"
/>
```

In the example above, when an option is selected, the value for the option's `short_name` will be displayed on the select's trigger instead
of the option's `name` field.

### Disabling Options

You may disable specific options by setting `disabled` to true on the option:

```html
<x-custom-select
    :options="[['value' => 'foo', 'text' => 'Foo', 'disabled' => true]]"
/>
```

You can use a different key for `disabled` on the option, by specifying it via the `disabled-field` attribute on the select.

```html
<x-custom-select
    :options="[['id' => 'foo', 'name' => 'Foo', 'inactive' => true]]"
    disabled-field="inactive"
/>
```

### Opt Groups

You can specify an option as an "optgroup" header by using a `true` value on an `is_opt_group` key on the option:

```html
<x-custom-select
    :options="[
    ['name' => 'Opt Group', 'is_opt_group' => true],
]"
/>
```

> {tip} You can use a different key for the opt group by specifying it for the `is-opt-group-field` on the select.

> {note} As of v7, you should flatten your array of options as the custom select will no longer render an opt group's options
> automatically.

## Filtering

You may provide search functionality on a custom select by setting `searchable` on the component to `true`.

```html
<x-custom-select :options="$options" searchable />
```

This will provide basic search functionality, which will hide any non-matching options as the user types.

> {note} By default `searchable` is set to true on the select component.

## Server-Side Filtering

If you use Livewire, you can easily add server-side filtering of options via the `livewire-search` prop on the component.

```html
<x-custom-select
    :options="$options"
    searchable
    livewire-search="handleSearch"
/>
```

In this example, this will require you to have a method called `handleSearch` on your livewire component. Our JavaScript will
call that method via livewire's JavaScript API, passing it the value of the current search term. Your livewire component
should filter out the options based on the search. The select component debounces the search input so each keystroke is
not triggering another ajax request to your server.

## Multiple Select

You can easily make a select accept multiple selected options by using the `multiple` attribute.

```html
<x-custom-select :options="$options" multiple />
```

### Max selected

With multiple selects, you may limit the number of options a user may select with the `max-selected` prop.

```html
<x-custom-select :options="$options" multiple :max-selected="3" />
```

In this example, the user will only be able to select a maximum of 3 options.

> {note} The component expects an integer value, so be sure to pass an integer type as the value.

### Min Selected

With a multiple select, you may require the user to select a minimum amount of options. You can specify this via the `min-selected` prop.

## Optional Selects

For times that you want to allow users to clear the select option(s), you can mark a custom select as `optional`. This
works for both single and multi-select modes, and provides a clear button next to the selected option text.

```html
<x-custom-select :options="$options" optional />
```

## Positioning

As of v4, the custom-select component makes use of Popper.js for positioning the select menu. This should remove the need for fixed positioning
the select menu now. In addition to positioning the menu when opened, Popper.js will also re-position the menu as needed when the page is scrolled.

## Component Reference

### Props

| Prop               | Type                     | Default        | Description                                                                                                |
| ------------------ | ------------------------ | -------------- | ---------------------------------------------------------------------------------------------------------- |
| name               | `string`, `null`         | `null`         | Name of input                                                                                              |
| id                 | `string`, `null`         | `null`         | ID of input. Defaults to name                                                                              |
| value              | `mixed`                  | `null`         | Current/previous value of input                                                                            |
| options            | `array`, `Collection`    | `[]`           | Options to render in select                                                                                |
| multiple           | `boolean`                | `false`        | Allow multiple selected options                                                                            |
| minSelected        | `int`                    | 1              | Min. amount of options that must be selected                                                               |
| maxSelected        | `null`, `int`            | `null`         | Max amount of options that may be selected                                                                 |
| disabled           | `boolean`                | `false`        | Disable the input                                                                                          |
| labelledby         | `null`, `string`         | `null`         | Add an aria-labelled by to the input                                                                       |
| searchable         | `boolean`                | `true`         | Make select searchable                                                                                     |
| closeOnSelect      | `boolean`                | `false`        | Close the select when an option is selected                                                                |
| autofocus          | `boolean`                | `false`        | Give focus to input on page load                                                                           |
| optional           | `boolean`                | `false`        | Allow value to be cleared                                                                                  |
| clearIcon          | `null`, `string`         | heroicon-o-x   | Icon component name to use - see config                                                                    |
| placeholder        | `bool`, `null`, `string` | See lang file  | Text to use when no value is selected. Use `false` for no placeholder                                      |
| noOptionsText      | `bool`, `null`, `string` | See lang file  | Text to use when no options are available. Use `false` for none                                            |
| noResultsText      | `bool`, `null`, `string` | See lang file  | Text to use when no options are available from searching. Use `false` for none                             |
| showCheckbox       | `null`, `bool`           | `null`         | Show a checkbox/radio next to each option. Defaults to `true` on multi select and `false` on single select |
| valueField         | `string`                 | `id`           | Key to use for the option's value                                                                          |
| labelField         | `string`                 | `name`         | Key to use for the option's label                                                                          |
| selectedLabelField | `string`, `null`         | `null`         | Key to use for the options' label when selected. Defaults to labelField                                    |
| disabledField      | `string`                 | `disabled`     | Key to use to determine if an option is disabled                                                           |
| isOptGroupField    | `string`                 | `is_opt_group` | Key to use to determine if an option is an opt group                                                       |
| extraAttributes    | `string`, `HtmlString`   | `''`           | Extra attributes to render on the component                                                                |
| showErrors         | `boolean`                | `true`         | Show validation error state                                                                                |
| livewire           | `boolean`                | `false`        | If `true`, provides livewire instance to component JavaScript. Will be true if a `wire:model` is provided  |
| livewireSearch     | `null`, `string`         | `null`         | Name of livewire component search method to call                                                           |

### Events

These are the events that our JavaScript will emit.

| Event | Args       | Description                   |
| ----- | ---------- | ----------------------------- |
| input | `newValue` | Emitted when value is updated |

### Listeners

These are JavaScript event listeners our component listens for that you can broadcast to it.

| Listener                     | Args       | Description                                                                          |
| ---------------------------- | ---------- | ------------------------------------------------------------------------------------ |
| :name-value-manually-updated | `newValue` | Update the current value. Replace `:name` with a slugified version of the input name |
