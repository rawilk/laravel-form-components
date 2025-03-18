---
title: File Upload
sort: 1
---

## Introduction

The `file-upload` component provides a custom file input for your forms. It can easily be integrated into your livewire forms
as well just by adding a `wire:model` to the input.

## Installation

To take advantage of the upload progress offered by the `file-upload` component, the following third-party libraries are required:

- Alpine.js

See [Third-Party Assets](/docs/laravel-form-components/{version}/installation#user-content-third-party-assets) on the installation guide for further setup information.

## Basic Usage

In its most basic usage, you can use it as a self-closing component and pass it a name:

```html
<x-file-upload name="avatar" />
```

## Upload Progress

By default, if you add a `wire:model` to the component, it will hook into livewire's file uploads and display upload progress when
a file is selected. A progress bar indicating upload progress is shown once an upload has been started.

If you would like to not show progress, or to handle the display of the upload progress yourself, you may pass in a false value
for the `display-upload-progress` attribute.

```html
<x-file-upload wire:model="avatar" :display-upload-progress="false" />
```

> {note} Since the upload progress hooks into livewire events, it will not be shown unless you provide a `wire:model` to it.

### Native Progress Bar

By default, the `file-upload` component is configured to render the upload progress in a non-native progress element with aria attributes
for accessibility. This is done to help ensure styling consistency across browsers. If this is not a concern for your application, you can
set the `useNativeProgressBar` attribute to `true`, and the component will use the `<progress>` element instead to show upload progress.

```html
<x-file-upload use-native-progress-bar />
```

## Default Slot

The `file-upload` component allows you to place some markup before the input element for something like a photo preview once
a file is selected. The following example shows displaying a user avatar preview in a livewire component:

This slot is completely optional, and can be omitted if you don't need to show a file preview.

```html
<x-file-upload name="avatar" wire:model="avatar">
    <div>
        @if ($avatar)
        <span class="block w-20 h-20">
            <img
                class="rounded-full w-full"
                src="{{ $avatar->temporaryUrl() }}"
            />
        </span>
        @endif
    </div>
</x-file-upload>
```

## After Slot

You can of course omit the default slot and provide content in the `after` slot to show a file preview on the right side of the input.
Other content could also be shown in this slot as well.

```html
<x-file-upload name="avatar">
    <x-slot:after>
        <div>After input slot content.</div>
    </x-slot:after>
</x-file-upload>
```

> {note} You will not have access to the `x-data` scope in the component. Use the [After Input Slot](#user-content-after-input-slot) if you need
> access to it.

## After Input Slot

This slot allows for placing any kind of markup after the input and/or file upload progress bar. You will have access to the Alpine variables
`isUploading` and `progress` in this slot. This slot is useful if you are not using Livewire to upload your files, but still want to display
a file upload progress bar.

> {note} You may need to manually include the `form-components::components.files.partials.upload-progress` view partial if you're not using Livewire.

## Multiple Files

You can use the component to upload multiple files by providing the `multiple` attribute to the component. If you're using livewire and `wire:model`, just make
sure your model is an array to handle the uploads.

## File Type

For convenience, you may specify a `type` attribute that will limit the types of files that can be selected. If a supported type is entered, the component
will set the `accept` attribute on the file input. The following types are supported:

| type        | rendered accept value                                                                           |
| ----------- | ----------------------------------------------------------------------------------------------- |
| audio       | audio/\*                                                                                        |
| image       | image/\*                                                                                        |
| video       | video/\*                                                                                        |
| pdf         | .pdf                                                                                            |
| csv         | .csv                                                                                            |
| spreadsheet | .csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet |
| excel       | .csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet |
| text        | text/plain                                                                                      |
| html        | text/html                                                                                       |

If the type you need isn't listed here, or you need to limit the type further, you are free to specify a value for the `accept` attribute yourself.

## API Reference

### props

| prop                    | description                                                                                 |
| ----------------------- | ------------------------------------------------------------------------------------------- | --- |
| `name`                  | The name of the file input                                                                  |
| `id`                    | The ID of the file input. Defaults to `name`                                                |
| `multiple`              | A boolean indicating the file input supports multi-file upload                              |
| `type`                  | The type of file the input accepts                                                          |
| `showErrors`            | If a validation error is present for the input, it will show the error state on the input   |
| `displayUploadProgress` | A boolean value indicating if the progress bar should be displayed on livewire file uploads |
| `size`                  | Define a size for the input. Default size is `md`                                           |
| `containerClass`        | Defines a CSS class to apply to the **container** of the input                              |
| `useNativeProgressBar`  | A boolean value indicating if a native progress bar should be used. Default is `false`      | +   |
| `extraAttributes`       | Pass an array of HTML attributes to render on the input                                     |

### slots

| slot         | description                                                           |
| ------------ | --------------------------------------------------------------------- |
| `after`      | Place to put markup for a file preview on the right side of the input |
| `afterInput` | Allows custom markup inside of the `x-data` scope                     |

### config

The following configuration keys and values can be adjusted for common default behavior
you may want for the file upload element.

```php
'defaults' => [
    'global' => [
        // Show error states by default.
        'show_errors' => true,
    ],

    'input' => [
        // Supported: 'sm', 'md', 'lg'
        // Applies to all input types except for checkbox/radios and custom select.
        'size' => 'md',
    ],

    'file_upload' => [
        // Display a file upload progress bar by default.
        // Only shows if a "wire:model" is present.
        'display_upload_progress' => true,

        // Use the native HTML5 progress bar by default.
        // Not recommended if you need consistent styling across browsers.
        'use_native_progress_bar' => false,

        // Globally apply a CSS class to each file upload container.
        'container_class' => null,

        // Globally apply a CSS class to each file upload input.
        'input_class' => null,
    ],
],
```
