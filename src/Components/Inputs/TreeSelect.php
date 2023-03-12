<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class TreeSelect extends CustomSelect
{
    public function __construct(
        ?string $name = null,
        ?string $id = null,
        mixed $value = null,
        ?bool $showErrors = null,
        bool $multiple = false,
        array|Collection $options = [],
        ?string $size = null,
        ?string $valueField = null,
        ?string $labelField = null,
        ?string $selectedLabelField = null,
        ?string $disabledField = null,
        ?string $childrenField = null,
        ?int $minSelected = null,
        ?int $maxSelected = null,
        ?bool $optional = null,
        ?string $buttonIcon = null,
        ?bool $searchable = null,
        ?string $livewireSearch = null,
        ?bool $clearable = null,
        ?string $clearIcon = null,
        ?string $optionSelectedIcon = null,
        ?string $placeholder = null,
        ?string $noResultsText = null,
        ?string $noOptionsText = null,
        bool $alwaysOpen = false,

        // Extra Attributes
        null|HtmlString|array|string|Collection $extraAttributes = null,

        // Addons
        ?string $leadingAddon = null,
        ?string $leadingIcon = null,
        ?string $inlineAddon = null,
        ?string $trailingAddon = null,

        // Tree select specific
        public ?string $hasChildIcon = null,
    ) {
        parent::__construct(
            name: $name,
            id: $id,
            value: $value,
            showErrors: $showErrors,
            multiple: $multiple,
            options: $options,
            size: $size,
            valueField: $valueField,
            labelField: $labelField,
            selectedLabelField: $selectedLabelField,
            disabledField: $disabledField,
            childrenField: $childrenField,
            minSelected: $minSelected,
            maxSelected: $maxSelected,
            optional: $optional,
            buttonIcon: $buttonIcon,
            searchable: $searchable,
            livewireSearch: $livewireSearch,
            clearable: $clearable,
            clearIcon: $clearIcon,
            optionSelectedIcon: $optionSelectedIcon,
            placeholder: $placeholder,
            noResultsText: $noResultsText,
            noOptionsText: $noOptionsText,
            alwaysOpen: $alwaysOpen,
            extraAttributes: $extraAttributes,
            leadingAddon: $leadingAddon,
            leadingIcon: $leadingIcon,
            inlineAddon: $inlineAddon,
            trailingAddon: $trailingAddon,
        );

        $this->hasChildIcon = $hasChildIcon ?? config('form-components.defaults.tree_select.has_child_icon');
    }
}
