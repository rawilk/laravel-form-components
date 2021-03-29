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
Ensure you have the proper [directives](/docs/laravel-form-componentsvalue-fieldinstallation#directives) in your layout file.
In production, we recommend you install and compile the JavaScript libraries before you deploy:

- [Alpine.js](https://github.com/alpinejs/alpine) `^2.8`
- [Popper.js](https://popper.js.org/) `^2.9.1`

> {tip} See the [JavaScript Dependencies section](/docs/laravel-form-components/v4/installation#javascript-dependencies) for more information on installing them.

## Basic Usage

You can use the select menu by providing some basic options.

```html
<x-custom-select :options="['foo', 'bar']" />
```

This will output a custom select menu with options for `foo` and `bar`. The menu is toggled open and closed by using a `<button>` element,
and renders each option in an `<li>` tag inside of a `<ul>`. We have done our best to include all of the necessary aria attributes for
accessiblity, but we are by no means accessibility experts. If you notice any accessibility issues, please submit a PR to the github
repository to fix them.

## Options

The custom select component accepts either an array or collection via the `options` attribute.
If you provide an array of strings, the component will use the strings as both the key and values of the options. For most cases however, you
should provide an array of keyed arrays for each option, or you can even pass in an array of Eloquent models as options.

```html
<x-custom-select :options="[
    ['value' => 'foo', 'text' => 'Foo'],
    ['value' => 'bar', 'text' => 'Bar'],
]" />

<!-- using models -->
<x-custom-select :options="[\App\Models\User::get(['id', 'name'])]" value-field="id" text-field="name" />
```

### Option Values & Text

By default, the component will look for a `value` key for the option value, and a `text` key for the option text. When you are using Eloquent models
for options, most of the time this won't work. For this reason, you can specify which keys the option should use for the value and text
of the option via `value-field` and `text-field`.

### Customizing the option display

By using the `optionDisplay` slot, you can customize how each option is rendered.

```html
<x-custom-select :options="['foo', 'bar']">
    <x-slot name="optionDisplay">
        <div class="flex items-center space-x-2">
            <span class="block bg-green-500 rounded-full w-4 h-4"></span>
            <span x-html="option.text"></span>            
        </div>
    </x-slot>
</x-custom-select>
```

In this example, we are prepending a green dot in front of the option text for each option. As you can see, any kind of markup
is allowed here, so you are able to add whatever kind of html you need for each option.

Since each option is rendered in an `x-for` loop via alpine, you will need to use directives such as `x-text` or `x-html` to render
an option's text. In the `optionDisplay` slot, you will have access to following JavaScript properties:

- `index`: The index of the current option
- `option`: The JavaScript representation of the current option.

**Note:** Each `option` object will have whatever properties you included on the object when you passed them into the `options` attribute, however they will
always have the `value`, `text`, and `disabled` attributes on each option object. If you have any of those keys on your object, they will be overwritten
when the component parses your options.

### Customizing the selected option display

New in v2, you can customize the button text when there is a selected option via the `buttonDisplay` slot. By default, the `text` of an option is used
as a display in the button, but you can customize this to match how your options are displayed in the dropdown list.

```html
<x-custom-select :options="['foo', 'bar']">
    <x-slot name="buttonDisplay">
        <div class="space-x-2 flex items-center">
            <span class="block w-5 h-5 rounded-full bg-green-500"></span>
            <span x-text="optionDisplay(value)"></span>
        </div>
    </x-slot>
</x-custom-select>
```

Since `value` is the actual value of the selected option, you will need to find the option first and then render the option's text. This has been made easier
by using the component's `optionDisplay()` helper method, which takes the value of the option you're trying to find in as a parameter. If it finds an option,
it will return the `text` of the found option. If you need a different attribute, you can find the option yourself by:

```html
<span x-text="data.find(option => option.value === value).someOtherField"></span>
```

It is recommended to use `data` instead of `options` to find the selected option, since `options` will get mutated if you have a filter in place.

### Disabling Options

You may disable specific options by setting `disabled` to true on the option:

```html
<x-custom-select :options="[['value' => 'foo', 'text' => 'Foo', 'disabled' => true]]" />
```

You can use a different key for `disabled` on the option, by specifying it via the `disabled-field` attribute on the select.

```html
<x-custom-select :options="[['value' => 'foo', 'text' => 'Foo', 'inactive' => true]]" disabled-field="inactive" />
```

### Opt Groups

You can specify an option as an "optgroup" header by using a "label" key on the option object:

```html
<x-custom-select :options="[
    ['label' => 'Opt Group', 'options' => ['foo', 'bar']]
]"/>
```

In this example, an opt group with the label "Opt Group" will be rendered, as well as the options underneath for "foo" and "bar". You must include
the `label` and `options` keys on the optgroup option object.

## Filtering

You may provide search functionality on a custom select by setting `filterable` on the component to `true`.

```html
<x-custom-select :options="$options" filterable />
```

This will provide basic search functionality, which will hide any non-matching options as the user types.

## Server-Side Filtering

If you use Livewire, you can easily add server-side filtering of options via a custom `wire:filter` attribute on the component.

```html
<x-custom-select :options="$options" filterable wire:filter="searchMethod" />
```

In this example, this will require you to have a method called `searchMethod` on your livewire component. Our JavaScript will
call that method via livewire's JavaScript API and expects an array or collection of your filtered options to be returned. The
component debounces the search input by `300ms` so each keystroke is not triggering another ajax request to your server.

## Multiple Select

You can easily make a select accept multiple selected options by using the `multiple` attribute.

```html
<x-custom-select :options="$options" multiple />
```

If you are customizing the selected text via the `buttonDisplay` slot, you should use `optionDisplay(value[0])`
if you are referencing the option text like that, since `value` will be an array.

### Max selected

With multiple selects, you may limit the number of options a user may select with the `max` attribute.

```html
<x-custom-select :options="$options" multiple max="3" />
```

In this example, the user will only be able to select a maximum of 3 options.

## Optional Selects

For times that you want to allow users to clear the select option(s), you can mark a custom select as `optional`. This
works for both single and multi-select modes, and provides a clear button next to the selected option text.

```html
<x-custom-select :options="$options" optional />
```

## Dependent Selects

If you have a custom select whose options depend on the selection of another select, or just some kind of condition to be met, you can
livewire events to update the options in the select.

In your component definition, pass in an array of livewire event names the select should listen for:

```html
<x-custom-select :options="$options" :wire-listeners="['some-event-name']" />
```

Now in your livewire component, you just need to emit the event(s) you are passing in to the select whenever the options need to be updated:

```php
<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MyComponent extends Component
{
    public function someMethodToBeTriggered()
    {
        // Retrieve your options based on your component state
        $options = [
            ['value' => 'foo', 'text' => 'bar'],
        ];   

        // Emit your event, passing in your options as the payload
        $this->emit('some-event-name', $options);
    }
}
```

Our JavaScript event listener is expecting an array of options as the payload from the event, so be sure
to pass the event emitter your options.

## Positioning

As of v4, the custom-select component makes use of Popper.js for positioning the select menu. This should remove the need for fixed positioning
the select menu now. In addition to positioning the menu when opened, Popper.js will also re-position the menu as needed when the page is scrolled.

## Addons

The custom select component supports leading addons, but since there are already elements appended to the end
of the button trigger, trailing addons are not supported. For more information on addons, see [the input documentation](/docs/laravel-form-components/v4/inputs/input#addons).
