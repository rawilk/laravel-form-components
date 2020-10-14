<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Files;

use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;

class FileUpload extends BladeComponent
{
    use HandlesValidationErrors;

    /** @var string */
    public $name;

    /** @var string */
    public $id;

    /** @var string */
    public $label;

    public bool $multiple;

    /*
     * Display the file upload progress if using livewire.
     * Only applies if a "wire:model" attribute is set.
     */
    public bool $displayUploadProgress;

    /**
     * If specified, the component will fill out the "accept" property depending on
     * which type is requested.
     *
     * @var string
     */
    public $type;

    protected ?bool $canShowUploadProgress = null;

    public function __construct(
        string $name = null,
        string $id = null,
        string $label = 'Select File',
        bool $multiple = false,
        string $type = null,
        bool $displayUploadProgress = true,
        bool $showErrors = true
    )
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->multiple = $multiple;
        $this->label = $label;
        $this->displayUploadProgress = $displayUploadProgress;
        $this->showErrors = $showErrors;
        $this->type = $type;
    }

    public function canShowUploadProgress($attributes)
    {
        if (! is_null($this->canShowUploadProgress)) {
            return $this->canShowUploadProgress;
        }

        if (! $this->displayUploadProgress) {
            return $this->canShowUploadProgress = false;
        }

        if (! $attributes->whereStartsWith('wire:model')->first()) {
            return $this->canShowUploadProgress = false;
        }

        return $this->canShowUploadProgress = true;
    }

    public function accepts(): ?string
    {
        if (! $this->type) {
            return null;
        }

        $excelTypes = '.csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

        return [
            'audio' => 'audio/*',
            'image' => 'image/*',
            'video' => 'video/*',
            'pdf' => '.pdf',
            'csv' => '.csv',
            'spreadsheet' => $excelTypes,
            'excel' => $excelTypes,
            'text' => 'text/plain',
            'html' => 'text/html',
        ][$this->type] ?? null;
    }
}
