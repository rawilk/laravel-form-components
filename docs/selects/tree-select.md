---
title: Tree Select
sort: 4
---

## Introduction

Our `tree-select` component is an extension of our [custom select](/docs/laravel-form-components/{version}/selects/custom-select) component and provides
an input that supports options with parent/child relationships. Parent options will have a chevron next to them that will allow them to be expanded
to reveal any children options they have.

## Installation

The following third-party libraries are required for `tree-select` to work properly:

- Alpine.js
- Alpine [Focus Plugin](https://alpinejs.dev/plugins/focus)
- Popper

See [Third-Party Assets](/docs/laravel-form-components/{version}/installation#user-content-third-party-assets) on the installation guide for further setup information.

## Basic Usage

You can use the tree select menu by providing some basic options.

```html
<x-tree-select
    name="foo"
    :options="[
        ['id' => 'foo', 'name' => 'Foo', 'children' => [
            ['id' => 'child_1', 'name' => 'Child 1'],
        ]],
    ]"
/>
```

This will render a tree select menu with a parent option for "Foo", and underneath "Foo" will be an expandable list containing a child option named "Child 1".
Child options are rendered in a nested `<ul>` element.

## Options

The tree select component accepts either an array or collection via the `options` attribute. You may also render the options yourself via the default slot in the component.
If you provide an array of strings, the component will use the strings as both the key and values of the options. For most cases however, you should provide an array
of keyed arrays for each option, or you can even pass in an array of Eloquent models as options.

```html
<x-tree-select
    :options="[
    ['id' => 'foo', 'name' => 'Foo'],
    ['id' => 'bar', 'name' => 'Bar'],
]"
/>

<!-- using models -->
<x-tree-select :options="\App\Models\User::get(['id', name'])" />
```

### Option Values & Text

By default, the component will look for an `id` key for the option value, and a `name` key for hte option text. When you are using Eloquent models for options,
sometimes this won't work. To get around this, you can specify which keys the option should use for the value and label of the option via `value-field` and `label-field`.

### Option Children

The tree select will determine if an option has children via the `children` key of an option. An option's children should be either an array or collection of child options with the
same data structure as the parent option. If you need to customize the key for children, you may use the `children-field` attribute.

### Customizing the option display

We have provided a slot called `optionTemplate` to customize how each option is rendered in the menu, however you'll need to use JavaScript
to customize this since the `<x-tree-select-option>` component is rendered recursively when parent options are present. The content of each
option is wrapped in an `x-data` directive that contains a variable called `option` containing all the properties present on the option.

Assuming you have a property called "foo" on the option, we'll render that property out in a span tag and make the text italic:

```html
<x-tree-select :options="$options">
    <x-slot:option-template>
        <span x-text="option.foo" class="italic"></span>
    </x-slot:option-template>
</x-tree-select>
```

> {tip} You may want to apply different formatting to your parent options, which can be checked for via `$treeSelectOption.hasChildren`. See [$treeSelectOption](#user-content-treeselectoption)

### Customizing the selected option display

By default, when an option is selected it will display the same text that is provided to it on the `label` prop on the tree-select's trigger.
If you want to display something different for the selected option, you may provide a value to the `selected-label-field` attribute on the select.
If nothing is provided, it will default to the `label-field` attribute.

```html
<x-tree-select
    name="foo"
    :options="[
        ['id' => 'foo', 'name' => 'Foo', 'short_name' => 'F'],
        ['id' => 'bar', 'name' => 'Bar', 'short_name' => 'B'],
    ]"
    selected-label-field="short_name"
/>
```

In the example above, when an option is selected, the value for the option's `short_name` will be displayed on the tree-select's trigger instead
of the option's `name` field.

We have also provided a slot called `selectedTemplate` which will allow you to further customize how you are displaying the selected option's value. You
will need to use the `selectedObject` property on our `$treeSelect` [magic property](#user-content-treeselect).

```html
<x-tree-select ...>
    <x-slot:selected-template>
        <span x-text="$treeSelect.selectedObject?.short_name"></span>
    </x-slot:selected-template>
</x-tree-select>
```

If you are using a multi-select, the selected template slot will be slightly different, since it will be in an Alpine `x-for` loop.
In this case, you will need to use a variable exposed to you, called `selectedObject`, which behaves the same way as the example above.

```html
<x-tree-select multiple ...>
    <x-slot:selected-template>
        <span x-text="selectedObject.short_name"></span>
    </x-slot:selected-template>
</x-tree-select>
```

### Disabling Options

You may disable specific options by setting `disabled` to true on the option:

```html
<x-tree-select
    :options="[['value' => 'foo', 'text' => 'Foo', 'disabled' => true]]"
/>
```

You can use a different key for `disabled` on the option, by specifying it via the `disabled-field` attribute on the select.

```html
<x-tree-select
    :options="[['id' => 'foo', 'name' => 'Foo', 'inactive' => true]]"
    disabled-field="inactive"
/>
```

### Manual Rendering

If you prefer to render options yourself, you can do so in the default slot using the `<x-tree-select-option>` component. The option component
will automatically be aware of the following fields from `tree-select`.

- valueField
- labelField
- disabledField
- childrenField
- optionSelectedIcon
- hasChildIcon

Because of this, the `tree-select-option` must be placed inside a `tree-select` component.

The only prop you need to provide is `value`, which should be an array of an option, or a model. If there are children present on the option,
the component will recursively render and children underneath the parent option.

```html
<x-tree-select ...>
    @foreach ($options as $option)'
    <x-tree-select-option :value="$option" />
    @endforeach
</x-tree-select>
```

You can of course customize the option display using the `optionTemplate` slot on the option. This will behave exactly the same as
it does on [customizing the option display](#user-content-customizing-the-option-display) on the parent component.

## Filtering

You may provide search functionality on a tree select by setting `searchable` on the component to `true`.

```html
<x-tree-select :options="$options" searchable />
```

This will provide basic search functionality, which will hide any non-matching options as the user types.

> {tip} By default `searchable` is set to true on the select component.

## Server-Side Filtering

If you use Livewire, you can easily add server-side filtering of options via the `livewire-search` prop on the component.

```html
<x-tree-select :options="$options" searchable livewire-search="handleSearch" />
```

In this example, this will require you to have a method called `handleSearch` on your livewire component. Our JavaScript will
call that method via livewire's JavaScript API, passing it the value of the current search term. Your livewire component
should filter out the options based on the search. The select component debounces the search input so each keystroke is
not triggering another ajax request to your server.

Your component should then re-render itself with the filtered options.

## Multiple Select

You can easily make a select accept multiple selected options by using the `multiple` attribute. Each of the selected options
will appear on the trigger as a "token", which will allow the user to click on them to remove them.

```html
<x-tree-select :options="$options" multiple />
```

### Max selected

With multiple selects, you may limit the number of options a user may select with the `max-selected` prop.

```html
<x-tree-select :options="$options" multiple :max-selected="3" />
```

In this example, the user will only be able to select a maximum of 3 options.

> {note} The component expects an integer value, so be sure to pass an integer type as the value.

### Min Selected

With a multiple select, you may require the user to select a minimum amount of options. You can specify this via the `min-selected` prop.

```html
<x-tree-select :options="$options" multiple :min-selected="2" />
```

## Optional Selects

For times that you want to allow users to clear the select option(s), you can mark a custom select as `optional`. This
works for both single and multi-select modes, and provides a clear button next to the selected option text.

```html
<x-tree-select :options="$options" optional />
```

> {note} In a multi-select, if you have `min-selected` set to more than 1, `optional` will not apply here.

## Positioning

The tree-select component makes use of Popper.js for positioning the select menu. This should remove the need for fixed positioning
the select menu now. In addition to positioning the menu when opened, Popper.js will also re-position the menu as needed when the page is scrolled.

If absolute positioning is breaking your layout, you can force Popper to use fixed positioning, however you may need to style the width of the menu manually.
All you need to do is passed a `fixed` attribute to the component.

```html
<x-tree-select fixed ... />
```

## Orientation

Normally the tree select component will orient itself vertically. If you want to have it orient itself horizontally, set the `horizontal` attribute.

```html
<x-tree-select horizontal ... />
```

## Autofocus

If you want to give focus to the select on page load, you can set the `autofocus` attribute.

```html
<x-tree-select autofocus ... />
```

## Addons

The tree select component supports most of the available addons this package offers. Header over to the [Addons](/docs/laravel-form-components/{version}/advanced-usage/addons) documentation
for an in-depth guide on how to use them.

> {note} The tree-select component does not support the `trailingInlineAddon` or the `trailingIcon` addons.

## Keyboard Shortcuts

| key                 | description                                                                                                                                                                       |
| ------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `[Enter/Space]`     | Open the select when it's closed or select the focused option when the select is open. Will not select an option if select is set to `searchable` and the search input is focused |
| `[Escape]`          | Close the select                                                                                                                                                                  |
| `[Arrow Keys]`      | Focuses the next/previous non-disabled option                                                                                                                                     |
| `[Right Arrow Key]` | Expand children options on an active option                                                                                                                                       |
| `[Left Arrow Key]`  | Collapse children options on an active option                                                                                                                                     |
| `[Home/PageUp]`     | Focuses the first non-disabled option                                                                                                                                             |
| `[End/PageDown]`    | Focuses the last non-disabled option                                                                                                                                              |
| `[A-z]`             | Focuses the first option matching the keyboard input. Only triggers when select is not set to `searchable`, or the search input is not focused                                    |
| `[Backspace]`       | In a multi-select, when the menu is closed and there are selected options, it will de-select the last selected option                                                             |

## API Reference

### props

| prop                 | description                                                                                                                      |
| -------------------- | -------------------------------------------------------------------------------------------------------------------------------- |
| `name`               | Name of the select                                                                                                               |
| `id`                 | Id of the select. Defaults to `name`.                                                                                            |
| `value`              | Value of the select. Gets ignored if `wire:model` or `x-model` is present                                                        |
| `showErrors`         | If a validation error is present for the select, it will show the error state on the select                                      |
| `multiple`           | Allow multiple options to be selected                                                                                            |
| `options`            | An array or Collection of options to be rendered                                                                                 |
| `size`               | Define a size for the select. Default size is `md`                                                                               |
| `valueField`         | Property on an option to use for the value                                                                                       |
| `labelField`         | Property on an option to use for the text                                                                                        |
| `selectedLabelField` | Property on an option to use in the select trigger for display. Defaults to `labelField`                                         |
| `disabledField`      | Property on an option to use to determine if it is disabled                                                                      |
| `childrenField`      | Property on an option to determine if it has children. Will render as an "opt group" option if children is present and not empty |
| `minSelected`        | A minimum amount of options that must be selected in a multi-select                                                              |
| `maxSelected`        | A maximum amount of options that may be selected in a multi-select                                                               |
| `optional`           | A boolean value indicating the user may clear the selected value(s).                                                             |
| `buttonIcon`         | A name of an icon component to use for the arrows on the right of the trigger                                                    |
| `searchable`         | A boolean value indicating that a search box should be rendered in the menu                                                      |
| `livewireSearch`     | A name of a Livewire component method to handle a server-side search                                                             |
| `clearable`          | Allows a clear button to show on the select trigger. Will not show if `optional` is set to `false`                               |
| `clearIcon`          | A name of an icon component to render in the clear button                                                                        |
| `optionSelectedIcon` | A name of an icon component to render next to an option in the menu when it is selected                                          |
| `placeholder`        | Placeholder text to show in the trigger when no option is selected.                                                              |
| `noResultsText`      | Text to display in the menu when a search term is present, but no matching options found                                         |
| `noOptionsText`      | Text to display in the menu when no options are found and no search term is present                                              |
| `alwaysOpen`         | A boolean value indicating that the menu should always be open                                                                   |
| `containerClass`     | A CSS class to apply to the container of the select menu                                                                         |
| `extraAttributes`    | Pass an array of HTML attributes to render on the select                                                                         |
| `leadingAddon`       | Render text on the left of the select                                                                                            |
| `leadingIcon`        | Render an icon on the left of the select                                                                                         |
| `inlineAddon`        | Render text inside the select on the left                                                                                        |
| `trailingAddon`      | Render text on the right of the select                                                                                           |
| `hasChildIcon`       | A name of an icon component to render next to a parent option indicating it has child options                                    |

### slots

| slot               | description                                         |
| ------------------ | --------------------------------------------------- |
| `selectedTemplate` | Customize how the selected option is displayed      |
| `optionTemplate`   | Customize how each option is displayed in the menu  |
| `before`           | Render HTML before the select and/or leading addons |
| `after`            | Render HTML after the select and/or trailing addons |
| `leadingAddon`     | Render text on the left of the select               |
| `leadingIcon`      | Render an icon on the left of the select            |
| `inlineAddon`      | Render text inside the select on the left           |
| `trailingAddon`    | Render text on the right of the select              |

### config

The following configuration keys and values can be adjusted for common default behavior
you may want for the tree-select element.

```php
'defaults' => [
    'global' => [
        // Show error states by default.
        'show_errors' => true,

        // Set the fields to use by default for properties on options in select components.
        'value_field' => 'id',
        'label_field' => 'name',
        // Will default to label field if null - only applies to custom selects
        'selected_label_field' => null,
        'disabled_field' => 'disabled',
        'children_field' => 'children',
    ],

    'input' => [
        // Supported: 'sm', 'md', 'lg'
        // Applies to all input types except for checkbox/radios.
        'size' => 'md',
    ],

    'custom_select' => [
        // Apply a CSS class by default to the root element of the custom select.
        // Note: this will also apply to tree-select as well.
        'container_class' => null,

        // Apply a CSS class by default to the custom select button.
        'input_class' => null,

        // Apply a CSS class by default to the custom select menu.
        'menu_class' => null,

        // Make custom selects searchable by default.
        'searchable' => true,

        // Make custom selects clearable by default.
        // Will not show the clear button if the select is not optional.
        'clearable' => true,

        // Make custom selects optional by default. When marked as optional, custom select
        // will allow you to clear out its value, unless it has a minimum amount of options
        // required in a multi-select.
        'optional' => false,

        // Set the default icon to use to show that an option is selected.
        // Set to null to disable it.
        'option_selected_icon' => 'heroicon-m-check',

        // Define the name of the icon to show on the custom select button by default.
        // Set to null to hide it.
        'button_icon' => 'heroicon-m-chevron-down',

        // Define the default clear icon that will show on the custom select button and
        // multi-select selected options. Set to null to hide it.
        'clear_icon' => 'heroicon-m-x-mark',

        // In a multi-select, this is the minimum amount of options that must be selected.
        // Set to null or 0 to disable it.
        'min_selected' => null,

        // In a multi-select, this is the maximum amount of options that can be selected.
        // Set to null to disable it.
        'max_selected' => null,
    ],

    'tree_select' => [
        // Set the default icon to use to show that an option has children.
        // Icon will be rotated to indicate when the option is expanded.
        'has_child_icon' => 'heroicon-m-chevron-right',
    ],
],
```

### events

These are the events that our JavaScript will emit.

| Event | Args       | Description                   |
| ----- | ---------- | ----------------------------- |
| input | `newValue` | Emitted when value is updated |

### $treeSelect

A magic variable that exposes information about the current state of the select menu (element containing `x-data="treeSelect(...)`)

| property               | description                                                                                   |
| ---------------------- | --------------------------------------------------------------------------------------------- |
| `isOpen`               | Select menu is open or not                                                                    |
| `isDisabled`           | Select menu is disabled or not                                                                |
| `isSearchable`         | Select menu is searchable or not                                                              |
| `selected`             | Currently selected raw value                                                                  |
| `active`               | Currently active (highlighted) option                                                         |
| `selectedObject`       | Object representation of the selected value. Will be an array of objects in multi-select mode |
| `hasValue`             | Whether or not select has a selected option                                                   |
| `shouldShowClear`      | Are conditions right to show the clear button                                                 |
| `canSelectMore`        | Can more options be selected in a multi-select                                                |
| `canDeselectOptions`   | Can an option(s) be de-selected                                                               |
| `hasOptions`           | Does the menu have any registered options                                                     |
| `hasSearch`            | Is there a current search query                                                               |
| `hasExpandableOptions` | Are there any parent options registered                                                       |

### $treeSelectOption

A magic variable that exposes information about the current state of an option (element containing `x-tree-select:option`)

| property      | description                                                                                  |
| ------------- | -------------------------------------------------------------------------------------------- |
| `isActive`    | A boolean used to determine whether or not an option is currently active (hovered over)      |
| `isSelected`  | A boolean used to determine whether or not an option is currently selected                   |
| `isDisabled`  | A boolean used to determine whether or not an option is currently disabled                   |
| `hasChildren` | A boolean used to determine whether or not the option has child options                      |
| `isExpanded`  | A boolean used to determine whether or not the option has been expanded to show its children |
