<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Files;

use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\AcceptsFiles;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasModels;

class FileUpload extends BladeComponent
{
    use HandlesValidationErrors;
    use AcceptsFiles;
    use HasModels;

    protected static array $assets = ['alpine'];

    protected null|bool $canShowUploadProgress = null;
    public null|string $label;

    public function __construct(
        public null | string $name = null,
        public null | string $id = null,
        null|string $label = 'form-components::messages.file_upload_label',
        public bool $multiple = false,
        null|string $type = null,
        // Display the file upload progress if using livewire.
        // Only applies if a "wire:model" attribute is set.
        public bool $displayUploadProgress = true,
        bool $showErrors = true,
        public $extraAttributes = '',
    ) {
        $this->id = $this->id ?? $this->name;
        $this->showErrors = $showErrors;
        $this->type = $type;

        $this->label = __($label);
    }

    public function canShowUploadProgress($attributes): bool
    {
        if (! is_null($this->canShowUploadProgress)) {
            return $this->canShowUploadProgress;
        }

        if (! $this->displayUploadProgress) {
            return $this->canShowUploadProgress = false;
        }

        if (! $this->hasWireModel()) {
            return $this->canShowUploadProgress = false;
        }

        return $this->canShowUploadProgress = true;
    }
}
