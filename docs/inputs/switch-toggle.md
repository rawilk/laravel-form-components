---
title: Switch Toggle
sort: 9
---

## Introduction

The `switch-toggle` component offers an easy alternative to a traditional checkbox and is heavily based on
the [Tailwind UI toggle component](https://tailwindui.com/components/application-ui/forms/toggles). The
switch toggle acts like a checkbox, however it allows for an "off" value and an "on" value; see [custom on and off values](#custom-on-and-off-values)
for more info.

## Installation

While the `switch-toggle` component works out-of-the-box when you've [set the directive](/docs/laravel-form-components/v3/installation#directives),
we recommend that you install and compile the JavaScript libraries before you deploy to production:

- [Alpine.js](https://github.com/alpinejs/alpine) `^2.8`

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

This will render a label containing the text "Notifications on" to the right side of the switch.

### Left aligned labels

You can also render labels on the left of switch by setting `label-position` to `left`:

```html
<x-switch-toggle label="Notifications on" label-position="left" />
```

Now "Notifications on" will be rendered to the left of the switch.

## Handling values

The switch toggle component offers support for both `wire:model` and `wire:model.defer` right out of the box, and is the recommended way
to use this component when you are using Laravel Livewire. Behind-the-scenes, the component will use the `@entangle` blade directive
from livewire to bind the value to a local variable on the component.

```html
<x-switch-toggle wire:model.defer="allowNotifications" label="Notifications on" />
```

For non-livewire forms, you may also give the component a `value` to use for the initial value, but be sure to include a `name` attribute so that your server
can receive the value from the switch in a normal form submission.

```html
<x-switch-toggle name="foo" :value="true" />
```

When the component is given a name attribute, it will render a hidden input so that the current value of the component is passed on to the server via a form submission.
The hidden input rendered from the example above will look like this:

```html
<input type="hidden" name="foo" x-bind:value="JSON.stringify(value)" />
```

### Custom on and off values

The switch toggle is not limited to `true` and `false` values for its respective "on" and "off" values; it can use strings and integer values as well:

```html
<x-switch-toggle on-value="foo" off-value="bar" />
```

Now when the switch is "off", the value will be "bar", and when it is "on", the value will be "foo".

## Variations

Different size and style variations of the switch may be rendered out-of-the-box:

### Short Toggle

Based on the [short toggle](https://tailwindui.com/components/application-ui/forms/toggles#component-b3e0a15571300f79fced5845f97fa972) example from
Tailwind UI, the short toggle will make the size of the circle on the bar larger than the height of the bar. All you need to do for this style is set
the `short` flag to `true`:

```html
<x-switch-toggle short />
```

### Sizing

Both the simple and short toggle variations allow for different sizing out-of-the-box. Simply pass in a `size` to the component to re-size it:

```html
<x-switch-toggle size="lg" />
```

Here are the sizes the package provides by default for each variation:

**Simple**:
- sm
- base (default)
- lg

**Short**:
- base (default)
- lg

These sizes also come in responsive variants, so if you wanted the switch small on small screens, but large on larger screens, you could do something like this:

```html
<x-switch-toggle class="switch-toggle--sm lg:switch-toggle--lg" />
```

You are free to add your own sizes in your own stylesheets. Just reference the [switch toggle styles](https://github.com/rawilk/laravel-form-components/blob/master/resources/sass/utils/_switch.scss#L126) for guidance.

## Icons

Based on the [toggle with icon](https://tailwindui.com/components/application-ui/forms/toggles#component-bcaf782196186836b6ea686e7096e734) from Tailwind UI, the switch
toggle component allows you to specify icons to display on the button for both "on" and "off" states:

```html
<x-switch-toggle>
    <x-slot name="offIcon">
        <x-heroicon-s-x class="w-3 h-3 text-gray-400" />
    </x-slot>
    
    <x-slot name="onIcon">
        <x-heroicon-s-check class="w-3 h-3 text-blue-600" />
    </x-slot>
</x-switch-toggle>
```

In this example, you will see an "x" icon when the switch is "off", and a checkmark icon when the switch is "on".

> {note} This example requires the 
[blade heroicon](https://github.com/blade-ui-kit/blade-heroicons) package.
