<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Files;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\AcceptsFiles;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasExtraAttributes;
use Rawilk\FormComponents\Concerns\HasModels;

class FilePond extends BladeComponent
{
    use AcceptsFiles;
    use HandlesValidationErrors;
    use HasExtraAttributes;
    use HasModels;

    public function __construct(
        public ?string $name = null,
        public ?string $id = null,
        public bool $multiple = false,
        public ?bool $allowDrop = null,
        public bool $disabled = false,
        public ?int $maxFiles = null,
        public ?array $options = null,
        public ?string $description = null,
        string $type = null,
        bool $showErrors = null,

        // Extra attributes
        string|HtmlString|array|Collection $extraAttributes = null,
    ) {
        $this->id = $id ?? $name;

        $this->type = $type;
        $this->allowDrop = $allowDrop ?? config('form-components.defaults.file_pond.allow_drop', true);
        $this->maxFiles = $maxFiles ?? config('form-components.defaults.file_pond.max_files');
        $this->options = $options ?? config('form-components.defaults.file_pond.options', []);

        $this->showErrors = $showErrors ?? config('form-components.defaults.global.show_errors', true);

        $this->setExtraAttributes($extraAttributes);
    }

    public function options(): array
    {
        $label = array_filter([
            __('form-components::messages.filepond_instructions'),
            $this->description,
        ]);

        if (isset($label[1])) {
            $label[1] = '<span class="fc-filepond--sub-desc">' . $label[1] . '</span>';
        }

        $defaultOptions = [
            'allowMultiple' => $this->multiple,
            'allowDrop' => $this->allowDrop,
            'disabled' => $this->disabled,
            'credits' => false, // Hide powered by footer
        ] + array_filter([
            'maxFiles' => $this->multiple && $this->maxFiles ? $this->maxFiles : null,
            'name' => $this->name,
            'acceptedFileTypes' => $this->accepts(), // Only works if the file type validation plugin is installed
            'labelIdle' => '<span class="fc-filepond--desc">' . implode('<br>', $label) . '</span>',
        ]);

        return array_merge($defaultOptions, $this->options);
    }
}
