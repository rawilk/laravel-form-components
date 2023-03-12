<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Choice;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasExtraAttributes;
use Rawilk\FormComponents\Concerns\HasModels;

class SwitchToggle extends BladeComponent
{
    use HandlesValidationErrors;
    use HasModels;
    use HasExtraAttributes;

    public function __construct(
        public ?string $name = null,
        public ?string $id = null,
        public mixed $value = false,
        public mixed $onValue = true,
        public mixed $offValue = false,
        public ?string $label = null,
        public ?string $labelLeft = null,
        public ?string $containerClass = null,
        public bool $disabled = false,
        public ?string $size = null,
        public ?string $color = null,
        public ?string $onIcon = null,
        public ?string $offIcon = null,
        public bool $short = false,

        // Extra Attributes
        null|string|HtmlString|array|Collection $extraAttributes = null,
    ) {
        $this->id = $id ?? $name;

        $this->size = $size ?? config('form-components.defaults.switch_toggle.size');
        $this->onIcon = $onIcon ?? config('form-components.defaults.switch_toggle.on_icon');
        $this->offIcon = $offIcon ?? config('form-components.defaults.switch_toggle.off_icon');

        $this->setExtraAttributes($extraAttributes);
    }

    public function switchClass(): string
    {
        return Arr::toCssClasses([
            'switch-toggle peer',
            "switch-toggle--{$this->size}" => $this->size && ! $this->short,
            "switch-toggle--{$this->color}" => $this->color,
            'switch-toggle--short' => $this->short,
            config('form-components.defaults.switch_toggle.input_class'),
            $this->attributes->only('class')->get('class'),
        ]);
    }

    public function containerClass(): string
    {
        return Arr::toCssClasses([
            'switch-toggle-container',
            'cursor-not-allowed' => $this->disabled,
            config('form-components.defaults.switch_toggle.container_class'),
            $this->containerClass,
        ]);
    }
}
