<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

beforeEach(function () {
    config()->set('form-components.defaults.file-upload', [
        'container_class' => null,
        'input_class' => null,
        'display_upload_progress' => false,
        'use_native_progress_bar' => false,
    ]);
});

it('can be rendered', function () {
    Route::get('/test', fn () => Blade::render('<x-file-upload name="file" />'));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->contains('input', [
                'type' => 'file',
                'name' => 'file',
                'id' => 'file',
                'class' => 'file-upload__input',
            ]);
        });
});

it('can show a file upload progress if wire:model is set', function () {
    Route::get('/test', fn () => Blade::render('<x-file-upload name="file" wire:model="file" display-upload-progress />'));

    get('/test')
        ->assertElementExists('.file-upload', function (AssertElement $div) {
            $div->contains('div', [
                'x-on:livewire-upload-start' => 'isUploading = true',
            ])
                ->contains('input', [
                    'type' => 'file',
                    'wire:model' => 'file',
                ]);
        });
});

it('can have a wire:model without upload progress', function () {
    Route::get('/test', fn () => Blade::render('<x-file-upload name="file" wire:model="file" :display-upload-progress="false" />'));

    get('/test')
        ->assertElementExists('.file-upload', function (AssertElement $div) {
            $div->contains('input', [
                'type' => 'file',
                'wire:model' => 'file',
            ])->doesntContain('div', [
                'x-on:livewire-upload-start' => 'isUploading = true',
            ]);
        });
});

it('can render content after the input', function () {
    $template = <<<'HTML'
    <x-file-upload name="file">
        <x-slot:after>
            <div class="after">After slot content</div>
        </x-slot:after>
    </x-file-upload>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('.file-upload', function (AssertElement $div) {
            $after = $div->find('.after');

            $after->containsText('After slot content');
        });
});

it('can render content in the default slot', function () {
    $template = <<<'HTML'
    <x-file-upload name="file">
        <div id="default">Default slot content</div>
    </x-file-upload>
    HTML;

    Route::get('/test', fn () => Blade::render($template));

    get('/test')
        ->assertElementExists('.file-upload', function (AssertElement $div) {
            $div->contains('#default', [
                'text' => 'Default slot content',
            ]);
        });
});

it('shows aria attributes on error', function () {
    $this->withViewErrors(['file' => 'required']);

    Route::get('/test', fn () => Blade::render('<x-file-upload name="file" />'));

    get('/test')
        ->assertElementExists('.file-upload', function (AssertElement $div) {
            $div->contains('input', [
                'aria-invalid' => 'true',
                'aria-describedby' => 'file-error',
            ]);
        });
});

it('can be told to accept certain preset types', function (string $type, string $expected) {
    $template = <<<'HTML'
    <x-file-upload name="file" type="{{ $type }}" />
    HTML;

    Route::get('/test', fn () => Blade::render($template, ['type' => $type]));

    get('/test')
        ->assertElementExists('.file-upload', function (AssertElement $div) use ($expected) {
            $div->contains('input', [
                'accept' => $expected,
            ]);
        });
})->with([
    ['audio', 'audio/*'],
    ['image', 'image/*'],
    ['video', 'video/*'],
    ['pdf', '.pdf'],
    ['csv', '.csv'],
    ['text', 'text/plain'],
    ['html', 'text/html'],
    ['spreadsheet', '.csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
    ['excel', '.csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
]);
