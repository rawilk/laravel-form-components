<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\HtmlString;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

beforeEach(function () {
    config()->set('form-components.defaults.input', [
        'size' => 'md',
        'container_class' => null,
        'input_class' => null,
    ]);
});

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-input name="search" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->is('input')
                ->has('type', 'text')
                ->has('name', 'search')
                ->has('id', 'search')
                ->has('class', 'form-text');
        });
});

test('attributes can be overwritten', function () {
    Route::get('/test', fn () => Blade::render('<x-input name="confirm_password" id="confirmPassword" type="password" class="p-4" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->has('type', 'password')
                ->has('name', 'confirm_password')
                ->has('id', 'confirmPassword')
                ->has('class', 'form-text')
                ->has('class', 'p-4');
        });
});

test('inputs can have old values', function () {
    flashOld(['search' => 'Eloquent']);

    Route::middleware(['web'])->get('/test', fn () => Blade::render('<x-input name="search" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->has('value', 'Eloquent');
        });
});

test('does not add value attribute if wire model is present', function () {
    flashOld(['search' => 'Eloquent']);

    Route::middleware(['web'])->get('/test', fn () => Blade::render('<x-input name="search" wire:model="search" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->doesntHave('value')
                ->has('wire:model', 'search');
        });
});

it('can have a leading addon', function () {
    Route::get('/test', fn () => Blade::render('<x-input name="search" leading-addon="my addon" />'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->has('class', 'has-leading-addon')
                ->contains('span', [
                    'text' => 'my addon',
                    'class' => 'leading-addon',
                ]);
        });
});

test('leading addon can be slotted', function () {
    $template = <<<'HTML'
    <x-input name="search">
        <x-slot:leading-addon>foo</x-slot:leading-addon>
    </x-input>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->has('class', 'has-leading-addon')
                ->contains('span', [
                    'text' => 'foo',
                    'class' => 'leading-addon',
                ]);
        });
});

it('can have an inline addon', function () {
    Route::get('/test', fn () => Blade::render('<x-input name="search" inline-addon="my addon" />'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->has('class', 'has-inline-addon')
                ->contains('div', [
                    'text' => 'my addon',
                    'class' => 'inline-addon',
                ]);
        });
});

test('inline addon can be slotted', function () {
    $template = <<<'HTML'
    <x-input name="search">
        <x-slot:inline-addon>foo</x-slot:inline-addon>
    </x-input>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->has('class', 'has-inline-addon')
                ->contains('div', [
                    'text' => 'foo',
                    'class' => 'inline-addon',
                ]);
        });
});

it('can have a leading icon', function () {
    Route::get('/test', fn () => Blade::render('<x-input name="search" leading-icon="heroicon-s-eye" />'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->has('class', 'has-leading-icon')
                ->contains('div', [
                    'class' => 'leading-icon',
                ]);

            $icon = $div->find('.leading-icon');

            $icon->contains('svg');
        });
});

it('only renders one type of leading addon', function () {
    // 'leading-addon' should be the only one rendered since we check for it first - it has priority.
    $template = <<<'HTML'
    <x-input name="search" leading-addon="foo" inline-addon="bar">
        <x-slot:leading-icon>icon</x-slot:leading-icon>
    </x-input>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->has('class', 'has-leading-addon')
                ->doesntHave('class', 'has-inline-addon')
                ->doesntHave('class', 'has-leading-icon')
                ->contains('span', [
                    'text' => 'foo',
                    'class' => 'leading-addon',
                ])
                ->doesntContain('div', [
                    'class' => 'leading-icon',
                ])
                ->doesntContain('div', [
                    'class' => 'inline-addon',
                ]);
        });
});

it('can have a trailing addon', function () {
    Route::get('/test', fn () => Blade::render('<x-input name="search" trailing-addon="my addon" />'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->has('class', 'has-trailing-addon')
                ->contains('span', [
                    'text' => 'my addon',
                    'class' => 'trailing-addon',
                ]);
        });
});

it('can have an inline trailing addon', function () {
    Route::get('/test', fn () => Blade::render('<x-input name="search" trailing-inline-addon="my addon" />'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->has('class', 'has-trailing-inline-addon')
                ->contains('div', [
                    'text' => 'my addon',
                    'class' => 'trailing-inline-addon',
                ]);
        });
});

test('trailing addon can be slotted', function () {
    $template = <<<'HTML'
    <x-input name="search">
        <x-slot:trailing-addon>foo</x-slot:trailing-addon>
    </x-input>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->has('class', 'has-trailing-addon')
                ->contains('span', [
                    'text' => 'foo',
                    'class' => 'trailing-addon',
                ]);
        });
});

it('can have a trailing icon', function () {
    $template = <<<'HTML'
    <x-input name="search">
        <x-slot:trailing-icon>my icon</x-slot:trailing-icon>
    </x-input>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->has('class', 'has-trailing-icon')
                ->contains('div', [
                    'class' => 'trailing-icon',
                    'text' => 'my icon',
                ]);
        });
});

it('will only render one type of trailing addon', function () {
    // The icon should not be rendered as we check for it last.
    $template = <<<'HTML'
    <x-input name="search" trailing-addon="foo" trailing-inline-addon="bar">
        <x-slot:trailing-icon>my icon</x-slot:trailing-icon>
    </x-input>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->has('class', 'has-trailing-addon')
                ->doesntHave('class', 'has-trailing-inline-addon')
                ->doesntHave('class', 'has-trailing-icon')
                ->contains('span', [
                    'text' => 'foo',
                    'class' => 'trailing-addon',
                ])
                ->doesntContain('div', [
                    'class' => 'trailing-inline-addon',
                    'text' => 'bar',
                ])
                ->doesntContain('div', [
                    'class' => 'trailing-icon',
                    'text' => 'my icon',
                ]);
        });
});

it('can have both leading and trailing addons at the same time', function () {
    $template = <<<'HTML'
    <x-input name="search" leading-addon="leading addon">
        <x-slot:trailing-addon>trailing addon</x-slot:trailing-addon>
    </x-input>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->has('class', 'has-leading-addon')
                ->has('class', 'has-trailing-addon')
                ->contains('span', [
                    'text' => 'leading addon',
                    'class' => 'leading-addon',
                ])
                ->contains('span', [
                    'text' => 'trailing addon',
                    'class' => 'trailing-addon',
                ]);
        });
});

it('adds aria attributes when there is an error', function () {
    $this->withViewErrors(['search' => 'required']);

    Route::get('/test', fn () => Blade::render('<x-input name="search" id="inputSearch" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->has('aria-invalid', 'true')
                ->has('aria-describedby', 'inputSearch-error');
        });
});

it('respects the global show errors setting', function () {
    config()->set('form-components.defaults.global.show_errors', false);

    $this->withViewErrors(['search' => 'required']);

    Route::get('/test', fn () => Blade::render('<x-input name="search" id="inputSearch" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->doesntHave('aria-invalid')
                ->doesntHave('aria-describedby', 'inputSearch-error');
        });
});

test('the global show errors setting can be overridden', function () {
    config()->set('form-components.defaults.global.show_errors', false);

    $this->withViewErrors(['search' => 'required']);

    Route::get('/test', fn () => Blade::render('<x-input name="search" id="inputSearch" show-errors />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->has('aria-invalid', 'true')
                ->has('aria-describedby', 'inputSearch-error');
        });
});

it('combines the aria-describedby attribute on errors if it is already defined on the input', function () {
    $this->withViewErrors(['search' => 'required']);

    Route::get('/test', fn () => Blade::render('<x-input name="search" id="inputSearch" aria-describedby="search-help" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->has('aria-invalid', 'true')
                ->has('aria-describedby', 'search-help inputSearch-error');
        });
});

it('accepts a container class', function () {
    Route::get('/test', fn () => Blade::render('<x-input name="search" container-class="bg-red-500" />'));

    get('/test')
        ->assertElementExists('.form-text-container', function (AssertElement $div) {
            $div->has('class', 'bg-red-500');
        });
});

test('a container class can be set by default', function () {
    config()->set('form-components.defaults.input.container_class', 'default-container-class');

    Route::get('/test', fn () => Blade::render('<x-input name="search" container-class="one-off-container-class" />'));

    get('/test')
        ->assertElementExists('.form-text-container', function (AssertElement $div) {
            $div->has('class', 'one-off-container-class')
                ->has('class', 'default-container-class');
        });
});

test('name attribute can be omitted', function () {
    Route::get('/test', fn () => Blade::render('<x-input />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->doesntHave('name')
                ->doesntHave('id');
        });
});

it('can have custom trailing addon markup', function () {
    $template = <<<'HTML'
    <x-input name="search">
        <x-slot:after>
            <div class="my-custom-trailing-addon">
                My custom addon content
            </div>
        </x-slot:after>
    </x-input>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->contains('div', [
                    'text' => 'My custom addon content',
                    'class' => 'my-custom-trailing-addon',
                ]);
        });
});

it('can have extra attributes', function ($extraAttributes) {
    Route::get('/test', fn () => Blade::render('<x-input name="search" :extra-attributes="$extraAttributes" />', ['extraAttributes' => $extraAttributes]));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->has('data-foo', 'bar');
        });
})->with([
    'data-foo="bar"',
    new HtmlString('data-foo="bar"'),
    [['data-foo' => 'bar']],
    collect(['data-foo' => 'bar']),
]);

test('an input class can be applied by default', function () {
    config()->set('form-components.defaults.input.input_class', 'default-input-class');

    Route::get('/test', fn () => Blade::render('<x-input name="search" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->has('class', 'default-input-class');
        });
});

test('a size class can be applied to the input container for styling', function () {
    Route::get('/test', fn () => Blade::render('<x-input name="search" size="lg" />'));

    get('/test')
        ->assertElementExists('.form-text-container', function (AssertElement $div) {
            $div->has('class', 'form-input--lg');
        });
});
