---
title: Quill Editor
sort: 1
---

## Introduction

The `quill` component provides a rich text editor. Before using this component, we recommend familiarizing yourself with the [Quill](https://quilljs.com) library.

## Installation

The `quill` component requires the following third-party libraries to work properly:

- Alpine.js
- Quill

You may install Quill via npm:

```bash
npm i quill --save
```

You can then import it in your project using imports:

```js
import Quill from "quill";

window.Quill = Quill;
```

You will also need to import the theme styles you are using into your stylesheets:

```css
@import "quill/dist/snow.css";
```

You are of course free to use the cdn links alternatively if that's more your style:

```html
<script src="//cdn.quilljs.com/1.0.0/quill.min.js"></script>
<link href="//cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet" />
```

Be sure to replace `1.0.0` with the version you are planning on using.

See [Third-Party Assets](/docs/laravel-form-components/{version}/installation#user-content-third-party-assets) on the installation guide for further setup information.

## Basic Usage

The most basic usage of the `quill` component involves just adding a self-closing tag:

```html
<x-quill />
```

This will create a new quill editor inside of a content editable div. If a `name` attribute is provided, we will render a hidden input for regular
form submissions, which will keep its value in sync with the value of the quill editor.

## Livewire Integration

The `quill` component integrates easily with livewire out-of-the-box and just requires you to provide a `wire:model` to the component.

```html
<x-quill wire:model="content" />
```

> {note} You may also use the `defer` modifier for the wire model, but the `debounce` modifier is not supported at this time.

## X-Model Usage

You may use `x-model` on the component as well.

```html
<div x-data="{ content: '' }">
    <x-quill x-model="content" />
</div>
```

You may also use modifiers to x-model, such as `debounce`.

## Options

The `quill` component accepts most of the options that the quill editor provides, however some options will require you to provide a `\Rawilk\LaravelFormComponents\Dto\QuillOptions` object to set them.

### Readonly

To make the editor readonly, you may pass in a truthy value to the component:

```html
<x-quill readonly />
```

### Placeholder

Like most other inputs, you may use a placeholder to show when there is no value set:

```html
<x-quill placeholder="Write something inspiring..." />
```

### QuillOptions

For all other options, you should pass in an instance of the `QuillOptions` object:

```html
<x-quill :quill-options="QuillOptions::defaults()->theme('snow')" />
```

The `QuillOptions` object is mostly useful for customizing the toolbar of the editor.

You may set some default options in a service provider. For example, if you always want to hide the bold toolbar button, you may do
so like this in your AppServiceProvider:

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Rawilk\FormComponents\Dto\QuillOptions;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        QuillOptions::defaults(function () {
            return (new QuillOptions)->hideBold();
        });
    }
}
```

### Custom Toolbar

By default, most of the buttons available to quill will be rendered onto the editor. Using the `QuillOptions` object, you may specify which buttons should be hidden and also provide custom buttons as well.

```html
<x-quill
    :quill-options="QuillOptions::defaults()->hideBold()->hideOrderedList()"
/>
```

The above example will hide the bold and ordered list buttons from the editor. For a full list of available methods, you can refer to the source class: https://github.com/rawilk/laravel-form-components/blob/{branch}/src/Dto/QuillOptions.php

You may alternatively pass in your own toolbar if you need to:

```html
<x-quill
    :quill-options="QuillOptions::defaults()->toolbar([
        ['bold', 'italic'],
        [['list' => 'ordered'], ['list' => 'bullet']],
    ])"
/>
```

In this example, only buttons for bold, italic, and ordered/unordered lists will appear in the toolbar.

### Custom Toolbar Button

If you need a custom toolbar button/dropdown list, you may provide one with the `withToolbarButton` method on `QuillOptions`. You will need to provide
a key (id) for the button and optionally an array of options if it is a dropdown button.

```html
<x-quill
    :quill-options="QuillOptions::defaults()->withToolbarButton('variables', [
        'Option 1',
        'Option 2',
    ])"
/>
```

You will then need to utilize the `config` slot on the component to define a JavaScript handler for the toolbar button:

```html
<x-quill
    :quill-options="QuillOptions::defaults()->withToolbarButton('variables', [
        'Option 1',
        'Option 2',
    ])"
    ...
>
    <x-slot:config>
        toolbarHandlers: { variables: function (value) { value = `[[ ${value}
        ]]`; const cursorPosition = this.quill.getSelection().index;
        this.quill.insertText(cursorPosition, value);
        this.quill.setSelection(cursorPosition + value.length); }, },
    </x-slot:config>
</x-quill>
```

> {note} It is important to not use arrow functions for the toolbar handlers, as they will not have access to the `this` context of Quill.
> For the example above, it is important to reference the quill instance via `this.quill`, otherwise you may get unexpected results when
> inserting text.

This example will provide a custom dropdown menu with two options, and when each one is clicked on, it will insert the text of the option into the editor at the current cursor position of the user. Your work is not done yet, however. Quill editor uses CSS styling to render the text into the toolbar buttons, so you will need to add some styles to your stylesheet:

```css
.ql-picker.ql-variables .ql-picker-label:before {
    content: "Variables";
}

.ql-picker.ql-variables .ql-picker-item[data-value]:before {
    content: attr(data-value);
}

.ql-picker.ql-variables .ql-picker-label {
    padding-right: 18px;
}
```

> {tip} Quill creates a css class on your button depending on the key you provide it. You will need to change `.ql-variables` to whatever key name you provide it.

## Config Slot

If you need to define JavaScript handlers for a [custom toolbar button](#user-content-custom-toolbar-button), you may use the `config`
slot to do this. The config slot is inside a JavaScript function that returns an object and has access to the following variables:

| variable       | description                                                 |
| -------------- | ----------------------------------------------------------- |
| `instance`     | The Alpine data instance for the quill component            |
| `quillOptions` | An object containing the options generated by the component |

For a complete list of quill configuration options, see [Quill Configuration](https://quilljs.com/docs/configuration/).

## onInit Slot

If you need to define your own JavaScript callbacks for Quill, you may use the `onInit` slot. This slot is rendered inside a JavaScript
function that has access to an `instance` variable, which provides you access to the Alpine data object for the `quill` component. If you need
access to the quill editor instance, you can do so via `instance.__quill`.

Here's an example of how you could hook into the `selection-change` event that Quill fires:

```html
<x-quill ...>
    <x-slot:on-init>
        instance.__quill.on('selection-change', function (range, oldRange,
        source) { // do something });
    </x-slot:on-init>
</x-quill>
```

> {note} If you need to hook into the `text-change` event fired by Quill, you should use the [onTextChange](#user-content-ontextchange-slot) slot instead.

## onTextChange Slot

Whenever the text content of the quill editor is changed, Quill will fire a `text-change` event that can be listened for. Since our component's JavaScript
already listens for that event, we've provided a slot that can be used to perform additional actions if needed. The slot is rendered inside a function
that has access to an `instance variable`, which provides you access to the Alpine data object for the `quill` component. If you need access to the quill
editor instance, you can do so via `instance.__quill`.

```html
<x-quill ...>
    <x-slot:on-text-change>
        let value = instance.__quill.root.innerHTML; console.log(value);
    </x-slot:on-text-change>
</x-quill>
```

If you want to prevent our component from updating the value, or dispatching an `input` event, you may return `false` from the slot:

```html
<x-slot:on-text-change> return false; </x-slot:on-text-change>
```

## API Reference

### props

| prop           | description                                                                               |
| -------------- | ----------------------------------------------------------------------------------------- |
| `name`         | Name of the input                                                                         |
| `id`           | Id of the input. Defaults to `name`.                                                      |
| `value`        | The initial value for the input                                                           |
| `showErrors`   | If a validation error is present for the input, it will show the error state on the input |
| `autoFocus`    | Give focus to the input on page load                                                      |
| `readonly`     | Makes the editor readonly                                                                 |
| `placeholder`  | Sets a placeholder text in the editor                                                     |
| `quillOptions` | The `QuillOptions` configuration object                                                   |

### slots

| slot           | description                                                 |
| -------------- | ----------------------------------------------------------- |
| `config`       | Set JavaScript configuration options and toolbar handlers   |
| `onTextChange` | Hook into the `text-change` event fired by Quill            |
| `onInit`       | Place to define custom JavaScript event listeners for Quill |

### config

The following configuration keys and values can be adjusted for common default behavior
you may want for the quill element.

```php
'defaults' => [
    'global' => [
        // Show error states by default.
        'show_errors' => true,
    ],

    'quill' => [
        // Automatically focus the editor on page load by default.
        'auto_focus' => false,
    ],
],
```
