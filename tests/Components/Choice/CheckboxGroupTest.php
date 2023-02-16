<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-checkbox-group>Checkboxes...</x-checkbox-group>'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'space-y-4')
                ->containsText('Checkboxes...');
        });
});

it('can be rendered as a grid instead of being stacked', function () {
    Route::get('/test', fn () => Blade::render('<x-checkbox-group :stacked="false">Checkboxes...</x-checkbox-group>'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'grid')
                ->doesntHave('class', 'space-y-4');
        });
});

it('can have a custom amount of grid columns', function () {
    Route::get('/test', fn () => Blade::render('<x-checkbox-group :stacked="false" grid-cols="6" />'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('style', '--fc-checkbox-grid-cols: 6;');
        });
});
