# Set of Blade components for TailwindCSS forms.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rawilk/laravel-form-components.svg?style=flat-square)](https://packagist.org/packages/rawilk/laravel-form-components)
![Tests](https://github.com/rawilk/laravel-form-components/workflows/Tests/badge.svg?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/rawilk/laravel-form-components.svg?style=flat-square)](https://packagist.org/packages/rawilk/laravel-form-components)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require rawilk/package-laravel-form-components-laravel
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Rawilk\LaravelFormComponents\LaravelFormComponentsServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Rawilk\FormComponents\FormComponentsServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

``` php
$laravel-form-components = new Rawilk\LaravelFormComponents;
echo $laravel-form-components->echoPhrase('Hello, Rawilk!');
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email randall@randallwilk.dev instead of using the issue tracker.

## Credits

- [Randall Wilk](https://github.com/rawilk)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
