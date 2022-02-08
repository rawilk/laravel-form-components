<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Js;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\GetsSelectOptionProperties;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasModels;

class CustomSelect extends BladeComponent
{
    use HandlesValidationErrors;
    use HasModels;
    use GetsSelectOptionProperties;

    protected static array $assets = ['alpine', 'popper'];

    public function __construct(
        public null|string $name = null,
        public null|string $id = null,
        public mixed $value = null,
        public $options = [],
        public bool $multiple = false,
        // For multi-selects, the minimum amount of options that must be selected.
        public int $minSelected = 1,
        // For multi-selects, the maximum amount of options that may be selected.
        public null|int $maxSelected = null,
        public bool $disabled = false,
        public null|string $labelledby = null,
        public bool $searchable = true,
        public bool $closeOnSelect = false,
        public bool $autofocus = false,
        public bool $optional = false,
        public null|string $clearIcon = null,
        public bool|null|string $placeholder = null,
        public bool|null|string $noOptionsText = null,
        public bool|null|string $noResultsText = null,
        public null|bool $showCheckbox = null,
        public $initialLabel = null,
        public string $valueField = 'id',
        public string $labelField = 'name',
        public null|string $selectedLabelField = null, // Option key to use for displaying the text for the selected option.
        public string $disabledField = 'disabled',
        public string $isOptGroupField = 'is_opt_group',
        public $extraAttributes = '',
        bool $showErrors = true,

        // When used as a livewire component
        public bool $livewire = false,
        public null|string $livewireSearch = null,
    ) {
        $this->id = $id ?? $name;
        $this->value = $this->name ? old($this->name, $this->value) : $this->value;
        $this->showErrors = $showErrors;
        $this->selectedLabelField = $selectedLabelField ?? $labelField;

        if (is_null($this->showCheckbox)) {
            $this->showCheckbox = $this->multiple;
        }

        if ($this->multiple && ! is_iterable($this->value)) {
            $this->value = array_filter([$this->value]);
        }

        $this->resolveIcons();
        $this->resolveLang();
    }

    public function configToJs(): Js
    {
        return Js::from([
            'name' => (string) $this->name,
            'multiple' => $this->multiple,
            'minSelected' => $this->minSelected,
            'maxSelected' => $this->maxSelected,
            'disabled' => $this->disabled,
            'searchable' => $this->searchable,
            'closeOnSelect' => $this->closeOnSelect,
            'autofocus' => $this->autofocus,
            'placeholder' => $this->placeholder,
            'optional' => $this->optional,
            'initialLabel' => $this->initialLabel,
            'livewireSearch' => $this->livewireSearch,
        ]);
    }

    public function hasLivewire(): bool
    {
        return $this->livewire || $this->livewireSearch !== null || $this->hasWireModel();
    }

    protected function resolveIcons(): void
    {
        $this->clearIcon = $this->clearIcon ?? config('form-components.components.custom-select.clear_icon');
    }

    protected function resolveLang(): void
    {
        if ($this->placeholder !== false) {
            $this->placeholder = $this->placeholder ?? __('form-components::messages.custom_select_filter_placeholder');
        }

        if ($this->noOptionsText !== false) {
            $this->noOptionsText = $this->noOptionsText ?? __('form-components::messages.custom_select_empty_text');
        }

        if ($this->noResultsText !== false) {
            $this->noResultsText = $this->noResultsText ?? __('form-components::messages.custom_select_no_results');
        }
    }
}
