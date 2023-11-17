<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

use function Pest\Laravel\get;

beforeEach(function () {
    config()->set('form-components.defaults.custom_select', [
        'container_class' => null,
        'input_class' => null,
        'menu_class' => null,
        'searchable' => true,
        'clearable' => false,
        'optional' => false,
        'option_selected_icon' => null,
        'button_icon' => null,
        'clear_icon' => null,
        'min_selected' => null,
        'max_selected' => null,
    ]);

    config()->set('form-components.defaults.global.value_field', 'id');
    config()->set('form-components.defaults.global.label_field', 'name');
});

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-custom-select />'));

    get('/test')
        ->assertElementExists('.custom-select', function (AssertElement $select) {
            $select->has('x-data')
                ->has('x-id')
                ->contains('button', [
                    'class' => 'custom-select__button',
                    'x-custom-select:button' => '',
                ])
                ->contains('div', [
                    'class' => 'custom-select__menu',
                    'x-custom-select:options' => '',
                ]);
        });
});

it('renders an array of options', function () {
    $options = [
        ['id' => 'foo', 'name' => 'Foo'],
        ['id' => 'bar', 'name' => 'Bar'],
    ];

    Route::get('/test', fn () => Blade::render('<x-custom-select name="my_select" :options="$options" />', ['options' => $options]));

    get('/test')
        ->assertElementExists('.custom-select__menu', function (AssertElement $menu) {
            $menu->contains('li', [
                'text' => 'Foo',
                'x-custom-select:option' => '',
                'class' => 'custom-select__option',
            ])->contains('li', [
                'text' => 'Bar',
                'x-custom-select:option' => '',
                'class' => 'custom-select__option',
            ]);
        });
});

it('can render slotted options', function () {
    $foo = ['id' => 'foo', 'name' => 'Foo'];
    $bar = ['id' => 'bar', 'name' => 'Bar'];

    $template = <<<'HTML'
    <x-custom-select name="foo">
        <x-custom-select-option :value="$foo" />
        <x-custom-select-option :value="$bar" />
    </x-custom-select>
    HTML;

    Route::get('/test', fn () => Blade::render($template, ['foo' => $foo, 'bar' => $bar]));

    get('/test')
        ->assertElementExists('.custom-select__menu', function (AssertElement $menu) {
            $menu->contains('li', [
                'text' => 'Foo',
                'x-custom-select:option' => '',
                'class' => 'custom-select__option',
            ])->contains('li', [
                'text' => 'Bar',
                'x-custom-select:option' => '',
                'class' => 'custom-select__option',
            ]);
        });
});

it('can use custom value and label keys', function () {
    $options = [
        ['value' => 'foo', 'text' => 'Foo'],
        ['value' => 'bar', 'text' => 'Bar'],
    ];

    Route::get('/test', fn () => Blade::render('<x-custom-select name="my_select" :options="$options" value-field="value" label-field="text" />', ['options' => $options]));

    get('/test')
        ->assertElementExists('.custom-select__menu', function (AssertElement $menu) {
            $menu->contains('li', [
                'text' => 'Foo',
                'x-custom-select:option' => '',
                'class' => 'custom-select__option',
            ])->contains('li', [
                'text' => 'Bar',
                'x-custom-select:option' => '',
                'class' => 'custom-select__option',
            ]);
        });
});
