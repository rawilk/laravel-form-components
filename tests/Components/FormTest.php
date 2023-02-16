<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Sinnbeck\DomAssertions\Asserts\AssertForm;
use function Pest\Laravel\get;

it('renders a form', function () {
    $template = <<<'HTML'
    <x-form action="https://example.com">
        <div>Form fields</div>
    </x-form>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->is('form')
                ->hasAction('https://example.com')
                ->hasMethod('POST')
                ->hasCSRF()
                ->doesntHave('enctype', 'multipart/form-data')
                ->has('spellcheck', 'false');

            $form->contains('div', [
                'text' => 'Form fields',
            ]);
        });
});

test('the submit method can be set', function (string $method) {
    Route::get('/test', fn () => Blade::render('<x-form method="' . $method . '" action="https://example.com"></x-form>'));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) use ($method) {
            $form->hasAction('https://example.com')
                ->hasMethod('POST')
                ->hasSpoofMethod($method)
                ->hasCSRF();
        });
})->with([
    'put',
    'patch',
    'delete',
]);

it('can enable file uploads', function () {
    Route::get('/test', fn () => Blade::render('<x-form method="POST" action="https://example.com" has-files></x-form>'));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->has('enctype', 'multipart/form-data');
        });
});

test('action is optional', function () {
    Route::get('/test', fn () => Blade::render('<x-form />'));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->doesntHave('action');
        });
});

test('certain form methods do not render a csrf token', function (string $method) {
    Route::get('/test', fn () => Blade::render('<x-form method="' . $method . '" action="https://example.com"></x-form>'));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) use ($method) {
            $form->hasAction('https://example.com')
                ->hasMethod($method);

            $form->doesntContain('input', [
                'name' => '_token',
            ]);
        });
})->with([
    'get',
]);

test('custom attributes may be used', function () {
    $template = <<<'HTML'
    <x-form action="https://example.com" method="GET" wire:submit.prevent="submit" class="my-form">
        <div>Form fields</div>
    </x-form>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->hasAction('https://example.com')
                ->hasMethod('GET')
                ->has('wire:submit.prevent', 'submit')
                ->has('class', 'my-form');
        });
});
