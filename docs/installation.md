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

];
```

## Views

You may override the views, either by using your own views and specifying them in the config, or by publishing the package's views:

```bash
php artisan fc:publish --views
```

**Note:** This will also publish the package's configuration as well.
