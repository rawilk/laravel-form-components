<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

beforeEach(function () {
    config()->set('form-components.defaults.switch_toggle', [
        'container_class' => null,
        'input_class' => null,
        'size' => null,
        'color' => null,
        'on_icon' => null,
        'off_icon' => null,
    ]);
});

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-switch-toggle id="foo" />'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('x-data')
                ->has('wire:ignore.self')
                ->contains('label', [
                    'class' => 'switch-toggle-container',
                ])
                ->contains('input', [
                    'class' => 'sr-only peer',
                    'type' => 'checkbox',
                ])
                ->contains('.switch-toggle');
        });
});

it('accepts a container class', function () {
    Route::get('/test', fn () => Blade::render('<x-switch-toggle container-class="foo" />'));

    get('/test')
        ->assertElementExists('.switch-toggle-container', function (AssertElement $container) {
            $container->has('class', 'foo');
        });
});

test('container class can be set globally', function () {
    config()->set('form-components.defaults.switch_toggle.container_class', 'my-default');

    Route::get('/test', fn () => Blade::render('<x-switch-toggle />'));

    get('/test')
        ->assertElementExists('.switch-toggle-container', function (AssertElement $container) {
            $container->has('class', 'my-default');
        });
});

it('applies custom attributes to the input', function () {
    Route::get('/test', fn () => Blade::render('<x-switch-toggle data-foo="bar" id="foo" class="foo-class" />'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->contains('input', [
                'data-foo' => 'bar',
                'id' => 'foo',
            ])
                ->contains('.switch-toggle', [
                    'class' => 'foo-class',
                ]);
        });
});

it('can have a wire:model', function () {
    $template = '<x-switch-toggle wire:model="foo" />';

    Route::get('/test', fn () => Blade::render('<livewire:blank-livewire-component :template="$template" />', ['template' => $template]));

    get('/test')
        ->assertSee('value: window.Livewire.find(')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->doesntHave('wire:model');
        });
});

it('can have a label', function () {
    Route::get('/test', fn () => Blade::render('<x-switch-toggle label="My label" />'));

    get('/test')
        ->assertElementExists('.switch-toggle__label', function (AssertElement $label) {
            $label->containsText('My label');
        });
});

it('can have a label on the left', function () {
    Route::get('/test', fn () => Blade::render('<x-switch-toggle label-left="Left label" />'));

    get('/test')
        ->assertSeeInOrder([
            'switch-toggle__label',
            'switch-toggle',
        ], false)
        ->assertElementExists('.switch-toggle__label', function (AssertElement $label) {
            $label->containsText('Left label')->has('class', 'switch-toggle__label--left');
        });
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
        ->assertElementExists('div', function (AssertElement $div) {
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
        ->assertElementExists('div', function (AssertElement $div) {
            $div->contains('.switch-toggle', [
                'class' => 'switch-toggle--sm',
            ]);
        });
});
