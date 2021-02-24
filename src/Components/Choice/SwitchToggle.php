<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Choice;

use Illuminate\Support\Str;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;

class SwitchToggle extends BladeComponent
{
    use HandlesValidationErrors;

    protected static array $assets = ['alpine'];

    private string $labelId;

    public function __construct(
        public null|string $name = null,
        public null|string $id = null,
        public mixed $value = false,
        public mixed $onValue = true,
        public mixed $offValue = false,
        public null|string $containerClass = null,
        public bool $short = false,
        public null|string $label = null,
        public string $labelPosition = 'right',
        public null|string $offIcon = null, // doesn't apply to short mode
        public null|string $onIcon = null, // doesn't apply to short mode
        public null|string $buttonLabel = 'form-components::messages.switch_button_label',
        public null|string $size = null,
        public bool $disabled = false,
        public $extraAttributes = '',
    ) {
        $this->id = $this->id ?? $this->name;
        $this->labelId = $this->id ?? Str::random(8);
    }

    public function labelId(): string
    {
        return "{$this->labelId}-label";
    }

    public function buttonClass(): string
    {
        return collect([
            'switch-toggle',
            $this->short ? 'switch-toggle-short' : 'switch-toggle-simple',
            $this->size ? "switch-toggle--{$this->size}" : null,
            $this->disabled ? 'disabled' : null,
        ])->filter()->implode(' ');
    }

    public function getContainerClass(): string
    {
        return collect([
            'flex',
            'items-center',
            $this->labelPosition === 'left' ? 'justify-between' : null,
            $this->containerClass,
        ])->filter()->implode(' ');
    }
}
