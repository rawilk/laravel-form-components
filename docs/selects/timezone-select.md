---
title: Timezone Select
sort: 3
---

## Introduction

Laravel form components provides a simple way to render a select with timezones. This kind of input can be useful when you need to allow users
to choose what timezone they are in. The timezone select extends the regular select component, so anything you can do with the normal select
can be done with the timezone select.

## Basic Usage

The most basic usage of the timezone select involves setting a name attribute:

```html
<x-timezone-select name="timezone" />
```

## Excluding Regions

You may not always want or need to show a list of every timezone region. You can specify a specific region or group or regions to
be rendered either by using the `timezone_subset` config option, or the `only` prop for a per-case basis.

Via config:
```php
...
'timezone_subset' => [\Rawilk\FormComponents\Support\TimeZoneRegion::AMERICA],
```

Via prop:
```html
<x-timezone-select name="timezone" :only="['America']" />
```

With both methods, you can use a boolean value `false` to include every timezone region available.

## Custom Select Support

As of version `1.4.0`, the timezone select can be rendered either as a native select input, or by using the
[custom-select component](/docs/laravel-form-components/components/custom-select). To use the custom-select
component, simply pass in a true boolean value for the `use-custom-select` attribute on the timezone select.

```html
<x-timezone-select use-custom-select />
```

By default, the timezone select uses the native select input, so you will explicitly tell it to use
the custom-select component any time you render the timezone select component.

> {note} If you want to render it as a custom-select, you need to ensure you have followed the
[installation steps](/docs/laravel-form-components/{version}/selects/custom-select#installation) for the `custom-select` component.
