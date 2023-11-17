<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

use function Pest\Laravel\get;

beforeEach(function () {
    config()->set('form-components.defaults.choice.size', null);
});

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-checkbox-group>Checkboxes...</x-checkbox-group>'));

    get('/test')
        ->assertElementExists('.form-checkbox-group', function (AssertElement $div) {
            $div->has('text', 'Checkboxes...');
        });
});

it('can be rendered as a grid instead of being stacked', function () {
    Route::get('/test', fn () => Blade::render('<x-checkbox-group :stacked="false">Checkboxes...</x-checkbox-group>'));

    get('/test')
        ->assertElementExists('.form-checkbox-group', function (AssertElement $div) {
            $div->has('class', 'form-checkbox-group--inline')
                ->doesntHave('class', 'form-checkbox-group--stacked');
        });
});

it('can have a custom amount of grid columns', function () {
    Route::get('/test', fn () => Blade::render('<x-checkbox-group :stacked="false" :grid-cols="6" />'));

    get('/test')
        ->assertElementExists('.form-checkbox-group', function (AssertElement $div) {
            $div->has('style', '--fc-checkbox-grid-cols: 6;');
        });
});
