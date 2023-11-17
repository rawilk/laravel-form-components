<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

use function Pest\Laravel\get;

it('can render a label', function () {
    Route::get('/test', fn () => Blade::render('<x-label for="first_name" />'));

    get('/test')
        ->assertElementExists('label', function (AssertElement $label) {
            $label->is('label')
                ->has('for', 'first_name')
                ->containsText('First name')
                ->has('class', 'form-label');
        });
});

test('custom text can be used for a label', function () {
    Route::get('/test', fn () => Blade::render('<x-label for="first_name">My custom label</x-label>'));

    get('/test')
        ->assertElementExists('label', function (AssertElement $label) {
            $label->has('for', 'first_name')
                ->containsText('My custom label')
                ->doesntContainText('First name');
        });
});

test('the for attribute is optional', function () {
    Route::get('/test', fn () => Blade::render('<x-label>My label</x-label>'));

    get('/test')
        ->assertElementExists('label', function (AssertElement $label) {
            $label->doesntHave('for')
                ->containsText('My label');
        });
});

test('nothing is rendered if label is empty', function () {
    Route::get('/test', fn () => Blade::render('<div><x-label /></div>'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->doesntContain('label');
        });
});
