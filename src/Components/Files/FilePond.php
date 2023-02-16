<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Files;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\AcceptsFiles;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasExtraAttributes;

class FilePond extends BladeComponent
{
    use HandlesValidationErrors;
    use AcceptsFiles;
    use HasExtraAttributes;

    protected static array $assets = ['alpine', 'filepond'];

    public function __construct(
        public bool $multiple = false,
        public bool $allowDrop = true,
        public ?string $name = null,
        public array $options = [],
        public bool $disabled = false,
        public ?int $maxFiles = null,
        ?string $type = null,
        public ?string $description = null,
        /*
         * When set to true, the component will watch for changes to the wire:model
         * and manually remove the files from the FilePond instance if they are
         * still present.
         */
        public bool $watchValue = true,
        bool $showErrors = true,

        // Extra Attributes
        null|string|HtmlString|array|Collection $extraAttributes = null,
    ) {
        $this->type = $type;
        $this->showErrors = $showErrors;

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
