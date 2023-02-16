<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-switch-toggle id="foo" />'));

    get('/test')
        ->assertElementExists('div:first-of-type', function (AssertElement $div) {
            $div->has('x-data')
                ->has('wire:ignore.self')
                ->contains('button', [
                    'x-ref' => 'button',
                    'type' => 'button',
                    'id' => 'foo',
                    'text' => __('form-components::messages.switch_button_label'),
                ]);
        });
});

it('accepts a container class', function () {
    Route::get('/test', fn () => Blade::render('<x-switch-toggle container-class="foo" />'));

    get('/test')
        ->assertElementExists('div:first-of-type', function (AssertElement $div) {
            $div->has('class', 'foo');
        });
});

it('applies custom attributes to the button', function () {
    Route::get('/test', fn () => Blade::render('<x-switch-toggle data-foo="bar" id="foo" class="foo-class" />'));

    get('/test')
        ->assertElementExists('div:first-of-type', function (AssertElement $div) {
            $div->contains('button', [
                'data-foo' => 'bar',
                'id' => 'foo',
                'class' => 'foo-class',
            ]);
        });
});

it('can have a wire:model', function () {
    $template = '<x-switch-toggle wire:model="foo" />';

    Route::get('/test', fn () => Blade::render('<livewire:blank-livewire-component :template="$template" />', ['template' => $template]));

    get('/test')
        ->assertSee('value: window.Livewire.find(')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->doesntHave('wire:model');
        });
});

it('creates a hidden input when a name is given', function () {
    Route::get('/test', fn () => Blade::render('<x-switch-toggle name="foo" />'));

    get('/test')
        ->assertElementExists('input[type="hidden"]', function (AssertElement $input) {
            $input->has('name', 'foo');
        });
});

it('can have a label', function () {
    Route::get('/test', fn () => Blade::render('<x-switch-toggle label="My label" />'));

    get('/test')
        ->assertElementExists('.switch-toggle-label', function (AssertElement $label) {
            $label->containsText('My label')
                ->has('x-on:click');
        });
});

it('can have a label on the left', function () {
    Route::get('/test', fn () => Blade::render('<x-switch-toggle label="My label" label-position="left" />'));

    get('/test')
        ->assertSeeInOrder([
            'My label',
            '<button',
        ], false);
});

it('can have on and off state icons', function () {
    $template = <<<'HTML'
    <x-switch-toggle>
        <x-slot:off-icon>
            <span class="off">off</span>
        </x-slot:off-icon>
        <x-slot:on-icon>
            <span class="on">on</span>
        </x-slot:on-icon>
    </x-switch-toggle>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('div:first-of-type', function (AssertElement $div) {
            $div->contains('span.off', [
                'text' => 'off',
            ])
            ->contains('span.on', [
                'text' => 'on',
            ]);
        });
});

it('can be different sizes', function () {
    Route::get('/test', fn () => Blade::render('<x-switch-toggle size="sm" />'));

    get('/test')
        ->assertElementExists('div:first-of-type', function (AssertElement $div) {
            $div->contains('button', [
                'class' => 'switch-toggle--sm',
            ]);
        });
});
