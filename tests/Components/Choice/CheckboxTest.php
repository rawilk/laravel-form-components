<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

use function Pest\Laravel\get;

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
    Route::get('/test', fn () => Blade::render('<x-checkbox name="remember_me" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->is('input')
                ->has('type', 'checkbox')
                ->has('name', 'remember_me')
                ->has('id', 'remember_me')
                ->has('class', 'form-checkbox');
        });
});

it('accepts custom attributes', function () {
    Route::get('/test', fn () => Blade::render('<x-checkbox name="remember_me" class="p-4" id="rememberMe" value="remember" label="Remember me" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->has('name', 'remember_me')
                ->has('id', 'rememberMe')
                ->has('class', 'form-checkbox p-4')
                ->has('value', 'remember');
        })
        ->assertElementExists('label', function (AssertElement $label) {
            $label->is('label')
                ->has('for', 'rememberMe')
                ->containsText('Remember me');
        });
});

test('label can be slotted', function () {
    Route::get('/test', fn () => Blade::render('<x-checkbox name="remember_me">My label</x-checkbox>'));

    get('/test')
        ->assertElementExists('label', function (AssertElement $label) {
            $label->is('label')
                ->has('for', 'remember_me')
                ->containsText('My label');
        });
});

it('can have old values', function () {
    flashOld(['remember_me' => true]);

    Route::middleware(['web'])->get('/test', fn () => Blade::render('<x-checkbox name="remember_me" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->has('checked');
        });

    flashOld(['remember_me' => false]);

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->doesntHave('checked');
        });
});

it('can have a description', function () {
    Route::get('/test', fn () => Blade::render('<x-checkbox name="remember_me" label="Remember me" description="My description" />'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->contains('.choice-description', [
                'text' => 'My description',
            ])->contains('label', [
                'text' => 'Remember me',
            ]);
        });
});

test('description can be slotted', function () {
    $template = <<<'HTML'
    <x-checkbox name="remember_me" label="Remember me">
        <x-slot:description>
            <div>My description</div>
        </x-slot:description>
    </x-checkbox>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('div:first-of-type', function (AssertElement $div) {
            $div->contains('label', [
                'text' => 'Remember me',
            ]);

            $description = $div->find('.choice-description');

            $description->contains('div', [
                'text' => 'My description',
            ]);
        });
});

it('does not render the "checked" attribute if a wire:model is present', function () {
    Route::get('/test', fn () => Blade::render('<x-checkbox name="remember_me" wire:model="rememberMe" checked />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->doesntHave('checked')
                ->has('wire:model', 'rememberMe');
        });
});

it('can render the label on the left side of the checkbox', function () {
    Route::get('/test', fn () => Blade::render('<x-checkbox name="remember_me" label="Remember me" label-left />'));

    get('/test')
        ->assertElementExists('.choice-label', function (AssertElement $div) {
            $div->has('class', 'choice-label--left');
        });
});
