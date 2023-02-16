<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class TreeSelect extends CustomSelect
{
    public function __construct(
        public ?string $name = null,
        public ?string $id = null,
        public mixed $value = null,
        public $options = [],
        public bool $multiple = false,
        // For multi-selects, the minimum amount of options that must be selected.
        public int $minSelected = 1,
        // For multi-selects, the maximum amount of options that may be selected.
        public ?int $maxSelected = null,
        public bool $disabled = false,
        public ?string $labelledby = null,
        public bool $searchable = true,
        public bool $closeOnSelect = false,
        public bool $autofocus = false,
        public bool $optional = false,
        public ?string $clearIcon = null,
        public bool|null|string $placeholder = null,
        public bool|null|string $noOptionsText = null,
        public bool|null|string $noResultsText = null,
        public null|bool $showCheckbox = null,
        public $initialLabel = null,
        public string $valueField = 'id',
        public string $labelField = 'name',
        public ?string $selectedLabelField = null, // Option key to use for displaying the text for the selected option.
        public string $disabledField = 'disabled',
        public string $childrenField = 'children',
        bool $showErrors = true,

        // Extra Attributes
        null|string|HtmlString|array|Collection $extraAttributes = null,

        // When used as a livewire component
        public bool $livewire = false,
        public ?string $livewireSearch = null,
    ) {
        parent::__construct(
            name: $name,
            id: $id,
            value: $value,
            options: $options,
            multiple: $multiple,
            minSelected: $minSelected,
            maxSelected: $maxSelected,
            disabled: $disabled,
            labelledby: $labelledby,
            searchable: $searchable,
            closeOnSelect: $closeOnSelect,
            autofocus: $autofocus,
            optional: $optional,
            clearIcon: $clearIcon,
            placeholder: $placeholder,
            noOptionsText: $noOptionsText,
            noResultsText: $noResultsText,
            showCheckbox: $showCheckbox,
            initialLabel: $initialLabel,
            valueField: $valueField,
            labelField: $labelField,
            selectedLabelField: $selectedLabelField,
            disabledField: $disabledField,
            extraAttributes: $extraAttributes,
            showErrors: $showErrors,
            livewire: $livewire,
            livewireSearch: $livewireSearch,
        );
    }
}
