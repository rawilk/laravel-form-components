<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Files;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\AcceptsFiles;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasExtraAttributes;
use Rawilk\FormComponents\Concerns\HasModels;

class FileUpload extends BladeComponent
{
    use HandlesValidationErrors;
    use AcceptsFiles;
    use HasModels;
    use HasExtraAttributes;

    protected ?bool $canShowUploadProgress = null;

    public function __construct(
        public ?string $name = null,
        public ?string $id = null,
        public bool $multiple = false,
        ?string $type = null,
        ?bool $showErrors = null,
        public ?bool $displayUploadProgress = null,
        public ?string $label = null,
        public ?string $size = null,
        public ?string $containerClass = null,
        public ?bool $useNativeProgressBar = null,

        // Extra attributes
        null|string|HtmlString|array|Collection $extraAttributes = null,
    ) {
        $this->id = $id ?? $name;
        $this->type = $type;
        $this->showErrors = $showErrors ?? config('form-components.defaults.global.show_errors', true);
        $this->size = $size ?? config('form-components.defaults.input.size', 'md');

        $this->label = $label ?? __('form-components::messages.file_upload_label');

        $this->displayUploadProgress = $displayUploadProgress ?? config('form-components.defaults.file_upload.display_upload_progress', true);
        $this->useNativeProgressBar = $useNativeProgressBar ?? config('form-components.defaults.file_upload.use_native_progress_bar', false);

        $this->setExtraAttributes($extraAttributes);
    }

    public function inputClass(): string
    {
        return Arr::toCssClasses([
            'file-upload__input',
            config('form-components.defaults.file_upload.input_class'),
            "file-upload__input--{$this->size}" => $this->size,
        ]);
    }

    public function containerClass(): string
    {
        return Arr::toCssClasses([
            'file-upload',
            config('form-components.defaults.file_upload.container_class'),
            $this->containerClass,
        ]);
    }

    public function canShowUploadProgress(): bool
    {
        if (! is_null($this->canShowUploadProgress)) {
            return $this->canShowUploadProgress;
        }

        return $this->canShowUploadProgress = match (true) {
            ! $this->displayUploadProgress => false,
            ! $this->hasWireModel() => false,
            default => true,
        };
    }
}
