# Laravel Form Components

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rawilk/laravel-form-components.svg?style=flat-square)](https://packagist.org/packages/rawilk/laravel-form-components)
![Tests](https://github.com/rawilk/laravel-form-components/workflows/Tests/badge.svg?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/rawilk/laravel-form-components.svg?style=flat-square)](https://packagist.org/packages/rawilk/laravel-form-components)

Laravel form components provides common form components to help build forms faster using Tailwind CSS. Supports validation, old form values, and wire:model.

## Installation

You can install the package via composer:

```bash
composer require rawilk/laravel-form-components
```

You can publish the config file with:
```bash
php artisan fc:publish
```

**Tip:** You can also publish the package views by adding the `--views` flag to the command:

```bash
php artisan fc:publish --views
```

This is the contents of the published config file:

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

## Documentation

For more documentation, please visit: https://randallwilk.dev/docs/laravel-form-components

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email randall@randallwilk.dev instead of using the issue tracker.

## Credits

- [Randall Wilk](https://github.com/rawilk)
- [All Contributors](../../contributors)

This package is also heavily inspired by [Laravel Form Components](https://github.com/protonemedia/laravel-form-components) and [Blade UI Kit](https://blade-ui-kit.com/).

## Alternatives

This package was created to satisfy my own needs and preferences, and relies on TailwindCSS, TailwindUI, and AlpineJS for styling and functionality. You can always
try one of these alternatives if your needs differ:

- [Blade UI Kit](https://blade-ui-kit.com/)
- [Laravel Form Components](https://github.com/protonemedia/laravel-form-components)

## Roadmap

- Add more form components, such as file inputs and date pickers.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
