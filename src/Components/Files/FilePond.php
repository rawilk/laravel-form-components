<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Files;

use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\AcceptsFiles;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;

class FilePond extends BladeComponent
{
    use HandlesValidationErrors;
    use AcceptsFiles;

    protected static array $assets = ['alpine', 'filepond'];

    public function __construct(
        public bool $multiple = false,
        public bool $allowDrop = true,
        public null | string $name = null,
        public array $options = [],
        public bool $disabled = false,
        public null | int $maxFiles = null,
        null|string $type = null,
        public null | string $description = null,
        /*
         * When set to true, the component will watch for changes to the wire:model
         * and manually remove the files from the FilePond instance if they are
         * still present.
         */
        public bool $watchValue = true,
        bool $showErrors = true,
        public $extraAttributes = '',
    ) {
        $this->type = $type;
        $this->showErrors = $showErrors;
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

        /** @psalm-suppress InvalidArgument */
        $defaultOptions = [
            'allowMultiple' => $this->multiple,
            'allowDrop' => $this->allowDrop,
            'disabled' => $this->disabled,
        ] + array_filter([
            'maxFiles' => $this->multiple && $this->maxFiles ? $this->maxFiles : null,
            'name' => $this->name,
            'labelIdle' => '<span class="fc-filepond--desc">' . implode('<br>', $label) . '</span>',
        ]);

        return array_merge($defaultOptions, $this->options);
    }

    public function jsonOptions(): string
    {
        if (empty($this->options())) {
            return '';
        }

        return '...' . json_encode((object) $this->options()) . ',';
    }

    public function shouldWatch($attributes): bool
    {
        return $this->watchValue
            && $attributes->hasStartsWith('wire:model');
    }
}
