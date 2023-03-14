<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class TimezoneSelect extends Select
{
    public function __construct(
        ?string $name = null,
        ?string $id = null,
        mixed $value = null,
        ?string $containerClass = null,
        ?string $size = null,
        ?bool $showErrors = null,

        // Extra Attributes
        null|HtmlString|array|string|Collection $extraAttributes = null,

        // Addons
        ?string $leadingAddon = null,
        ?string $leadingIcon = null,
        ?string $inlineAddon = null,
        ?string $trailingAddon = null,
        ?string $trailingInlineAddon = null,
        ?string $trailingIcon = null,

        bool $multiple = false,
        array|Collection $options = [],

        // Custom select specific
        public ?bool $useCustomSelect = null,
        public ?int $minSelected = null,
        public ?int $maxSelected = null,
        public ?bool $optional = null,
        public ?bool $searchable = null,
        public ?bool $clearable = null,
        public bool $alwaysOpen = false,
        public ?string $buttonIcon = null,
        public ?string $clearIcon = null,
        public ?string $placeholder = null,
        public ?string $optionSelectedIcon = null,

        // Timezone specific
        null|array|string|bool $only = null,
    ) {
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
            multiple: $multiple,
            options: $options,
        );

        $this->only = $only ?? config('form-components.timezone_subset', false);
        $this->useCustomSelect = $useCustomSelect ?? config('form-components.defaults.timezone_select.use_custom_select', true);

        $this->placeholder = $placeholder ?? __('form-components::messages.timezone_select_placeholder');

        $this->options = app('fc-timezone')->only($this->only)->allMapped();
    }
}
