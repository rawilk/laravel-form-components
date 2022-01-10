<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Choice;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasModels;

class SwitchToggle extends BladeComponent
{
    use HandlesValidationErrors;
    use HasModels;

    protected static array $assets = ['alpine'];

    private string $labelId;

    public function __construct(
        public null | string $name = null,
        public null | string $id = null,
        public mixed $value = false,
        public mixed $onValue = true,
        public mixed $offValue = false,
        public null | string $containerClass = null,
        public bool $short = false,
        public null | string $label = null,
        public string $labelPosition = 'right',
        public null | string $offIcon = null, // doesn't apply to short mode
        public null | string $onIcon = null, // doesn't apply to short mode
        public null | string $buttonLabel = 'form-components::messages.switch_button_label',
        public null | string $size = null,
        public bool $disabled = false,
        public $extraAttributes = '',
    ) {
        $this->id = $this->id ?? $this->name;
        $this->labelId = $this->id ?? Str::random(8);
        $this->value = $this->name ? old($this->name, $this->value) : $this->value;
    }

    public function labelId(): string
    {
        return "{$this->labelId}-label";
    }

    public function buttonClass(): string
    {
        return Arr::toCssClasses([
            'switch-toggle',
            $this->toggleSize(),
            'switch-toggle-short' => $this->short,
            'switch-toggle-simple' => ! $this->short,
            'disabled' => $this->disabled,
        ]);
    }

    private function toggleSize(): string
    {
        /*
         * We are defining the size classes explicitly here to prevent
         * tailwind from purging them.
         */
        return match ($this->size ?? '') {
            'sm' => 'switch-toggle--sm',
            'lg' => 'switch-toggle--lg',
            default => 'switch-toggle--base',
        };
    }

    public function getContainerClass(): string
    {
        return Arr::toCssClasses([
            'flex',
            'items-center',
            'justify-between' => $this->labelPosition === 'left',
            $this->containerClass,
        ]);
    }
}
