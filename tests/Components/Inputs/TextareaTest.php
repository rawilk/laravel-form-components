<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-textarea name="about" />'));

    get('/test')
        ->assertElementExists('textarea', function (AssertElement $textarea) {
            $textarea->is('textarea')
                ->has('name', 'about')
                ->has('id', 'about')
                ->has('class', 'form-input');
        });
});

it('allows custom attributes', function () {
    Route::get('/test', fn () => Blade::render('<x-textarea name="about" rows="10" cols="20" class="p-4" id="aboutMe" />'));

    get('/test')
        ->assertElementExists('textarea', function (AssertElement $textarea) {
            $textarea->is('textarea')
                ->has('name', 'about')
                ->has('id', 'aboutMe')
                ->has('class', 'form-input p-4')
                ->has('rows', '10')
                ->has('cols', '20');
        });
});

it('shows old values', function () {
    flashOld(['about' => 'About me text']);

    Route::middleware(['web'])->get('/test', fn () => Blade::render('<x-textarea name="about" />'));

    get('/test')
        ->assertElementExists('textarea', function (AssertElement $textarea) {
            $textarea->containsText('About me text');
        });
});

test('name can be omitted', function () {
    Route::get('/test', fn () => Blade::render('<x-textarea />'));

    get('/test')
        ->assertElementExists('textarea', function (AssertElement $textarea) {
            $textarea->doesntHave('name')
                ->doesntHave('id');
        });
});

it('accepts a container class', function () {
    Route::get('/test', fn () => Blade::render('<x-textarea name="about" container-class="foo" />'));

    get('/test')
        ->assertElementExists('.form-text-container', function (AssertElement $div) {
            $div->has('class', 'foo')
                ->contains('textarea', [
                    'name' => 'about',
                ]);
        });
});
