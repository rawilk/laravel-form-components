<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-custom-select />'));

    get('/test')
        ->assertElementExists('div:first-child > div:first-child', function (AssertElement $select) {
            $select->has('x-data')
                ->has('data-name')
                ->contains('div', [
                    'x-ref' => 'menu',
                ])
                ->contains('.custom-select__button');
        });
});

it('renders an array of options', function () {
    $options = [
        ['id' => 'foo', 'name' => 'Foo'],
        ['id' => 'bar', 'name' => 'Bar'],
    ];

    Route::get('/test', fn () => Blade::render('<x-custom-select name="my_select" :options="$options" />', ['options' => $options]));

    get('/test')
        ->assertElementExists('[x-ref="menu"]', function (AssertElement $menu) {
            $foo = $menu->find('li#customSelectmy_selectOption-foo');
            $foo->containsText('Foo');

            $bar = $menu->find('li#customSelectmy_selectOption-bar');
            $bar->containsText('Bar');
        });
});

it('can render slotted options', function () {
    $template = <<<'HTML'
    <x-custom-select name="foo">
        <x-custom-select-option value="foo" label="Foo" />
        <x-custom-select-option value="bar" label="Bar" />
    </x-custom-select>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('[x-ref="menu"]', function (AssertElement $menu) {
            $foo = $menu->find('li#customSelectfooOption-foo');
            $foo->containsText('Foo');

            $bar = $menu->find('li#customSelectfooOption-bar');
            $bar->containsText('Bar');
        });
});

it('accepts a flat array of options', function () {
    $options = ['foo', 'bar'];

    Route::get('/test', fn () => Blade::render('<x-custom-select name="my_select" :options="$options" />', ['options' => $options]));

    get('/test')
        ->assertElementExists('[x-ref="menu"]', function (AssertElement $menu) {
            $foo = $menu->find('li#customSelectmy_selectOption-foo');
            $foo->containsText('foo');

            $bar = $menu->find('li#customSelectmy_selectOption-bar');
            $bar->containsText('bar');
        });
});

it('can use custom value and label keys', function () {
    $options = [
        ['value' => 'foo', 'text' => 'Foo'],
        ['value' => 'bar', 'text' => 'Bar'],
    ];

    Route::get('/test', fn () => Blade::render('<x-custom-select name="my_select" :options="$options" value-field="value" label-field="text" />', ['options' => $options]));

    get('/test')
        ->assertElementExists('[x-ref="menu"]', function (AssertElement $menu) {
            $foo = $menu->find('li#customSelectmy_selectOption-foo');
            $foo->containsText('Foo');

            $bar = $menu->find('li#customSelectmy_selectOption-bar');
            $bar->containsText('Bar');
        });
});

it('renders a hidden input when no wire:model or x-model is present', function () {
    Route::get('/test', fn () => Blade::render('<x-custom-select name="my_select" />'));

    get('/test')
        ->assertElementExists('input[type="hidden"]', function (AssertElement $input) {
            $input->has('name', 'my_select')
                ->has('x-bind:value', 'value');
        });

    Route::get('/test2', fn () => Blade::render('<x-custom-select name="my_select" multiple />'));

    get('/test2')
        ->assertElementExists('input[type="hidden"]', function (AssertElement $input) {
            $input->has('name', 'my_select[]')
                ->has('x-bind:value', 'singleValue');
        });
});
