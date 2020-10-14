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

    public function __construct(
        bool $multiple = false,
        bool $allowDrop = true,
        string $name = null,
        array $options = [],
        bool $disabled = false,
        int $maxFiles = null,
        string $type = null,
        string $description = null
    ) {
        $this->multiple = $multiple;
        $this->allowDrop = $allowDrop;
        $this->name = $name;
        $this->disabled = $disabled;
        $this->maxFiles = $maxFiles;
        $this->type = $type;
        $this->options = $options;
        $this->description = $description;
    }

    public function options(): array
    {
        $label = array_filter([
            '<span class="filepond--label-action">Upload a file</span> or drag and drop',
            $this->description,
        ]);

        if (isset($label[1])) {
            $label[1] = '<span class="fc-filepond--sub-desc">' . $label[1] . '</span>';
        }

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
}
