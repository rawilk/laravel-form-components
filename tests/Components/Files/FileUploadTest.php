<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Files;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class FileUploadTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->blade('<x-file-upload name="file" />')
            ->assertSee('file-upload')
            ->assertSee('<input', false)
            ->assertSee('type="file"', false)
            ->assertSee('name="file"', false)
            ->assertSee('<label', false);
    }

    /** @test */
    public function can_show_file_upload_progress_if_wire_model_is_set(): void
    {
        $this->blade('<x-file-upload name="file" wire:model="file" />')
            ->assertSee('livewire-upload-progress')
            ->assertSee('wire:model="file"', false)
            ->assertSee('progress');
    }

    /** @test */
    public function can_have_wire_model_without_upload_progress(): void
    {
        $this->blade('<x-file-upload name="file" wire:model="file" :display-upload-progress="false" />')
            ->assertDontSee('livewire-upload-progress');
    }

    /** @test */
    public function can_have_an_after_slot(): void
    {
        $template = <<<'HTML'
        <x-file-upload name="file">
            <x-slot name="after">
                <div>After slot content...</div>
            </x-slot>
        </x-file-upload>
        HTML;

        $this->blade($template)
            ->assertSeeInOrder([
                '<input',
                '<label',
                '<div>After slot content...</div>',
            ], false);
    }

    /** @test */
    public function can_have_default_slotted_content(): void
    {
        $template = <<<'HTML'
        <x-file-upload name="file">
            <div>Default slot content...</div>
        </x-file-upload>
        HTML;

        $this->blade($template)
            ->assertSee('<div>Default slot content...', false);
    }

    /** @test */
    public function shows_aria_attributes_on_error(): void
    {
        $this->withViewErrors(['file' => 'required']);

        $this->blade('<x-file-upload name="file" />')
            ->assertSee('aria-invalid="true"', false)
            ->assertSee('aria-describedby="file-error"', false);
    }

    /**
     * @test
     *
     * @dataProvider acceptsTypes
     */
    public function can_be_told_to_accept_certain_preset_types(string $type, string $expected): void
    {
        $template = <<<HTML
        <x-file-upload name="file" type="$type" />
        HTML;

        $this->blade($template)
            ->assertSee('accept="'.$expected.'"', false);
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
