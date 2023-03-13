<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

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
    config()->set('form-components.defaults.global.children_field', 'children');
});

it('can be rendered', function () {
    $option = ['id' => 'foo', 'name' => 'Foo'];

    $template = <<<'HTML'
    <x-custom-select>
        <x-custom-select-option :value="$option" />
    </x-custom-select>
    HTML;

    Route::get('/test', fn () => Blade::render($template, ['option' => $option]));

    get('/test')
        ->assertElementExists('.custom-select__option', function (AssertElement $option) {
            $option->is('li')
                ->contains('span', [
                    'text' => 'Foo',
                ])
                ->has('x-custom-select:option', '');
        });
});

it('can be classified as an opt group', function () {
    $option = [
        'id' => 'foo',
        'name' => 'Foo',
        'children' => [
            ['id' => 'bar', 'name' => 'Bar'],
        ],
    ];

    $template = <<<'HTML'
    <x-custom-select>
        <x-custom-select-option :value="$option" />
    </x-custom-select>
    HTML;

    Route::get('/test', fn () => Blade::render($template, ['option' => $option]));

    get('/test')
        ->assertElementExists('.custom-select__menu', function (AssertElement $menu) {
            $menu->contains('li', [
                'text' => 'Foo',
                'class' => 'custom-select__opt-group',
                'is-opt-group' => '',
            ]);

            // Opt group children should be recursively rendered into the DOM.
            $menu->contains('li', [
                'text' => 'Bar',
                'class' => 'custom-select__option',
            ]);
        });
});
