<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

class TimezoneSelect extends Select
{
    public function __construct(
        public ?string $name = null,
        public ?string $id = null,
        public mixed $value = null,
        public bool $multiple = false,
        public ?string $maxWidth = null, // Native only
        bool $showErrors = true,
        $leadingAddon = false, // Native only
        $inlineAddon = false, // Native only
        $inlineAddonPadding = self::DEFAULT_INLINE_ADDON_PADDING, // Native only
        $leadingIcon = false, // Native only
        $trailingAddon = false, // Native only
        $trailingAddonPadding = self::DEFAULT_TRAILING_ADDON_PADDING, // Native only
        $trailingIcon = false, // Native only
        public bool|array|string|null $only = null,
        public bool $useCustomSelect = false,
        public bool $searchable = true,
        public bool $optional = false,
        public bool|null|string $placeholder = null,
        public ?string $containerClass = null, // Native only
        public $extraAttributes = '',
        public $after = null, // Native only
        public int $minSelected = 1,
        public ?int $maxSelected = null,
        public bool $disabled = false,
        public ?string $clearIcon = null,
        public ?bool $showCheckbox = null,
        public bool $autofocus = false,
    ) {
        parent::__construct(
            name: $name,
            id: $id,
            value: $value,
            multiple: $multiple,
            maxWidth: $maxWidth,
            showErrors: $showErrors,
            leadingAddon: $leadingAddon,
            inlineAddon: $inlineAddon,
            inlineAddonPadding: $inlineAddonPadding,
            leadingIcon: $leadingIcon,
            trailingAddon: $trailingAddon,
            trailingAddonPadding: $trailingAddonPadding,
            trailingIcon: $trailingIcon,
            containerClass: $containerClass,
            extraAttributes: $extraAttributes,
        );

        $this->only = is_null($only) ? config('form-components.timezone_subset', false) : $only;

        $this->resolveLang();
    }

    protected function resolveLang(): void
    {
        if ($this->placeholder !== false) {
            $this->placeholder = $this->placeholder ?? __('form-components::messages.timezone_select_placeholder');
        }
    }
}
