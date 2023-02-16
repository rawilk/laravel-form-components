<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Rawilk\FormComponents\Tests\Components\Support\SetsComponentPrefix;
use Sinnbeck\DomAssertions\Asserts\AssertForm;

uses(SetsComponentPrefix::class);

test('a custom prefix can be used', function () {
    Route::get('/test', fn () => Blade::render('<x-tw-form action="https://example.com" />'));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->has('action', 'https://example.com');
        });
});
