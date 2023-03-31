---
title: Installation
sort: 3
---

## Notice

Most of the components in this package are based on examples from Tailwind UI. I have my own license for Tailwind UI, but you might not have one.
**Please do not use this package in your own projects without purchasing a Tailwind UI license**, or they'll have to tighten up the licensing,
and you'll ruin the fun for everyone.

Purchase a license here: [https://tailwindui.com/](https://tailwindui.com)

## Installation

You can install the package via composer:

```bash
composer require rawilk/laravel-form-components
```

## Configuration

You may publish the config file via:

```bash
php artisan vendor:publish --tag="form-components-config"
```

[Click here](https://github.com/rawilk/laravel-form-components/blob/{branch}/config/form-components.php) to view the default configuration.

## Assets

### Package JavaScript

To take advantage of some components offered by the package, you will need to include the package's JavaScript (on every page that will be using them).
Add the following before the end `body` tag in your template.

```html
<body>
    ... @fcScripts
</body>
```

You can alternatively use the self-closing tag syntax.

```html
<body>
    ...

    <fc:scripts />
</body>
```

> {note} Be sure to include the scripts after Livewire's scripts if you're using it.

### Third-Party Assets

A few of the components in this package rely on third-party scripts and styles to work properly. Do the following to install all of them, or pick and choose
which ones to install if you're not going to use all the components in this package.

```bash
npm install -D @alpinejs/focus
npm install -D @popperjs/core
npm install -D @tailwindcss/forms
npm install -D alpinejs
npm install -D filepond
npm install -D flatpickr
npm install -D quill
npm install -D tailwindcss
```

> {note} `alpinejs` is required for any of the package's JavaScript to work, and `tailwindcss` and `@tailwindcss/forms` are required to style the components correctly.
> You will also need `@alpinejs/focus` for some functionality to work correctly in the custom select component.

In your project's JavaScript, do the following:

```js
import Alpine from "alpinejs";
import flatpickr from "flatpickr";
import Quill from "quill";
import * as FilePond from "filepond";
import { createPopper } from "@popperjs/core";
import focus from "@alpinejs/focus";

Alpine.plugin(focus);

window.flatpickr = flatpickr;
window.FilePond = FilePond;
window.Quill = Quill;
window.createPopper = createPopper;
window.Alpine = Alpine;

window.Alpine.start();
```

In your project's CSS, do the following for styling:

```css
@import "filepond/dist/filepond.min.css";
@import "flatpickr/dist/flatpickr.min.css";
@import "quill/dist/quill.snow.css";

@tailwind base;
@tailwind components;
@tailwind utilities;
```

> {tip} You are free to use a CDN version of any third-party assets as an alternative to loading them through npm.

### Package Styles

Assuming your app CSS file is located in `/resources/css/app.css`, you can load in the package's styles like this:

```css
...
    @import
    "../../vendor/rawilk/laravel-form-components/resources/css/index.css";
```

This will import all the package's styles into your stylesheet, however you are free to import only the stylesheets you need as well; they are all
located in same directory as the `index.css` stylesheet.

If you would like to customize the CSS we provide, head over to [the section on customizing CSS](/docs/laravel-form-components/{version}/advanced-usage/customizing-css). It's
also important to read over this section, as it will detail any Tailwind config requirements to get the styles working correctly.

## Views

You may override any component's view by publishing them to your project:

```bash
php artisan vendor:publish --tag="form-components-views"
```

### Tailwind Configuration

Some custom configuration is necessary for the package's CSS to compile correctly, and for some components to be styled correctly. Head over to the
[customizing CSS](/docs/laravel-form-components/{version}/advanced-usage/customizing-css) docs for more information on configuring Tailwind.

## Components

Even though all components come enabled out-of-the-box, you might just want to
only load the components you need in your app for performance reasons. To do so,
first [publish the config file](#user-content-configuration), then remove the components
you don't need from the `components` settings.

You can also choose to use different classes for components. This allows you
to either extend or completely change the component's functionality by using a custom class
and/or view of your own.

> {tip} If you remove an alias of a component, it will still be available under the `form-components::` component namespace.

### Component Namespace

The package also declares a `form-components` blade component namespace. This means that
for any component you may also use the `<x-form-components::component-name>` syntax. For the `input`
component, you would use `<x-form-components::inputs.input />`. If you choose to render the components
using this method, you can safely remove the component alias from the config.

### Overriding Components

If you are going to override the class definition of a component, you can certainly change the class reference in the `components`
config key, but for some components, it won't use your custom class when they're referenced by the package. The best way to override
a component's class is to re-bind it in a service provider. Here's an example of using a custom class for the `label` component in your
`AppServiceProvider`:

```php
namespace App\Providers;

use App\View\Components\LabelOverride;
use Illuminate\Support\ServiceProvider;
use Rawilk\FormComponents\Components\Label;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Label::class, LabelOverride::class);
    }
}
```

This will ensure that anytime the `Label` component is resolved, it will actually use your custom `LabelOverride` class instead to render the component. More
information on this can be found in the [overriding classes](/docs/laravel-form-components/{version}/advanced-usage/overriding-classes) documentation.

## Asset URL

For cases where your app's root domain is not the correct path for retrieving assets, you may set a custom root path that
FormComponents will use to link to its JavaScript assets. You may specify a custom root path either in the config file,
or as a parameter option through the blade directive:

In the config:

```php
[
    // ...
    'asset_url' => 'myapp.com/app',
];
```

In your layouts:

```html
@fcScripts(['asset_url' => 'myapp.com/app'])
```

> {note} If you use the self-closing tag `<fc:scripts />`, you must define the custom URL in the config file.

## Prefixing

Using components from this library might conflict with other ones from a different
library or components from your own app. To prevent this you can opt to prefixing
FormComponents components by default to prevent these collisions. You can do this by
setting the `prefix` option in the config file:

```php
<?php

return [
    // ...
    'prefix' => 'tw',
    // ...
];
```

Now all components can be referenced as usual but with the prefix before their name:

```html
<x-tw-form action="https://example.com" />
```

For obvious reasons, the docs don't use any prefix in their code examples. So keep
this in mind when setting a prefix and copying/pasting code snippets.

## Translations

If you need to customize any of the language lines from the package, you may publish the translation files with this command:

```bash
php artisan vendor:publish --tag="form-components-translations"
```
