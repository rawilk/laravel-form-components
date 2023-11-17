<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

use function Pest\Laravel\get;

beforeEach(function () {
    config()->set('form-components.defaults.password', [
        'show_toggle' => true,
        'show_icon' => 'heroicon-s-eye',
        'hide_icon' => 'heroicon-s-eye',
    ]);
});

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-password name="password" />'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('x-data');
        })
        ->assertElementExists('input', function (AssertElement $input) {
            $input->is('input')
                ->has('x-bind:type', "show ? 'text' : 'password'")
                ->has('class', 'password-toggleable');
        });
});

test('password toggle can be disabled', function () {
    Route::get('/test', fn () => Blade::render('<x-password name="password" :show-toggle="false" />'));

    get('/test')
        ->assertElementExists('.form-text-container', function (AssertElement $div) {
            $div->doesntHave('x-data');
        })
        ->assertElementExists('input', function (AssertElement $input) {
            $input->doesntHave('class', 'password-toggleable')
                ->has('type', 'password');
        });
});

test('password toggle can be by default', function () {
    config()->set('form-components.defaults.password.show_toggle', false);

    Route::get('/test', fn () => Blade::render('<x-password name="password" />'));

    get('/test')
        ->assertElementExists('.form-text-container', function (AssertElement $div) {
            $div->doesntHave('x-data');
        })
        ->assertElementExists('input', function (AssertElement $input) {
            $input->doesntHave('class', 'password-toggleable');
        });
});

it('can have a leading addon', function () {
    Route::get('/test', fn () => Blade::render('<x-password name="password" leading-addon="foo" />'));

    get('/test')
        ->assertElementExists('.form-text-container', function (AssertElement $div) {
            $div->contains('span', [
                'text' => 'foo',
                'class' => 'leading-addon',
            ]);
        });
});

it('ignores trailing addons', function () {
    Route::get('/test', fn () => Blade::render('<x-password name="password" trailing-addon="foo" />'));

    get('/test')
        ->assertElementExists('.form-text-container', function (AssertElement $div) {
            $div->doesntContain('div', [
                'text' => 'foo',
                'class' => 'trailing-addon',
            ]);
        });
});

test('name can be omitted', function () {
    Route::get('/test', fn () => Blade::render('<x-password />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->doesntHave('name')
                ->doesntHave('id');
        });
});
