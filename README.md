# Laravel Form Components

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rawilk/laravel-form-components.svg?style=flat-square)](https://packagist.org/packages/rawilk/laravel-form-components)
![Tests](https://github.com/rawilk/laravel-form-components/workflows/Tests/badge.svg?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/rawilk/laravel-form-components.svg?style=flat-square)](https://packagist.org/packages/rawilk/laravel-form-components)

![social image](https://banners.beyondco.de/Laravel%20Form%20Components.png?theme=light&packageManager=composer+require&packageName=rawilk%2Flaravel-form-components&pattern=diagonalStripes&style=style_1&description=Form+components+built+for+tailwind+%26+Livewire&md=1&showWatermark=0&fontSize=100px&images=code)

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

You can view the default configuration here: https://github.com/rawilk/laravel-form-components/blob/main/config/form-components.php

## Documentation

For more documentation, please visit: https://randallwilk.dev/docs/laravel-form-components

## Demo

For a demo of some of the components, please visit: https://laravel-form-components.randallwilk.dev

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

Please review [my security policy](../../security) on how to report security vulnerabilities.

## Credits

- [Randall Wilk](https://github.com/rawilk)
- [All Contributors](../../contributors)

This package is also heavily inspired by [Laravel Form Components](https://github.com/protonemedia/laravel-form-components) and [Blade UI Kit](https://blade-ui-kit.com/).

## Alternatives

This package was created to satisfy my own needs and preferences, and relies on TailwindCSS, TailwindUI, and AlpineJS for styling and functionality. You can always
try one of these alternatives if your needs differ:

- [Blade UI Kit](https://blade-ui-kit.com/)
- [Laravel Form Components](https://github.com/protonemedia/laravel-form-components)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
