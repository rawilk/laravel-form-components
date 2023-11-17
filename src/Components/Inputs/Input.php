<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasAddons;
use Rawilk\FormComponents\Concerns\HasExtraAttributes;
use Rawilk\FormComponents\Concerns\HasModels;

class Input extends BladeComponent
{
    use HandlesValidationErrors;
    use HasAddons;
    use HasExtraAttributes;
    use HasModels;

    /**
     * Normally we want arrays to be encoded, but some components don't need that, like Select.
     */
    protected bool $jsonEncodeArrayValues = true;

    public function __construct(
        public ?string $name = null,
        public ?string $id = null,
        public string $type = 'text',
        public mixed $value = null,
        public ?string $containerClass = null,
        public ?string $size = null,
        bool $showErrors = null,

        // Extra Attributes
        string|HtmlString|array|Collection $extraAttributes = null,

        // Addons
        string $leadingAddon = null,
        string $leadingIcon = null,
        string $inlineAddon = null,
        string $trailingAddon = null,
        string $trailingInlineAddon = null,
        string $trailingIcon = null,
    ) {
        $this->id = $this->id ?? $this->name;
        $this->value = $name ? old($name, $value) : $value;
        $this->size = $size ?? config('form-components.defaults.input.size', 'md');

        $this->showErrors = $showErrors ?? config('form-components.defaults.global.show_errors', true);

        if (is_iterable($this->value) && $this->jsonEncodeArrayValues) {
            $this->value = json_encode($this->value);
        }

        $this->setExtraAttributes($extraAttributes);

        $this->leadingAddon = $leadingAddon;
        $this->leadingIcon = $leadingIcon;
        $this->inlineAddon = $inlineAddon;
        $this->trailingAddon = $trailingAddon;
        $this->trailingInlineAddon = $trailingInlineAddon;
        $this->trailingIcon = $trailingIcon;
    }

    public function inputClass(): string
    {
        return Arr::toCssClasses([
            'form-text',
            config('form-components.defaults.input.input_class'),
            'input-error' => $this->hasErrorsAndShow($this->name),
        ]);
    }

    public function containerClass(): string
    {
        return Arr::toCssClasses([
            'form-text-container',
            config('form-components.defaults.input.container_class'),
            "form-input--{$this->size}" => $this->size,
            $this->getAddonClass(),
            $this->containerClass,
        ]);
    }

    public function render()
    {
        return function (array $data) {
            $this->setSlotAddonAttributes($data);

            return "form-components::components.{$this::getName()}";
        };
    }
}
