<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Choice;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasExtraAttributes;
use Rawilk\FormComponents\Concerns\HasModels;

class SwitchToggle extends BladeComponent
{
    use HandlesValidationErrors;
    use HasModels;
    use HasExtraAttributes;

    protected static array $assets = ['alpine'];

    private string $labelId;

    public function __construct(
        public ?string $name = null,
        public ?string $id = null,
        public mixed $value = false,
        public mixed $onValue = true,
        public mixed $offValue = false,
        public ?string $containerClass = null,
        public bool $short = false,
        public ?string $label = null,
        public string $labelPosition = 'right',
        public ?string $offIcon = null, // doesn't apply to short mode
        public ?string $onIcon = null, // doesn't apply to short mode
        public ?string $buttonLabel = 'form-components::messages.switch_button_label',
        public ?string $size = null,
        public bool $disabled = false,

        // Extra Attributes
        null|string|HtmlString|array|Collection $extraAttributes = null,
    ) {
        $this->id = $this->id ?? $this->name;
        $this->labelId = $this->id ?? Str::random(8);
        $this->value = $this->name ? old($this->name, $this->value) : $this->value;

        $this->setExtraAttributes($extraAttributes);
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
