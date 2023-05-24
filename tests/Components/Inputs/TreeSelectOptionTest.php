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

    config()->set('form-components.defaults.tree_select.has_child_icon', null);

    config()->set('form-components.defaults.global.value_field', 'id');
    config()->set('form-components.defaults.global.label_field', 'name');
    config()->set('form-components.defaults.global.children_field', 'children');
});

it('can be rendered', function () {
    $option = ['id' => 'foo', 'name' => 'Foo'];

    $template = <<<'HTML'
    <x-tree-select>
        <x-tree-select-option :value="$option" />
    </x-tree-select>
    HTML;

    Route::get('/test', fn () => Blade::render($template, ['option' => $option]));

    get('/test')
        ->assertElementExists('.custom-select__option', function (AssertElement $option) {
            $option->is('div')
                ->contains('span', [
                    'text' => 'Foo',
                ])
                ->has('x-tree-select:option', '');
        });
});

it('renders children options', function () {
    $option = [
        'id' => 'foo',
        'name' => 'Foo',
        'children' => [
            ['id' => 'foo_1', 'name' => 'Foo 1'],
            ['id' => 'foo_2', 'name' => 'Foo 2', 'children' => [
                ['id' => 'foo_2_1', 'name' => 'Foo 2.1'],
            ]],
        ],
    ];

    $template = <<<'HTML'
    <x-tree-select>
        <x-tree-select-option :value="$option" />
    </x-tree-select>
    HTML;

    Route::get('/test', fn () => Blade::render($template, ['option' => $option]));

    get('/test')
        ->assertElementExists('.custom-select__menu-content', function (AssertElement $menu) {
            $menu->find('.tree-select__option-li', function (AssertElement $option) {
                $option->contains('.tree-select__option', [
                    'text' => 'Foo',
                    'level' => '0',
                ]);

                $option->find('.tree-select__children', function (AssertElement $children) {
                    $children->find('.tree-select__option-li:first-child', function (AssertElement $option) {
                        $option->contains('.tree-select__option', [
                            'text' => 'Foo 1',
                            'level' => '1',
                        ])
                            ->doesntContain('.tree-select__children');
                    })
                        ->find('.tree-select__option-li:last-child', function (AssertElement $option) {
                            $option->contains('.tree-select__option', [
                                'text' => 'Foo 2',
                                'level' => '1',
                            ])
                                ->find('.tree-select__children', function (AssertElement $children) {
                                    $children->find('.tree-select__option-li', function (AssertElement $option) {
                                        $option->contains('.tree-select__option', [
                                            'text' => 'Foo 2.1',
                                            'level' => '2',
                                        ])
                                            ->doesntContain('.tree-select__children');
                                    });
                                });
                        });
                });
            });
        });
});

it('will not show child indicators on empty collections', function () {
    $option = [
        'id' => 'foo',
        'name' => 'Foo',
        'children' => collect(),
    ];

    $template = <<<'HTML'
    <x-tree-select>
        <x-tree-select-option :value="$option" />
    </x-tree-select>
    HTML;

    Route::get('/test', fn () => Blade::render($template, ['option' => $option]));

    get('/test')
        ->assertElementExists('.tree-select__option-li', function (AssertElement $option) {
            $option->doesntContain('ul', [
                'class' => 'tree-select__children',
            ]);
        });
});
