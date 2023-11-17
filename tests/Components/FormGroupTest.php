<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

use function Pest\Laravel\get;

it('can be rendered', function () {
    $template = <<<'HTML'
    <x-form-group label="First name" name="first_name">
        <div>Name input</div>
    </x-form-group>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->is('div')
                ->has('class', 'form-group')
                ->contains('label', [
                    'text' => 'First name',
                    'for' => 'first_name',
                    'class' => 'form-label',
                ]);

            $content = $div->find('.form-group__content');

            $content->contains('div', [
                'text' => 'Name input',
            ]);
        });
});

it('can have help text', function () {
    Route::get('/test', fn () => Blade::render('<x-form-group label="First name" name="first_name" help-text="This is help text"></x-form-group>'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->contains('p', [
                'text' => 'This is help text',
                'id' => 'first_name-description',
                'class' => 'form-help',
            ]);
        });
});

test('help text can be slotted', function () {
    $template = <<<'HTML'
    <x-form-group label="First name" name="first_name">
        <x-slot:help-text>
            Slotted help text
        </x-slot:help-text>
    </x-form-group>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->contains('p', [
                'text' => 'Slotted help text',
                'id' => 'first_name-description',
                'class' => 'form-help',
            ]);
        });
});

it('can have label inline with inputs', function () {
    $template = <<<'HTML'
    <x-form-group label="First name" name="first_name" inline>
        Name input
    </x-form-group>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('.form-group', function (AssertElement $div) {
            $div->contains('div', [
                'class' => 'form-group--inline',
            ]);

            $div->find('.form-group--inline', function (AssertElement $content) {
                $content->contains('div', [
                    'class' => 'form-group__content--inline',
                ]);
            });
        });
});

it('shows input errors automatically', function () {
    $this->withViewErrors(['name' => 'Name is required']);

    $template = <<<'HTML'
    <x-form-group label="First name" name="name">
        Name input
    </x-form-group>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-group')
                ->contains('label', [
                    'text' => 'First name',
                    'for' => 'name',
                    'class' => 'form-label',
                ]);

            $content = $div->find('.form-group__content');

            $content->containsText('Name input');

            $content->contains('p', [
                'text' => 'Name is required',
                'class' => 'form-error',
                'id' => 'name-error',
            ]);
        });
});

test('label can be omitted', function () {
    Route::get('/test', fn () => Blade::render('<x-form-group :label="false" name="name">Name input</x-form-group>'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->doesntContain('label');
        });
});

it('can have optional help text', function () {
    config([
        'form-components.optional_hint_text' => 'Optional',
    ]);

    Route::get('/test', fn () => Blade::render('<x-form-group label="First name" name="first_name" optional></x-form-group>'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->contains('span', [
                'text' => 'Optional',
                'id' => 'first_name-hint',
            ]);
        });
});

it('can have optional hint when inline', function () {
    config([
        'form-components.optional_hint_text' => 'Optional',
    ]);

    Route::get('/test', fn () => Blade::render('<x-form-group label="First name" name="first_name" optional inline></x-form-group>'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->contains('span', [
                'text' => 'Optional',
                'id' => 'first_name-hint',
            ])->contains('span', [
                'text' => 'Optional',
                'id' => 'first_name-hint-inline',
            ]);
        });
});

it('can have custom hint text', function () {
    Route::get('/test', fn () => Blade::render('<x-form-group label="First name" name="first_name" hint="Custom hint"></x-form-group>'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->contains('span', [
                'text' => 'Custom hint',
                'id' => 'first_name-hint',
            ]);
        });
});
