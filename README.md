> Package Abandonment: Since I now use packages like Filament for my UI needs, I no longer have an interest or incentive to maintain this package.

# Form Components for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rawilk/laravel-form-components.svg?style=flat-square)](https://packagist.org/packages/rawilk/laravel-form-components)
![Tests](https://github.com/rawilk/laravel-form-components/workflows/Tests/badge.svg?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/rawilk/laravel-form-components.svg?style=flat-square)](https://packagist.org/packages/rawilk/laravel-form-components)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/rawilk/laravel-form-components?style=flat-square)](https://packagist.org/packages/rawilk/laravel-form-components)
[![License](https://img.shields.io/github/license/rawilk/laravel-form-components?style=flat-square)](https://github.com/rawilk/laravel-form-components/blob/main/LICENSE.md)

![social image](https://banners.beyondco.de/Form%20Components%20for%20Laravel.png?theme=light&packageManager=composer+require&packageName=rawilk%2Flaravel-form-components&pattern=diagonalStripes&style=style_1&description=Form+components+built+for+tailwind+%26+Livewire&md=1&showWatermark=0&fontSize=100px&images=code)

Form Components for Laravel provides common form components to help build forms faster using Tailwind CSS. Supports validation, old form values, and wire:model.

## Installation

You can install the package via composer:

```bash
composer require rawilk/laravel-form-components
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="form-components-config"
```

You can view the default configuration here: https://github.com/rawilk/laravel-form-components/blob/main/config/form-components.php

You can publish the package's views with this command:

```bash
php artisan vendor:publish --tag="form-components-views"
```

If you want to override the package's language lines, you can publish them with this command:

```bash
php artisan vendor:publish --tag="form-components-translations"
```

## Documentation

For more documentation, please visit: https://randallwilk.dev/docs/laravel-form-components

## Demo

For a demo of some of the components, please visit: https://laravel-form-components.randallwilk.dev

## Testing

```bash
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
A lot of inspiration for some JS components is taken from [Alpine Headless Components](https://alpinejs.dev/components#headless).

## Alternatives

This package was created to satisfy my own needs and preferences, and relies on TailwindCSS, TailwindUI, and AlpineJS for styling and functionality. You can always
try one of these alternatives if your needs differ:

- [Blade UI Kit](https://blade-ui-kit.com/)
- [Laravel Form Components](https://github.com/protonemedia/laravel-form-components)

## Disclaimer

This package is not affiliated with, maintained, authorized, endorsed or sponsored by Laravel, TailwindCSS, Laravel Livewire, Alpine.js, or any of its affiliates.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
