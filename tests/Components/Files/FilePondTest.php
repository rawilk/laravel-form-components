<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

use function Pest\Laravel\get;

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-file-pond />'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->contains('input', [
                'type' => 'file',
                'x-ref' => 'input',
            ]);
        });
});
