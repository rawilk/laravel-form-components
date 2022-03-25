---
title: Quill Editor
sort: 1
---

## Introduction

The `quill` component provides a rich text editor. Before using this component, we recommend familiarizing yourself with the [Quill](https://quilljs.com) library.

## Installation

While the `quill` component works out-of-the-box when you've [set the directive](/docs/laravel-form-components/{version}/installation#directives), we recommend that you install and compile the JavaScript libraries before you deploy to production:

- [Alpine.js](https://github.com/alpinejs/alpine) `^3.9`
- [Quill](https://quilljs.com) `^1.3`

You may install Quill via npm:

```bash
npm i quill --save
```

You can then import it in your project using imports:

```js
import Quill from 'quill';
```

You will also need to import the theme styles you are using into your stylesheets:

```css
@import 'quill/dist/snow.css';
```

You are of course free to use the cdn links alternatively if that's more your style:

```html
<script src="//cdn.quilljs.com/1.0.0/quill.min.js"></script>
<link href="//cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">
```

Be sure to replace `1.0.0` with the version you are planning on using.

## Basic Usage

The most basic usage of the `quill` component involves just adding a self-closing tag:

```html
<x-quill />
```

This will create a new quill editor inside of a content editable div.

## Livewire Integration

The `quill` component integrates easily with livewire out-of-the-box and just requires you to provide a `wire:model` to the component.

```html
<x-quill wire:model="content" />
```

> {note} You may also use the `defer` modifier for the wire model, but the `debounce` modifier is not supported at this time.

## X-Model Usage

You may use `x-model` on the component as well, however there is one caveat to it. You will need to listen for a `quill-input` event on your alpine component and update your
model accordingly. We dispatch that custom event instead of `input` because the quill editor also dispatches the input event, but it doesn't give you the actual value
of the input. With the custom event, you can more reliably update your alpine models.

```html
<div x-data="{ content: '' }" x-on:quill-input="content = $event.detail">
    <x-quill x-model="content" />
</div>
```

## Options
The `quill` component accepts most of the options that the quill editor provides, however some options will require you to provide a `Rawilk\LaravelFormComponents\Dto\QuillOptions` object to set them.

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

### Custom Toolbar
By default, most of the buttons available to quill will be rendered onto the editor. Using the `QuillOptions` object, you may specify which buttons should be hidden and also provide custom buttons as well.

```html
<x-quill :quill-options="QuillOptions::defaults()->hideBold()->hideOrderedList()" />
```

The above example will hide the bold and ordered list buttons from the editor. For a full list of available methods, you can refer to the source class: https://github.com/rawilk/laravel-form-components/blob/main/src/Dto/QuillOptions.php

You may alternatively pass in your own toolbar if you need to:

```html
<x-quill :quill-options="QuillOptions::defaults()->toolbar([
    ['bold', 'italic'],
    [['list' => 'ordered'], ['list' => 'bullet']],
])" />
```

In this example, only buttons for bold, italic, and ordered/unordered lists will appear in the toolbar.

### Custom Toolbar Button
If you need a custom toolbar button/dropdown list, you may provide one with the `withToolbarButton` method on `QuillOptions`. You will need to provide
a key (id) for the button, a JavaScript handler, and optionally an array of options if it is a dropdown button. Your handler will automatically be converted from
a string to a JavaScript function by the quill component JS, and will be provided a `value` variable from the quill editor.

```html
<x-quill :quill-options="QuillOptions::defaults()->withToolbarButton('variables', <<<HTML
    const cursorPosition = this.quill.getSelection().index;
    this.quill.insertText(cursorPosition, value);
    this.quill.setSelection(cursorPosition + value.length);
HTML, ['Option 1', 'Option 2']" />
```

This example will provide a custom dropdown menu with two options, and when each one is clicked on, it will insert the text of the option into the editor at the current cursor position of the user. Your work is not done yet, however. Quill editor uses CSS styling to render the text into the toolbar buttons, so you will need to add some styles to your stylesheet:

```css
.ql-picker.ql-variables .ql-picker-label:before {
    content: 'Variables';
}

.ql-picker.ql-variables .ql-picker-item[data-value]:before {
    content: attr(data-value);
}

.ql-picker.ql-variables .ql-picker-label {
    padding-right: 18px;
}
```

> {tip} Quill creates a css class on your button depending on the key you provide it. You will need to change `.ql-variables` to whatever key name you provide it.
