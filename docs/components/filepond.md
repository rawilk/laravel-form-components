---
title: FilePond
sort: 16
---

## Introduction

The `file-pond` component provides an easy way to utilize advanced file uploads via [FilePond](https://pqina.nl/filepond/).
Before using this component, we recommend familiarizing yourself with the FilePond library.

## Installation

While the `file-pond` component works out-of-the-box when you've [set the directive](/docs/laravel-form-components/v1/installation#directives),
we recommend that you install and compile the JavaScript libraries before you deploy to production:

- [Alpine.js](https://github.com/alpinejs/alpine) `^2.7`
- [FilePond](https://pqina.nl/filepond/) `^4.21`

As per the [FilePond docs](https://pqina.nl/filepond/docs/patterns/installation/), you can install FilePond via npm:

```bash
npm i filepond --save
```

You can then import it in your project using imports:

```js
import * as FilePond from 'filepond';
```

There are also some styles required for FilePond. If you're using Sass, you can import it **before** you import the styles for this package:

```css
@import '~filepond/dist/filepond.min.css';
```

## Basic Usage

The most basic usage of the `file-pond` component involves just adding a self-closing tag:

```html
<x-file-pond />
```

This will output the following HTML (omitting JS):

```html
<div wire:ignore
     x-data
     x-cloak
     x-init="..."
>
    <input x-ref="input"
           type="file"
           style="display:none;"
    />
</div>
```

## Livewire Integration

The `file-pond` component integrates smoothly with livewire out-of-the-box and just requires you to
provide a `wire:model` to the component. This will help it set up the necessary `server` configuration
options on the library and will handle uploading and reverting automatically for you via livewire.

```html
<x-file-pond wire:model="avatar" />
```

## Options

You can provide options to the FilePond library via an array through the `options` attribute. This requires you
to pass in a PHP array with scalar values only. Below is an example where we set a class of "foo" on the
root element generated by FilePond:

```html
<x-file-pond wire:model="avatar" :options="['className' => 'foo']" />
```

For a full reference of all options, please consult [the FilePond documentation](https://pqina.nl/filepond/docs/patterns/api/filepond-instance/#properties).

### Multiple

You can accept multiple files by passing in `multiple` as a boolean value. This attribute has been added as a way
to conveniently set the `allowMultiple` option for FilePond.

### Max Files

You can limit the number of files accepted when `allowMultiple` is set to `true` by providing `max-files` with an
integer value.

### Disabled

You can easily disable the FilePond input by passing `disabled` in as a boolean value.

### Allow Drop

The `allow-drop` boolean attribute has been added as a way to conveniently set the `allowDrop` option. Setting it to `false`
will prevent users from being able to drop files onto the input.

## Callbacks

Since the `options` attribute only accepts scalar values, the component offers an `optionsSlot` slot that will allow you to
specify an option callbacks, such as `server` that you need to:

```html
<x-file-pond wire:model="avatar">
    <x-slot name="optionsSlot">
        server: {
            process: () => { ... }
        }
    </x-slot>
</x-file-pond>
```

## Plugins

The `file-pond` component doesn't make use of any FilePond plugins itself, but you can easily install and implement your own plugins.

First, install the necessary JavaScript and CSS required by the plugin. A list of plugins [can be found here](https://pqina.nl/filepond/plugins.html).

With the plugin's assets installed, you can make use of the `plugins` slot to initialize the plugin. The following example shows setting up the image
preview FilePond Plugin.

```html
<x-file-pond wire:model="avatar">
    <x-slot name="plugins">
        FilePond.registerPlugin(FilePondPluginImagePreview);
    </x-slot>
</x-file-pond>
```

If you're into using CDNs, you can add these lines to your layout file for the above example:

```html
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
```