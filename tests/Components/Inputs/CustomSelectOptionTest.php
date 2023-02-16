<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-custom-select-option />'));

    get('/test')
        ->assertElementExists('.custom-select-option', function (AssertElement $option) {
            $option->is('li')
                ->has('role', 'option')
                ->has('x-data');
        });
});

it('is aware of parent select name', function () {
    $template = <<<'HTML'
    <x-custom-select name="foo">
        <x-custom-select-option value="bar" />
    </x-custom-select>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    // Every option gets an id assigned that is a combination of the parent
    // select's name and the option's value.
    get('/test')
        ->assertElementExists('.custom-select-option', function (AssertElement $option) {
            $option->has('id', 'customSelectfooOption-bar');
        });
});

it('can render a checkbox on the option', function () {
    $template = <<<'HTML'
    <x-custom-select name="foo" show-checkbox multiple>
        <x-custom-select-option value="foo" label="Foo" />
    </x-custom-select>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('.custom-select-option', function (AssertElement $option) {
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
    <x-custom-select name="foo" :show-checkbox="false" multiple>
        <x-custom-select-option value="foo" label="Foo" />
    </x-custom-select>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('.custom-select-option', function (AssertElement $option) {
            $option->doesntContain('input', [
                'type' => 'checkbox',
            ]);
        });
});

test('label can be slotted', function () {
    Route::get('/test', fn () => Blade::render('<x-custom-select-option value="foo">My custom label</x-custom-select-option>'));

    get('/test')
        ->assertElementExists('.custom-select-option', function (AssertElement $option) {
            $option->containsText('My custom label');
        });
});

it('can be classified as an opt group', function () {
    Route::get('/test', fn () => Blade::render('<x-custom-select-option value="foo" label="Foo" is-opt-group />'));

    get('/test')
        ->assertElementExists('.custom-select-option', function (AssertElement $option) {
            $option->has('class', 'custom-select-option--opt-group')
                ->doesntHave('x-data')
                ->doesntHave('x-on:click.stop')
                ->contains('span', [
                    'text' => 'Foo',
                ]);
        });
});
