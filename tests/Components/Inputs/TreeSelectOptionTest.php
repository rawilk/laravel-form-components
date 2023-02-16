<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-tree-select-option />'));

    get('/test')
        ->assertElementExists('.tree-select-option', function (AssertElement $option) {
            $option->is('li')
                ->has('role', 'option')
                ->has('x-data');
        });
});

it('is aware of parent select name', function () {
    $template = <<<'HTML'
    <x-tree-select name="foo">
        <x-tree-select-option value="bar" />
    </x-tree-select>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    // Every option gets an id assigned that is a combination of the parent
    // select's name and the option's value.
    get('/test')
        ->assertElementExists('.tree-select-option', function (AssertElement $option) {
            $option->has('id', 'treeSelectfooOption-bar');
        });
});

it('can render a checkbox on the option', function () {
    $template = <<<'HTML'
    <x-tree-select name="foo" show-checkbox multiple>
        <x-tree-select-option value="foo" label="Foo" />
    </x-tree-select>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('.tree-select-option', function (AssertElement $option) {
            $option->contains('input', [
                'type' => 'checkbox',
                'name' => 'foo',
                'id' => 'foofoo',
                'value' => 'foo',
            ]);
        });
});

test('showing a checkbox is optional', function () {
    $template = <<<'HTML'
    <x-tree-select name="foo" :show-checkbox="false" multiple>
        <x-tree-select-option value="foo" label="Foo" />
    </x-tree-select>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('.tree-select-option', function (AssertElement $option) {
            $option->doesntContain('input', [
                'type' => 'checkbox',
            ]);
        });
});

test('label can be slotted', function () {
    Route::get('/test', fn () => Blade::render('<x-tree-select-option value="foo">My custom label</x-tree-select-option>'));

    get('/test')
        ->assertElementExists('.tree-select-option', function (AssertElement $option) {
            $option->containsText('My custom label');
        });
});

it('renders children options', function () {
    // Note: To render child options, the option must be inside a tree select component,
    // so it can reference the child's value and text keys correctly.
    $children = [
        ['id' => 'child_1_value', 'name' => 'Child 1', 'children' => []],
        ['id' => 'child_2_value', 'name' => 'Child 2', 'children' => []],
    ];

    $template = <<<'HTML'
    <x-tree-select name="foo">
        <x-tree-select-option value="parent_1" label="Parent" :children="$children" />
    </x-tree-select>
    HTML;

    Route::get('/test', fn () => Blade::render($template, ['children' => $children]));

    get('/test')
        ->assertElementExists('.tree-select-option', function (AssertElement $option) {
            $option->has('id', 'treeSelectfooOption-parent_1')
                ->has('data-level', '0')
                ->containsText('Parent');

            $option->contains('.tree-select-option__children');

            $ul = $option->find('.tree-select-option__children > ul');

            $ul->contains('li:first-child', [
                'data-level' => '1',
                'role' => 'option',
                'id' => 'treeSelectfooOption-child_1_value',
                'text' => 'Child 1',
            ])->contains('li:last-child', [
                'data-level' => '1',
                'role' => 'option',
                'id' => 'treeSelectfooOption-child_2_value',
                'text' => 'Child 2',
            ]);
        });
});
