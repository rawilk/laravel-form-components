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

    public bool $multiple;

    public bool $allowDrop;

    public bool $disabled;

    public array $options;

    /** @var string|null */
    public $name;

    /** @var int|null */
    public $maxFiles;

    /** @var string|null */
    public $description;

    /**
     * When set to true, the component will watch for changes to the wire:model
     * and manually remove the files from the FilePond instance if they are
     * still present.
     */
    public bool $watchValue;

    public function __construct(
        bool $multiple = false,
        bool $allowDrop = true,
        string $name = null,
        array $options = [],
        bool $disabled = false,
        int $maxFiles = null,
        string $type = null,
        string $description = null,
        bool $watchValue = true,
        bool $showErrors = true
    ) {
        $this->multiple = $multiple;
        $this->allowDrop = $allowDrop;
        $this->name = $name;
        $this->disabled = $disabled;
        $this->maxFiles = $maxFiles;
        $this->type = $type;
        $this->options = $options;
        $this->description = $description;
        $this->showErrors = $showErrors;
        $this->watchValue = $watchValue;
    }

    public function options(): array
    {
        $label = array_filter([
            '<span class="filepond--label-action">Upload a file</span> or drag and drop',
            $this->description,
        ]);

        if (isset($label[1])) {
            $label[1] = '<span class="fc-filepond--sub-desc">'.$label[1].'</span>';
        }

        $defaultOptions = [
            'allowMultiple' => $this->multiple,
            'allowDrop' => $this->allowDrop,
            'disabled' => $this->disabled,
        ] + array_filter([
            'maxFiles' => $this->multiple && $this->maxFiles ? $this->maxFiles : null,
            'name' => $this->name,
            'labelIdle' => '<span class="fc-filepond--desc">'.implode('<br>', $label).'</span>',
        ]);

        return array_merge($defaultOptions, $this->options);
    }

    public function jsonOptions(): string
    {
        if (empty($this->options())) {
            return '';
        }

        return '...'.json_encode((object) $this->options()).',';
    }

    public function shouldWatch($attributes): bool
    {
        return $this->watchValue
            && (bool) $attributes->whereStartsWith('wire:model')->first();
    }
}
