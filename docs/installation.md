---
title: Installation
sort: 3
---

## Installation

You can install the package via composer:

```bash
composer require rawilk/laravel-form-components
```

## Configuration

You may publish the config file via:

```bash
php artisan fc:publish
```

This is the default configuration:

```php
use Rawilk\FormComponents\Components;

return [
    /*
    |--------------------------------------------------------------------------
    | Components
    |--------------------------------------------------------------------------
    |
    | Below you reference all form components that should be loaded for your
    | app. By default all components from laravel-form-components are loaded
    | in. You can disable or overwrite any component class or alias that
    | you want.
    |
    */
    'components' => [

        'form' => [
            'class' => Components\Form::class,
            'view' => 'form-components::components.form',
        ],

        'input' => [
            'class' => Components\Inputs\Input::class,
            'view' => 'form-components::components.inputs.input',
        ],

        'email' => [
            'class' => Components\Inputs\Email::class,
            'view' => 'form-components::components.inputs.input',
        ],

        'password' => [
            'class' => Components\Inputs\Password::class,
            'view' => 'form-components::components.inputs.password',

            /*
             * This icon will show when the password is masked and show toggle is enabled.
             * Can be overridden individually as well.
             */
            'show_password_icon' => 'heroicon-s-eye',

            /*
             * This icon will show when the password is un-masked and show toggle is enabled.
             * Can be overridden individually as well.
             */
            'hide_password_icon' => 'heroicon-o-eye-off',
        ],

        'textarea' => [
            'class' => Components\Inputs\Textarea::class,
            'view' => 'form-components::components.inputs.textarea',
        ],

        'checkbox' => [
            'class' => Components\Choice\Checkbox::class,
            'view' => 'form-components::components.choice.checkbox-or-radio',
        ],

        'radio' => [
            'class' => Components\Choice\Radio::class,
            'view' => 'form-components::components.choice.checkbox-or-radio',
        ],

        'select' => [
            'class' => Components\Inputs\Select::class,
            'view' => 'form-components::components.inputs.select',
        ],

        'label' => [
            'class' => Components\Label::class,
            'view' => 'form-components::components.label',
        ],

        'checkbox-group' => [
            'class' => Components\Choice\CheckboxGroup::class,
            'view' => 'form-components::components.choice.checkbox-group',
        ],

        'form-group' => [
            'class' => Components\FormGroup::class,
            'view' => 'form-components::components.form-group',
        ],

        'form-error' => [
            'class' => Components\FormError::class,
            'view' => 'form-components::components.form-error',
        ],

        'timezone-select' => [
            'class' => Components\Inputs\TimezoneSelect::class,
            'view' => 'form-components::components.inputs.timezone-select',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Prefix
    |--------------------------------------------------------------------------
    |
    | This value will set a prefix for all laravel-form-components blade
    | components. By default it's empty. This is useful if you want to avoid
    | collision with components from other libraries.
    |
    | If set with "tw", for example, you can reference components like:
    |
    | <x-tw-form />
    |
    */
    'prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | Enable Timezone Select
    |--------------------------------------------------------------------------
    |
    | If you don't plan on using a timezone select in your app, you can disable
    | it here. This will prevent the use of app('fc-timezone'). You should also
    | remove the "timezone-select" from the registered components in the config
    | as well.
    |
    */
    'enable_timezone' => true,

    /*
    |--------------------------------------------------------------------------
    | Default Timezone Subset
    |--------------------------------------------------------------------------
    |
    | You may not always need the full list of timezones to choose from,
    | so you may define a subset of regions to pull from instead. Set
    | the value to `false` to use all regions.
    |
    | Example: [\Rawilk\FormComponents\Support\TimezoneRegion::AMERICA]
    |
    */
    'timezone_subset' => false,

];
```

## Views

You may override the views, either by using your own views and specifying them in the config, or by publishing the package's views:

```bash
php artisan fc:publish --views
```

**Note:** This will also publish the package's configuration as well.

## Styling

Laravel Form Components includes some utility classes styled in `.scss` stylesheets. If you're using
sass, you can pull in the package's styles into your stylesheets by importing the `form-components.scss` stylesheet.

If you have a `./resources/sass/app.scss` stylesheet, you can do:

```css
@import '../../vendor/rawilk/laravel-form-components/resources/sass/form-components';

/* Add your overrides here */
```

## Components

Even though all components come enabled out-of-the-box, you might just want to
only load the components you need in your app for performance reasons. To do so,
first [publish the config file](#configuration), then remove the components
you don't need from the `components` settings.

You can also choose to use different classes and views for components. This allows you
to either extend or completely change the component's functionality by using a custom class
and/or view of your own.

## Prefixing

Using components from this library might conflict with other ones from a different
library or components from our own app. To prevent this you can opt to prefixing
Form Components components by default to prevent these collisions. You can do this by
setting the `prefix` option in the config file:

```php
<?php

return [
    ...
    'prefix' => 'tw',
    ...
];
```

Now all components can be referenced as usual but with the prefix before their name:

```html
<x-tw-form action="http://example.com" />
```

For obvious reasons, the docs don't use any prefix in their code examples. So keep
this in mind when setting a prefix and copying/pasting code snippets.
