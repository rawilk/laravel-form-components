<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;
use Sinnbeck\DomAssertions\Asserts\AssertForm;
use Sinnbeck\DomAssertions\Asserts\AssertSelect;

beforeEach(function () {
    config()->set('form-components.defaults.select', [
        'input_class' => null,
    ]);
});

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-select name="country" id="countrySelect" />'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->contains('select');
        })
        ->assertElementExists('select', function (AssertElement $select) {
            $select->is('select')
                ->has('name', 'country')
                ->has('id', 'countrySelect')
                ->has('class', 'form-select');
        });
});

it('accepts an array of options', function () {
    $options = [
        'can' => 'Canada',
        'usa' => 'United States',
    ];

    $template = <<<'HTML'
    <form>
        <x-select name="country" :options="$options" />
    </form>
    HTML;

    Route::get('/test', fn () => Blade::render($template, ['options' => $options]));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->findSelect('select', function (AssertSelect $select) {
                $select->containsOptions(
                    [
                        'value' => 'can',
                        'text' => 'Canada',
                    ],
                    [
                        'value' => 'usa',
                        'text' => 'United States',
                    ],
                );
            });
        });
});

test('values can be pre-selected', function () {
    flashOld(['country' => 'usa']);

    $options = [
        'can' => 'Canada',
        'usa' => 'United States',
    ];

    $template = <<<'HTML'
    <form>
        <x-select name="country" :options="$options" />
    </form>
    HTML;

    Route::middleware(['web'])->get('/test', fn () => Blade::render($template, ['options' => $options]));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->findSelect('select', function (AssertSelect $select) {
                $select->hasValue('usa');
            });
        });
});

test('a default value can be given', function () {
    $options = [
        'can' => 'Canada',
        'usa' => 'United States',
    ];

    $template = <<<'HTML'
    <form>
        <x-select name="country" :options="$options" value="can" />
    </form>
    HTML;

    Route::get('/test', fn () => Blade::render($template, ['options' => $options]));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->findSelect('select', function (AssertSelect $select) {
                $select->hasValue('can');
            });
        });
});

it('accepts custom attributes', function () {
    flashOld(['country' => 'usa']);

    $options = [
        'can' => 'Canada',
        'usa' => 'United States',
    ];

    // The "value" attribute should be overridden by th flashed old input.
    $template = <<<'HTML'
    <form>
        <x-select name="country" id="country_code" class="px-4" value="can" :options="$options" />
    </form>
    HTML;

    Route::middleware(['web'])->get('/test', fn () => Blade::render($template, ['options' => $options]));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->findSelect('select', function (AssertSelect $select) {
                $select->has('id', 'country_code')
                    ->has('class', 'px-4')
                    ->hasValue('usa');
            });
        });
});

it('can be a multi-select', function () {
    flashOld(['country' => ['usa', 'mex']]);

    $options = [
        'can' => 'Canada',
        'usa' => 'United States',
        'mex' => 'Mexico',
    ];

    $template = <<<'HTML'
    <form>
        <x-select name="country" :options="$options" multiple />
    </form>
    HTML;

    Route::middleware(['web'])->get('/test', fn () => Blade::render($template, ['options' => $options]));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->findSelect('select', function (AssertSelect $select) {
                $select->has('multiple')
                    ->hasValues(['usa', 'mex']);
            });
        });
});

it('indicates it has an error', function () {
    $this->withViewErrors(['country' => 'required']);

    $options = [
        'can' => 'Canada',
        'usa' => 'United States',
    ];

    Route::get('/test', fn () => Blade::render('<x-select name="country" :options="$options" />', ['options' => $options]));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->contains('select');
        })
        ->assertElementExists('select', function (AssertElement $select) {
            $select->has('class', 'input-error')
                ->has('aria-invalid', 'true')
                ->has('aria-describedby', 'country-error');
        });
});

it('respects global show error config value', function () {
    config()->set('form-components.defaults.global.show_errors', false);

    $this->withViewErrors(['country' => 'required']);

    $options = [
        'can' => 'Canada',
        'usa' => 'United States',
    ];

    Route::get('/test', fn () => Blade::render('<x-select name="country" :options="$options" />', ['options' => $options]));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->has('class', 'form-text-container')
                ->contains('select');
        })
        ->assertElementExists('select', function (AssertElement $select) {
            $select->doesntHave('class', 'input-error')
                ->doesntHave('aria-invalid')
                ->doesntHave('aria-describedby', 'country-error');
        });
});

it('accepts options in the default slot', function () {
    flashOld(['country' => 'usa']);

    $template = <<<'HTML'
    <form>
        <x-select name="country">
            <option value="can" @selected($component->isSelected('can'))>Canada</option>
            <option value="usa" @selected($component->isSelected('usa'))>United States</option>
        </x-select>
    </form>
    HTML;

    Route::middleware(['web'])->get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->findSelect('select', function (AssertSelect $select) {
                $select->containsOptions(
                    [
                        'value' => 'can',
                        'text' => 'Canada',
                    ],
                    [
                        'value' => 'usa',
                        'text' => 'United States',
                    ],
                )->hasValue('usa');
            });
        });
});

test('name can be omitted', function () {
    Route::get('/test', fn () => Blade::render('<x-select />'));

    get('/test')
        ->assertElementExists('select', function (AssertElement $select) {
            $select->doesntHave('name')
                ->doesntHave('id');
        });
});

it('accepts a container class', function () {
    $template = <<<'HTML'
    <x-select name="country" container-class="foo" />
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('.form-text-container', function (AssertElement $div) {
            $div->has('class', 'foo');
        });
});

it('can prepend and append options', function () {
    // Options in the default slot will be prepended to the options passed to the component.
    $options = [
        'can' => 'Canada',
        'usa' => 'United States',
    ];

    $template = <<<'HTML'
    <form>
        <x-select name="country" :options="$options">
            <option value="ger">Germany</option>

            <x-slot:append>
                <option value="fra">France</option>
            </x-slot:append>
        </x-select>
    </form>
    HTML;

    Route::get('/test', fn () => Blade::render($template, ['options' => $options]));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->findSelect('select', function (AssertSelect $select) {
                $select->containsOptions(
                    [
                        'value' => 'ger',
                        'text' => 'Germany',
                    ],
                    [
                        'value' => 'can',
                        'text' => 'Canada',
                    ],
                    [
                        'value' => 'usa',
                        'text' => 'United States',
                    ],
                    [
                        'value' => 'fra',
                        'text' => 'France',
                    ],
                );
            });
        })
        ->assertSeeInOrder(['Germany', 'Canada', 'United States', 'France']);
});
