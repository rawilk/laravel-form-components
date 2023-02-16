<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-tree-select />'));

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
