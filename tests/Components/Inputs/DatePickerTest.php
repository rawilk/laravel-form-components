<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

beforeEach(function () {
    config()->set('form-components.defaults.date_picker', [
        'clear_icon' => null,
        'toggle_icon' => null,
    ]);
});

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-date-picker name="date" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->is('input')
                ->has('name', 'date')
                ->has('id', 'date')
                ->has('x-date-picker:input');
        });
});

test('a placeholder can be set globally', function () {
    config()->set('form-components.defaults.date_picker.placeholder', 'my placeholder');

    Route::get('/test', fn () => Blade::render('<x-date-picker name="date" />'));

    get('/test')
        ->assertElementExists('input', function (AssertElement $input) {
            $input->has('placeholder', 'my placeholder');
        });
});

it('allows custom config to be set in a slot', function () {
    $template = <<<HTML
    <x-date-picker name="date">
        <x-slot:config>
            onClose() {
                console.log('closed');
            },
        </x-slot:config>
    </x-date-picker>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertSeeInOrder([
            'config: {',
            'onClose() {',
            'console.log(\'closed\');',
            '}',
        ], false);
});

test('content can set at the bottom of the element markup', function () {
    $template = <<<HTML
    <x-date-picker name="date">
        <x-slot:end>
            <div class="my-content">My content</div>
        </x-slot:end>
    </x-date-picker>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('.date-picker-root', function (AssertElement $div) {
            $div->contains('.my-content', [
                'text' => 'My content',
            ]);
        });
});
