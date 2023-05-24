<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-email name="email" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->is('input')
                ->has('type', 'email')
                ->has('name', 'email');
        });
});

it('does not allow type to be overridden', function () {
    Route::get('/test', fn () => Blade::render('<x-email name="email" type="url" id="my-email" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->is('input')
                ->has('type', 'email')
                ->has('name', 'email')
                ->has('id', 'my-email')
                ->doesntHave('type', 'url');
        });
});
