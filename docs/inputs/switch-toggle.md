---
title: Switch Toggle
sort: 9
---

## Introduction

The `switch-toggle` component offers an easy alternative to a traditional checkbox and is heavily based on
the [Tailwind UI toggle component](https://tailwindui.com/components/application-ui/forms/toggles). The
switch toggle acts like a checkbox, however it's mostly used for an on/off state.

## Installation

The `switch-toggle` component requires the following third-party libraries to work properly:

- Alpine.js

See [Third-Party Assets](/docs/laravel-form-components/{version}/installation#user-content-third-party-assets) on the installation guide for further setup information.

If you're going to use different colors on the switch, be sure to include the `switch-toggle` plugin in your tailwind config. See [Plugins](/docs/laravel-form-components/{version}/advanced-usage/customizing-css#user-content-plugins)
for more information.

## Basic Usage

The most basic usage of the component is just by calling it:

```html
<x-switch-toggle />
```

This will render a toggle element similar to the example shown for the "Simple toggle" on [Tailwind UI](https://tailwindui.com/components/application-ui/forms/toggles).

## Labels

You can easily add a label to the switch toggle by using the `label` attribute:

```html
<x-switch-toggle label="Notifications on" />
```

This will render a label containing the text "Notifications on" to the right side of the switch. You can also use the default slot
to render the label as well:

```html
<x-switch-toggle> Notifications on </x-switch-toggle>
```

### Left aligned labels

You can also render labels on the left of switch by using the `labelLeft` attribute.

```html
<x-switch-toggle label-left="Notifications on" />
```

Now "Notifications on" will be rendered to the left of the switch.

### Multiple Labels

The component allows for labels to be placed on both the left and right side of the switch at the same time.

```html
<x-switch-toggle label-left="Off" label="On" />
```

This will render "Off" to the left, and "On" to the right.

## Handling values

The switch toggle component offers support for both `wire:model` and `wire:model.defer` right out of the box, and is the recommended way
to use this component when you are using Laravel Livewire. Behind-the-scenes, the component will use the `@entangle` blade directive
from livewire to bind the value to a local variable on the component.

```html
<x-switch-toggle
    wire:model.defer="allowNotifications"
    label="Notifications on"
/>
```

> {tip} `x-model` can be used instead if you're not using Livewire in the form.

For non-livewire forms, you may also give the component a `value` to use for the initial value, but be sure to include a `name` attribute so that your server
can receive the value from the switch in a normal form submission.

```html
<x-switch-toggle name="foo" :value="true" />
```

> {note} Only true/false values are supported for the on/off values when used this way.

### Custom on and off values

The switch toggle is not limited to `true` and `false` values for its respective on and off states; it can use strings and integer values as well:

```html
<x-switch-toggle on-value="foo" off-value="bar" />
```

Now when the switch is "off", the value will be "bar", and when it is "on", the value will be "foo".

## Variations

Different size and style variations of the switch may be rendered out-of-the-box:

### Short Toggle

Based on the [short toggle](https://tailwindui.com/components/application-ui/forms/toggles#component-b3e0a15571300f79fced5845f97fa972) example from
Tailwind UI, the short toggle will make the size of the circle on the bar larger than the height of the bar. All you need to do for this style is set
the `short` attribute to `true`:

```html
<x-switch-toggle short />
```

### Sizing

If you're not using the `short` variation, you can adjust the size of the switch via the `size` attribute. The currently supported sizes
are: `sm`, `md`, `lg`, with `md` being the default.

```html
<x-switch-toggle size="lg" />
```

These sizes also come in responsive variants, so if you wanted the switch small on small screens, but large on larger screens, you could do something like this:

```html
<x-switch-toggle class="switch-toggle--sm lg:switch-toggle--lg" />
```

## Icons

Based on the [toggle with icon](https://tailwindui.com/components/application-ui/forms/toggles#component-bcaf782196186836b6ea686e7096e734) from Tailwind UI, the switch
toggle component allows you to specify icons to display on the button for both "on" and "off" states:

```html
<x-switch-toggle on-icon="heroicon-m-check" off-icon="heroicon-m-x-mark" />
```

In this example, you will see an "x" icon when the switch is "off", and a checkmark icon when the switch is "on".

> {note} This example requires the
> [blade heroicon](https://github.com/blade-ui-kit/blade-heroicons) package.

You may also render the icons via slot instead if you prefer:

```html
<x-switch-toggle>
    <x-slot:on-icon>
        <x-heroicon-m-check />
    </x-slot:on-icon>

    <x-slot:off-icon>
        <x-heroicon-m-x-mark />
    </x-slot:off-icon>
</x-switch-toggle>
```

> {note} Icons are not supported when the `short` attribute is set to `true`.

## Colors

By default, the switch-toggle component is configured to show a blue background when it is in an "on" state. Given you have the `switch-toggle` Tailwind plugin included in your tailwind config
file, you will be able to use any of your application's configured colors for the switch using the `color` attribute.

```html
<x-switch-toggle color="red" />
```

## API Reference

### props

| prop              | description                                                                       |
| ----------------- | --------------------------------------------------------------------------------- |
| `name`            | The name of the input                                                             |
| `id`              | The id of the input. Defaults to `name`                                           |
| `value`           | The initial value of the input. Disregarded if `wire:model` or `x-model` present. |
| `onValue`         | The value for when the switch is "on". Defaults to `true`                         |
| `offValue`        | The value for when the switch is "off". Defaults to `false`                       |
| `label`           | Text to display to the right of the switch.                                       |
| `labelLeft`       | Text to display to the left of the switch.                                        |
| `containerClass`  | A CSS class to apply to the **container** of the switch.                          |
| `disabled`        | Disable the switch                                                                |
| `size`            | The size of the switch. Defaults to `md`                                          |
| `color`           | The color of the switch when it is "on". Defaults to blue                         |
| `onIcon`          | An icon to display on the switch when it is in an "on" state                      |
| `offIcon`         | An icon to display on the switch when it is in an "off" state                     |
| `short`           | Display switch as the "short" style. Sizing does not apply to this style.         |
| `extraAttributes` | Pass an array of attributes to apply to the input                                 |

### slots

| slot        | description                                                   |
| ----------- | ------------------------------------------------------------- |
| `label`     | Text to display to the right of the switch.                   |
| `labelLeft` | Text to display to the left of the switch.                    |
| `onIcon`    | An icon to display on the switch when it is in an "on" state  |
| `offIcon`   | An icon to display on the switch when it is in an "off" state |

### config

The following configuration keys and values can be adjusted for common default behavior
you may want for the switch-toggle element.

```php
'defaults' => [
    'global' => [
        // Show error states by default.
        'show_errors' => true,
    ],

    'switch_toggle' => [
        // Apply a CSS class to the label that contains the switch toggle globally.
        'container_class' => null,

        // Apply a CSS class to the switch toggle (not the actual input element) globally.
        'input_class' => null,

        // Set the default size of the switch toggle.
        // Supported: 'sm', 'md', 'lg', (default is 'md')
        'size' => null,

        // Set the default color of the switch toggle. (e.g. "blue", "red", "green", etc.)
        'color' => null,

        // Set the default icon to show when the switch is in an "on" state.
        'on_icon' => null,

        // Set the default icon to show when the switch is in an "off" state.
        'off_icon' => null,
    ],
],
```
