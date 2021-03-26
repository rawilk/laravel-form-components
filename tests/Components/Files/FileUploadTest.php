<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Files;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;
use Spatie\Snapshots\MatchesSnapshots;

class FileUploadTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_be_rendered(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-file-upload name="file" />')
        );
    }

    /** @test */
    public function can_show_file_upload_progress_if_wire_model_is_set(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-file-upload name="file" wire:model="file" />')
        );
    }

    /** @test */
    public function can_have_wire_model_without_upload_progress(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-file-upload name="file" wire:model="file" :display-upload-progress="false" />')
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

        $this->assertMatchesSnapshot($this->renderComponent($template));
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

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function adds_class_attribute_to_root_element(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-file-upload name="file" class="foo" />')
        );
    }

    /** @test */
    public function shows_aria_attributes_on_error(): void
    {
        $this->withViewErrors(['file' => 'required']);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-file-upload name="file" />')
        );
    }

    /**
     * @test
     * @dataProvider acceptsTypes
     * @param string $type
     */
    public function can_be_told_to_accept_certain_preset_types(string $type): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-file-upload name="file" :type="$type" />', ['type' => $type])
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
