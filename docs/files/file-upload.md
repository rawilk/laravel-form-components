---
title: File Upload
sort: 1
---

## Introduction

The `file-upload` component provides a custom file input for your forms. It can easily be integrated into your livewire forms
as well just by adding a `wire:model` to the input.

## Installation

Even though the `file-upload` component will work out-of-the-box if you're using the script blade directives in your layout (`@fcScripts`),
we recommend that you install and compile the JavaScript libraries before you deploy to production.

- [Alpine.js](https://github.com/alpinejs/alpine) `^2.8`

## Basic Usage

In its most basic usage, you can use it as a self-closing component and pass it a name:

```html
<x-file-upload name="avatar" />
```

> {note} Since the component applies a class of `sr-only` (hides the input) to the input itself, the input must have an id assigned to it
for the label to be able to trigger a click on the input. By default, the component assigns the `id` to the `name` attribute if you don't
provide an `id` to it.

## Upload Progress

By default, if you add a `wire:model` to the component, it will hook into livewire's file uploads and display upload progress when
a file is selected. A progress bar indicating upload progress is shown once an upload has been started.

If you would like to not show progress, or to handle the display of the upload progress yourself, you may pass in a false value
for the `display-upload-progress` attribute.

```html
<x-file-upload wire:model="avatar" :display-upload-progress="false" />
```

> {note} Since the upload progress hooks into livewire events, it will not be shown unless you provide a `wire:model` to it.

## Custom Button Label

By default, the text on the button that is shown says `Select File`. You may optionally specify your own label via an attribute:

```html
<x-file-upload name="avatar" label="Choose New Avatar" />
```

## Default Slot

The `file-upload` component is based on the photo input example from TailwindUI. This displays a photo to the left of the button.
This slot is completely optional, and can be omitted if you don't need to show a file preview.

If you are using livewire and would like to show a photo here, you can do so by following this example:

```html
<x-file-upload name="avatar" wire:model="avatar">
    <div>
        @if ($avatar)
            <span class="block w-20 h-20">
                <img class="rounded-full w-full" src="{{ $avatar->temporaryUrl() }}" />
            </span>
        @endif
    </div>
</x-file-upload>
```

## After Slot

You can of course omit the default slot and provide content in the `after` slot to show a file preview on the right side of the button.
Other content could also be shown in this slot as well.

```html
<x-file-upload name="avatar">
    <x-slot name="after">
        <div>After slot content.</div>
    </x-slot>
</x-file-upload>
```

## Multiple Files

You can use the component to upload multiple files by providing the `multiple` attribute to the component. If you're using livewire and `wire:model`, just make
sure you're model is an array to handle the uploads.
