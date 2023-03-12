<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

beforeEach(function () {
    config()->set('form-components.defaults.textarea', [
        'rows' => 3,
        'auto_resize' => true,
    ]);
});

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-textarea name="about" />'));

    get('/test')
        ->assertElementExists('textarea', function (AssertElement $textarea) {
            $textarea->is('textarea')
                ->has('name', 'about')
                ->has('id', 'about')
                ->has('class', 'form-text')
                ->has('x-textarea-resize');
        });
});

it('allows custom attributes', function () {
    Route::get('/test', fn () => Blade::render('<x-textarea name="about" rows="10" cols="20" class="p-4" id="aboutMe" />'));

    get('/test')
        ->assertElementExists('textarea', function (AssertElement $textarea) {
            $textarea->is('textarea')
                ->has('name', 'about')
                ->has('id', 'aboutMe')
                ->has('class', 'form-text p-4')
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

test('container class can be applied by default', function () {
    config()->set('form-components.defaults.input.container_class', 'default-container');

    Route::get('/test', fn () => Blade::render('<x-textarea name="about" />'));

    get('/test')
        ->assertElementExists('.form-text-container', function (AssertElement $div) {
            $div->has('class', 'default-container')
                ->contains('textarea', [
                    'name' => 'about',
                ]);
        });
});

test('rows can be set by default', function () {
    config()->set('form-components.defaults.textarea.rows', 10);

    Route::get('/test', fn () => Blade::render('<x-textarea name="about" />'));

    get('/test')
        ->assertElementExists('textarea', function (AssertElement $textarea) {
            $textarea->has('rows', '10');
        });
});

test('auto resize can be disabled by default', function () {
    config()->set('form-components.defaults.textarea.auto_resize', false);

    Route::get('/test', fn () => Blade::render('<x-textarea name="about" />'));

    get('/test')
        ->assertElementExists('textarea', function (AssertElement $textarea) {
            $textarea->doesntHave('x-textarea-resize');
        });
});
