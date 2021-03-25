<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

class TimezoneSelect extends Select
{
    public null|string $placeholder;

    public function __construct(
        public null|string $name = null,
        public null|string $id = null,
        public mixed $value = null,
        public bool $multiple = false,
        public null|string $maxWidth = null,
        bool $showErrors = true,
        $leadingAddon = false,
        $inlineAddon = false,
        $inlineAddonPadding = self::DEFAULT_INLINE_ADDON_PADDING,
        $leadingIcon = false,
        $trailingAddon = false,
        $trailingAddonPadding = self::DEFAULT_TRAILING_ADDON_PADDING,
        $trailingIcon = false,
        public bool|array|string|null $only = null,
        public bool $useCustomSelect = false,
        public bool $filterable = true,
        public bool $optional = false,
        null|string $placeholder = 'form-components::messages.timezone_select_placeholder',
        public null|string $containerClass = null,
        public $extraAttributes = '',
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
        $this->placeholder = __($placeholder);
    }

    public function optionsForCustomSelect(): array
    {
        return collect(app('fc-timezone')->only($this->only)->all())
            ->map(function (array $timezones, string $region) {
                return [
                    'label' => $region,
                    'options' => collect($timezones)->map(fn (string $text, string $value) => compact('value', 'text'))->values()->toArray(),
                ];
            })
            ->values()
            ->toArray();
    }
}
