<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-date-picker name="date" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->is('input')
                ->has('name', 'date')
                ->has('id', 'date')
                ->has('wire:ignore')
                ->has('x-ref', 'input');
        })
        ->assertSee('flatpickr');
});
