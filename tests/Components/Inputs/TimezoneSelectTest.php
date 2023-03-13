<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Rawilk\FormComponents\Support\TimeZoneRegionEnum;
use function Pest\Laravel\get;
use Rawilk\FormComponents\Support\TimeZoneRegion;
use Sinnbeck\DomAssertions\Asserts\AssertElement;
use Sinnbeck\DomAssertions\Asserts\AssertForm;
use Sinnbeck\DomAssertions\Asserts\AssertSelect;

beforeEach(function () {
    config()->set('form-components.defaults.custom_select', [
        'container_class' => null,
        'input_class' => null,
        'menu_class' => null,
        'searchable' => true,
        'clearable' => false,
        'optional' => false,
        'option_selected_icon' => null,
        'button_icon' => null,
        'clear_icon' => null,
        'min_selected' => null,
        'max_selected' => null,
    ]);

    config()->set('form-components.defaults.timezone_select.use_custom_select', false);
    config()->set('form-components.timezone_subset', false);

    config()->set('form-components.defaults.global.value_field', 'id');
    config()->set('form-components.defaults.global.label_field', 'name');
});

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<form><x-timezone-select name="timezone" /></form>'));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->findSelect('select', function (AssertSelect $select) {
                $select->has('name', 'timezone')
                    ->has('id', 'timezone')
                    ->containsOptions(
                        [
                            'value' => 'GMT',
                        ],
                        [
                            'value' => 'UTC',
                        ],
                        [
                            'value' => 'America/Chicago',
                        ],
                    );
            });
        });
});

it('can include just a specific subset of timezone regions', function () {
    Route::get('/test', fn () => Blade::render('<form><x-timezone-select name="timezone" only="General" /></form>'));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->findSelect('select', function (AssertSelect $select) {
                $select->containsOptions(
                    [
                        'value' => 'GMT',
                    ],
                    [
                        'value' => 'UTC',
                    ],
                );
            });
        })
        ->assertDontSee('America/Chicago');
});

it('can include multiple region subsets', function () {
    // This check can be dropped once we drop support for php 8.0
    $regions = isOnPhp8_0()
        ? [TimeZoneRegion::GENERAL, TimeZoneRegion::AMERICA]
        : [TimeZoneRegionEnum::General->value, TimeZoneRegionEnum::America->value];

    Route::get('/test', fn () => Blade::render('<form><x-timezone-select name="timezone" :only="$regions" /></form>', ['regions' => $regions]));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->findSelect('select', function (AssertSelect $select) {
                $select->containsOptions(
                    [
                        'value' => 'GMT',
                    ],
                    [
                        'value' => 'UTC',
                    ],
                    [
                        'value' => 'America/Chicago',
                    ]
                );
            });
        })
        ->assertDontSee('Europe/London');
});

it('can be configured to always show a specific subset by default', function () {
    config([
        'form-components.timezone_subset' => isOnPhp8_0() ? TimeZoneRegion::GENERAL : TimeZoneRegionEnum::General->value,
    ]);

    Route::get('/test', fn () => Blade::render('<form><x-timezone-select name="timezone" /></form>'));

    get('/test')
        ->assertFormExists('form', function (AssertForm $form) {
            $form->findSelect('select', function (AssertSelect $select) {
                $select->containsOptions(
                    [
                        'value' => 'GMT',
                    ],
                    [
                        'value' => 'UTC',
                    ],
                );
            });
        })
        ->assertDontSee('America/Chicago');
});

it('accepts a container class', function () {
    Route::get('/test', fn () => Blade::render('<form><x-timezone-select name="timezone" container-class="foo" /></form>'));

    get('/test')
        ->assertElementExists('.form-text-container', function (AssertElement $div) {
            $div->has('class', 'foo');
        });
});

test('name can be omitted', function () {
    Route::get('/test', fn () => Blade::render('<x-timezone-select />'));

    get('/test')
        ->assertElementExists('select', function (AssertElement $select) {
            $select->doesntHave('name')
                ->doesntHave('id');
        });
});
