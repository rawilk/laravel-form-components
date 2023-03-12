<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasAddons;
use Rawilk\FormComponents\Concerns\HasExtraAttributes;
use Rawilk\FormComponents\Concerns\HasModels;

class CustomSelect extends BladeComponent
{
    use HandlesValidationErrors;
    use HasExtraAttributes;
    use HasModels;
    use HasAddons;

    public function __construct(
        public ?string $name = null,
        public ?string $id = null,
        public mixed $value = null,
        ?bool $showErrors = null,
        public bool $multiple = false,
        public array|Collection $options = [],
        public ?string $size = null,
        public ?string $valueField = null,
        public ?string $labelField = null,
        public ?string $selectedLabelField = null,
        public ?string $disabledField = null,
        public ?string $childrenField = null,
        public ?int $minSelected = null,
        public ?int $maxSelected = null,
        public ?bool $optional = null,
        public ?string $buttonIcon = null,
        public ?bool $searchable = null,
        public ?string $livewireSearch = null,
        public ?bool $clearable = null,
        public ?string $clearIcon = null,
        public ?string $optionSelectedIcon = null,
        public ?string $placeholder = null,
        public ?string $noResultsText = null,
        public ?string $noOptionsText = null,
        public bool $alwaysOpen = false,
        public ?string $containerClass = null,

        // Extra Attributes
        null|string|HtmlString|array|Collection $extraAttributes = null,

        // Addons
        ?string $leadingAddon = null,
        ?string $leadingIcon = null,
        ?string $inlineAddon = null,
        ?string $trailingAddon = null,
    ) {
        $this->id = $id ?? $name;
        $this->value = $name ? old($name, $value) : $value;

        $this->showErrors = $showErrors ?? config('form-components.defaults.global.show_errors', true);

        $this->size = $size ?? config('form-components.defaults.input.size');

        $this->clearable = $clearable ?? config('form-components.defaults.custom_select.clearable', true);
        $this->optional = $optional ?? config('form-components.defaults.custom_select.optional', true);
        $this->minSelected = $minSelected ?? config('form-components.defaults.custom_select.min_selected');
        $this->maxSelected = $maxSelected ?? config('form-components.defaults.custom_select.max_selected');
        $this->buttonIcon = $buttonIcon ?? config('form-components.defaults.custom_select.button_icon');
        $this->searchable = $searchable ?? config('form-components.defaults.custom_select.searchable', true);
        $this->clearIcon = $clearIcon ?? config('form-components.defaults.custom_select.clear_icon');
        $this->optionSelectedIcon = $optionSelectedIcon ?? config('form-components.defaults.custom_select.option_selected_icon');
        $this->placeholder = $placeholder ?? __('form-components::messages.custom_select_placeholder');
        $this->noResultsText = $noResultsText ?? __('form-components::messages.custom_select_no_results');
        $this->noOptionsText = $noOptionsText ?? __('form-components::messages.custom_select_empty_text');

        $this->valueField = $valueField ?? config('form-components.defaults.global.value_field', 'id');
        $this->labelField = $labelField ?? config('form-components.defaults.global.label_field', 'name');
        $this->selectedLabelField = $selectedLabelField ?? config('form-components.defaults.global.selected_label_field') ?? $labelField;
        $this->disabledField = $disabledField ?? config('form-components.defaults.global.disabled_field', 'disabled');
        $this->childrenField = $childrenField ?? config('form-components.defaults.global.children_field', 'children');

        if ($multiple && ! is_iterable($this->value)) {
            $this->value = array_filter([$this->value]);
        }

        $this->setExtraAttributes($extraAttributes);

        // We do not support inline trailing addons or icons for selects.
        $this->leadingAddon = $leadingAddon;
        $this->leadingIcon = $leadingIcon;
        $this->inlineAddon = $inlineAddon;
        $this->trailingAddon = $trailingAddon;

        $this->options = $this->normalizeOptions($options);
    }

    public function buttonClass(): string
    {
        return Arr::toCssClasses([
            'form-input',
            'custom-select__button',
            "custom-select__button--{$this->size}" => $this->size,
            'input-error' => $this->hasErrorsAndShow($this->name),
            config('form-components.defaults.custom_select.input_class'),
        ]);
    }

    public function menuClass(): string
    {
        return Arr::toCssClasses([
            'custom-select__menu',
            config('form-components.defaults.custom_select.menu_class'),
        ]);
    }

    public function containerClass(): string
    {
        return Arr::toCssClasses([
            'relative custom-select',
            config('form-components.defaults.custom_select.container_class'),
            $this->containerClass,
        ]);
    }

    protected function normalizeOptions(array|Collection $options): Collection
    {
        return collect($options)
            ->map(function ($value, $key) {
                // If the key is not numeric, we're going to assume this is the value.
                if (! is_numeric($key)) {
                    return [
                        $this->valueField => $key,
                        $this->labelField => $value,
                    ];
                }

                return $value;
            });
    }

    public function config(): Js
    {
        return Js::from([
            'valueField' => $this->valueField,
            'by' => $this->valueField,
            'labelField' => $this->labelField,
            'selectedLabelField' => $this->selectedLabelField,
            'disabledField' => $this->disabledField,
            'childrenField' => $this->childrenField,
            'optional' => $this->optional,
            'minSelected' => $this->minSelected,
            'maxSelected' => $this->maxSelected,
        ]);
    }
}
