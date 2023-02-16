<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

it('can be rendered', function () {
    $this->withViewErrors(['first_name' => 'Name is required']);

    Route::get('/test', fn () => Blade::render('<x-form-error name="first_name" />'));

    get('/test')
        ->assertElementExists('p', function (AssertElement $p) {
            $p->is('p')
                ->has('class', 'form-error')
                ->has('id', 'first_name-error')
                ->containsText('Name is required');
        });
});

it('can be slotted', function () {
    $this->withViewErrors(['first_name' => ['Incorrect first name.', 'Needs at least 5 characters.']]);

    $template = <<<'HTML'
    <x-form-error name="first_name" tag="div">
        <ul>
            @foreach ($component->messages($errors) as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-form-error>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $ul = $div->find('ul');

            $ul->contains('li:first-child', [
                'text' => 'Incorrect first name.',
            ]);

            $ul->contains('li:last-child', [
                'text' => 'Needs at least 5 characters.',
            ]);
        });
});
