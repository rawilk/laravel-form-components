<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Files;

use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\AcceptsFiles;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;

class FileUpload extends BladeComponent
{
    use HandlesValidationErrors;
    use AcceptsFiles;

    protected static array $assets = ['alpine'];

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

    protected ?bool $canShowUploadProgress = null;

    public function __construct(
        string $name = null,
        string $id = null,
        string $label = 'Select File',
        bool $multiple = false,
        string $type = null,
        bool $displayUploadProgress = true,
        bool $showErrors = true
    ) {
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
}
