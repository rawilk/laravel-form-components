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

    config()->set('form-components.defaults.tree_select.has_child_icon', null);

    config()->set('form-components.defaults.global.value_field', 'id');
    config()->set('form-components.defaults.global.label_field', 'name');
});

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-tree-select />'));

    get('/test')
        ->assertElementExists('.custom-select', function (AssertElement $select) {
            $select->has('x-data')
                ->has('x-id')
                ->contains('button', [
                    'class' => 'custom-select__button',
                    'x-tree-select:button' => '',
                ])
                ->contains('div', [
                    'class' => 'custom-select__menu',
                    'x-tree-select:options' => '',
                ]);
        });
});
