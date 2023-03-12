<?php

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Rawilk\FormComponents\Concerns\GetsSelectOptionProperties;
use function config;

class Select extends Input
{
    use GetsSelectOptionProperties;

    public function __construct(
        ?string $name = null,
        ?string $id = null,
        mixed $value = null,
        ?string $containerClass = null,
        ?string $size = null,
        ?bool $showErrors = null,

        // Extra attributes
        null|HtmlString|array|string|Collection $extraAttributes = null,

        // Addons
        ?string $leadingAddon = null,
        ?string $leadingIcon = null,
        ?string $inlineAddon = null,
        ?string $trailingAddon = null,
        ?string $trailingInlineAddon = null,
        ?string $trailingIcon = null,

        // Select specific
        public bool $multiple = false,
        public array|Collection $options = [],
        public ?string $valueField = null,
        public ?string $labelField = null,
        public ?string $disabledField = null,
        public ?string $childrenField = null,
    ) {
        $this->jsonEncodeArrayValues = false;

        parent::__construct(
            name: $name,
            id: $id,
            value: $value,
            containerClass: $containerClass,
            size: $size,
            showErrors: $showErrors,
            extraAttributes: $extraAttributes,
            leadingAddon: $leadingAddon,
            leadingIcon: $leadingIcon,
            inlineAddon: $inlineAddon,
            trailingAddon: $trailingAddon,
            trailingInlineAddon: $trailingInlineAddon,
            trailingIcon: $trailingIcon,
        );

        $this->valueField = $valueField ?? config('form-components.defaults.global.value_field', 'id');
        $this->labelField = $labelField ?? config('form-components.defaults.global.label_field', 'name');
        $this->disabledField = $disabledField ?? config('form-components.defaults.global.disabled_field', 'disabled');
        $this->childrenField = $childrenField ?? config('form-components.defaults.global.children_field', 'children');

        $this->options = collect($options)
            ->map(function ($value, $key) {
                // If the key is not numeric, we're going to assume this is the value.
                if (! is_numeric($key)) {
                    return [
                        $this->valueField => $key,
                        $this->labelField => $value,
                    ];
                }

                return $value;
            })->values();
    }

    /**
     * We are not using a strict comparison so that numeric key values can be shown
     * as "selected" too. e.g. 1 == '1'
     *
     * @see: https://github.com/rawilk/laravel-form-components/issues/11
     */
    public function isSelected($value): bool
    {
        if ($this->value == $value) {
            return true;
        }

        return is_array($this->value) && in_array($value, $this->value, false);
    }

    public function inputClass(): string
    {
        return Arr::toCssClasses([
            'form-text form-select',
            config('form-components.defaults.select.input_class', ''),
            'input-error' => $this->hasErrorsAndShow($this->name),
        ]);
    }
}
