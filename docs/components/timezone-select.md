---
title: Timezone Select
sort: 14
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

This will output:

```html
<div class="form-text-container ">
    <select name="timezone" id="timezone" class="form-select">
        <optgroup label="General">
            <option value="GMT">GMT</option>
            <option value="UTC">UTC</option>
        </optgroup>
        <optgroup label="Africa">
            ...
        </optgroup>
        <optgroup label="America">
            ...
            <option value="America/Chicago">(GMT/UTC -05:00) America/Chicago</option>
            ...
        </optgroup>
        <optgroup label="Antarctica">
            ...
        </optgroup>
        <optgroup label="Arctic">
            ...
        </optgroup>
        <optgroup label="Asia">
            ...
        </optgroup>
        <optgroup label="Atlantic">
            ...
        </optgroup>
        <optgroup label="Australia">
            ...
        </optgroup>
        <optgroup label="Europe">
            ...
        </optgroup>
        <optgroup label="Indian">
            ...
        </optgroup>
        <optgroup label="Pacific">
            ...
        </optgroup>
    </select>
</div>
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

In both cases, this will output:
```html
<div class="form-text-container ">
    <select name="timezone" id="timezone" class="form-select">
        <optgroup label="America">
            ...
        </optgroup>
    </select>
</div>
```

With both methods, you can use a boolean value `false` to include every timezone region available.
