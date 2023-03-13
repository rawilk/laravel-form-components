<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

beforeEach(function () {
    config()->set('form-components.defaults.choice', [
        'container_class' => null,
        'input_class' => null,
        'size' => null,
        'inline_description' => false,
        'label_left' => false,
    ]);
});

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-radio name="remember_me" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->is('input')
                ->has('type', 'radio')
                ->has('name', 'remember_me')
                ->has('id', 'remember_me')
                ->has('class', 'form-radio');
        });
});
