<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Files;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

class FileUploadTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="file-upload space-x-5 ">
            <div x-data="{ focused: false, isUploading: false, progress: 0 }"
                 class="space-y-4 w-full">
                <span class="file-upload__input">
                    <input x-on:focus="focused = true"
                           x-on:blur="focused = false"
                           class="sr-only"
                           type="file"
                           name="file"
                           id="file"
                    />

                    <label for="file"
                           x-bind:class="{ 'file-upload__label--focused': focused }"
                           class="file-upload__label">
                        <span role="button"
                              aria-controls="file"
                              tabindex="0">
                            Select File
                        </span>
                    </label>
                </span>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-file-upload name="file" />'
        );
    }

    /** @test */
    public function can_show_file_upload_progress_if_wire_model_is_set(): void
    {
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="file-upload space-x-5 ">
            <div x-data="{ focused: false, isUploading: false, progress: 0 }"
                 x-on:livewire-upload-start="isUploading = true"
                 x-on:livewire-upload-finish="isUploading = false"
                 x-on:livewire-upload-error="isUploading = false"
                 x-on:livewire-upload-progress="progress = \$event.detail.progress"
                 class="space-y-4 w-full">
                <span class="file-upload__input">
                    <input x-on:focus="focused = true"
                           x-on:blur="focused = false"
                           class="sr-only"
                           type="file"
                           name="file"
                           id="file"
                           wire:model="file"
                    />

                    <label for="file"
                           x-bind:class="{ 'file-upload__label--focused': focused }"
                           class="file-upload__label">
                        <span role="button"
                              aria-controls="file"
                              tabindex="0">
                            Select File
                        </span>
                    </label>
                </span>

                <div class="relative" x-show.transition.opacity.duration.150ms="isUploading" x-cloak>
                    <div class="flex mb-2 items-center justify-between">
                        <div class="file-upload__badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-green-100 text-green-800">
                            Processing...
                        </div>

                        <div class="text-right">
                            <span class="text-xs font-semibold inline-block text-green-600" x-text="progress + '%'">
                            </span>
                        </div>
                    </div>

                    <div class="file-upload__progress overflow-hidden h-2 mb-4 text-xs flex rounded bg-green-200">
                        <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"
                             x-bind:style="'width: ' + progress + '%;'"></div>
                    </div>
                </div>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-file-upload name="file" wire:model="file" />'
        );
    }

    /** @test */
    public function can_have_wire_model_without_upload_progress(): void
    {
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="file-upload space-x-5 ">
            <div x-data="{ focused: false, isUploading: false, progress: 0 }"
                 class="space-y-4 w-full">
                <span class="file-upload__input">
                    <input x-on:focus="focused = true"
                           x-on:blur="focused = false"
                           class="sr-only"
                           type="file"
                           name="file"
                           id="file"
                           wire:model="file"
                    />

                    <label for="file"
                           x-bind:class="{ 'file-upload__label--focused': focused }"
                           class="file-upload__label">
                        <span role="button"
                              aria-controls="file"
                              tabindex="0">
                            Select File
                        </span>
                    </label>
                </span>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-file-upload name="file" wire:model="file" :display-upload-progress="$show" />',
            ['show' => false],
        );
    }

    /** @test */
    public function can_have_an_after_slot(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-file-upload name="file">
            <x-slot name="after">
                <div>After slot content...</div>
            </x-slot>
        </x-file-upload>
        HTML;

        $expected = <<<HTML
        <div class="file-upload space-x-5 ">
            <div x-data="{ focused: false, isUploading: false, progress: 0 }"
                 class="space-y-4 w-full">
                <span class="file-upload__input">
                    <input x-on:focus="focused = true"
                           x-on:blur="focused = false"
                           class="sr-only"
                           type="file"
                           name="file"
                           id="file"
                    />

                    <label for="file"
                           x-bind:class="{ 'file-upload__label--focused': focused }"
                           class="file-upload__label">
                        <span role="button"
                              aria-controls="file"
                              tabindex="0">
                            Select File
                        </span>
                    </label>
                </span>
            </div>

            <div>After slot content...</div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function can_have_default_slotted_content(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-file-upload name="file">
            <div>Default slot content...</div>
        </x-file-upload>
        HTML;

        $expected = <<<HTML
        <div class="file-upload space-x-5 ">
            <div>Default slot content...</div>

            <div x-data="{ focused: false, isUploading: false, progress: 0 }"
                 class="space-y-4 w-full">
                <span class="file-upload__input">
                    <input x-on:focus="focused = true"
                           x-on:blur="focused = false"
                           class="sr-only"
                           type="file"
                           name="file"
                           id="file"
                    />

                    <label for="file"
                           x-bind:class="{ 'file-upload__label--focused': focused }"
                           class="file-upload__label">
                        <span role="button"
                              aria-controls="file"
                              tabindex="0">
                            Select File
                        </span>
                    </label>
                </span>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function adds_class_attribute_to_root_element(): void
    {
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="file-upload space-x-5 foo">
            <div x-data="{ focused: false, isUploading: false, progress: 0 }"
                 class="space-y-4 w-full">
                <span class="file-upload__input">
                    <input x-on:focus="focused = true"
                           x-on:blur="focused = false"
                           class="sr-only"
                           type="file"
                           name="file"
                           id="file"
                    />

                    <label for="file"
                           x-bind:class="{ 'file-upload__label--focused': focused }"
                           class="file-upload__label">
                        <span role="button"
                              aria-controls="file"
                              tabindex="0">
                            Select File
                        </span>
                    </label>
                </span>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-file-upload name="file" class="foo" />'
        );
    }

    /** @test */
    public function shows_aria_attributes_on_error(): void
    {
        $this->withViewErrors(['file' => 'required']);

        $expected = <<<HTML
        <div class="file-upload space-x-5 ">
            <div x-data="{ focused: false, isUploading: false, progress: 0 }"
                 class="space-y-4 w-full">
                <span class="file-upload__input">
                    <input x-on:focus="focused = true"
                           x-on:blur="focused = false"
                           class="sr-only"
                           type="file"
                           name="file"
                           id="file"
                           aria-invalid="true"
                           aria-describedby="file-error"
                    />

                    <label for="file"
                           x-bind:class="{ 'file-upload__label--focused': focused }"
                           class="file-upload__label">
                        <span role="button"
                              aria-controls="file"
                              tabindex="0">
                            Select File
                        </span>
                    </label>
                </span>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-file-upload name="file" />'
        );
    }

    /**
     * @test
     * @dataProvider acceptsTypes
     * @param string $type
     * @param string $shouldAccept
     */
    public function can_be_told_to_accept_certain_preset_types(string $type, string $shouldAccept): void
    {
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="file-upload space-x-5 ">
            <div x-data="{ focused: false, isUploading: false, progress: 0 }"
                 class="space-y-4 w-full">
                <span class="file-upload__input">
                    <input x-on:focus="focused = true"
                           x-on:blur="focused = false"
                           class="sr-only"
                           type="file"
                           name="file"
                           id="file"
                           accept="{$shouldAccept}"
                    />

                    <label for="file"
                           x-bind:class="{ 'file-upload__label--focused': focused }"
                           class="file-upload__label">
                        <span role="button"
                              aria-controls="file"
                              tabindex="0">
                            Select File
                        </span>
                    </label>
                </span>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-file-upload name="file" :type="$type" />',
            compact('type')
        );
    }

    public function acceptsTypes(): array
    {
        $excelTypes = '.csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

        return [
            ['audio', 'audio/*'],
            ['image', 'image/*'],
            ['video', 'video/*'],
            ['pdf', '.pdf'],
            ['csv', '.csv'],
            ['spreadsheet', $excelTypes],
            ['excel', $excelTypes],
            ['text', 'text/plain'],
            ['html', 'text/html'],
        ];
    }
}
