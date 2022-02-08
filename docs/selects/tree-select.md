---
title: Tree Select
sort: 4
---

## Introduction

Our tree select component is an extension of our [custom select](/docs/laravel-form-components/{version}/selects/custom-select) component and provides
an input that supports options with parent/child relationships. Parent options will have a chevron next to them that will allow them to be expanded
to reveal any children options they have.

## Installation

Like the custom select, the tree select component requires Alpine.js and Popper.js, as well as some custom JavaScript written into the package to work.
Ensure you have the proper [directives](/docs/laravel-form-components/installation#directives) in your layout file.
In production, we recommend you install and compile the JavaScript libraries before you deploy:

- [Alpine.js](https://github.com/alpinejs/alpine) `^3.8`
- [Popper.js](https://popper.js.org) `^2.9.1`

> {tip} See the [JavaScript Dependencies section](/docs/laravel-form-components/{version}/installation#javascript-dependencies) for more information on installing them.

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
Like our custom select, the menu is toggled open and closed by using a `<div>` element with a `role="button"` attached to it. Each option is also rendered
in an `<li>` tag inside of a `<ul>` and each parent's children are rendered inside of a nested `<ul>` element.

## Options

The tree select component accepts either an array or collection via the `options` attribute. You may also render the options yourself via the default slot in the component.
If you provide an array of strings, the component will use the strings as both the key and values of the options. For most cases however, you should provide an array
of keyed arrays for each option, or you can even pass in an array of Eloquent models as options.

```html
<x-tree-select :options="[
    ['id' => 'foo', 'name' => 'Foo'],
    ['id' => 'bar', 'name' => 'Bar'],
]" />

<!-- using models -->
<x-tree-select :options="\App\Models\User::get(['id', name'])" />
```

### Option Values & Text

By default, the component will look for an `id` key for the option value, and a `name` key for hte option text. When you are using Eloquent models for options,
sometimes this won't work. To get around this, you can specify which keys the option should use for the value and label of the option via `value-field` and `label-field`.

### Option Children

The tree select will determine if an option has children via the `children` key of an option. An option's children should be either an array or collection of child options with the
same data structure as the parent option. If you need to customize the key for children, you may use the `children-key` prop.

### Customizing the option display

If you want more control over the display of an option, you can render your options manually in a `@foreach` loop and use the `<x-tree-select-option>` component to render each option.

```html
<x-tree-select name="foo">
    @foreach ($options as $option)
        <x-tree-select-option value="{{ $option->id }}" label="{{ $option->name }}" :children="$option->children">
            <span class="italic">{{ $option->name }}</span>
        </x-tree-select-option>
    @endforeach
</x-tree-select>
```

> {note} It is important to still pass in the `label` prop to each option as our JavaScript will use that to determine the
> text to display for the selected option.

> {note} The options slot will only apply to the parent options. Any child options will rely on the default rendering of options by the component.

## Reference

Since the tree select is just an extension of our custom select component, they will function the same way for the most part. They only differ in regards to options.
The tree select can have option children but it can't have "opt groups" like the custom select can. Please visit the [custom select documentation](/docs/laravel-form-components/{version}/selects/custom-select) for more information
on how to use the component.
