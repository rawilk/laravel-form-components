<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

class TimezoneSelect extends Select
{
    /** @var string */
    public $selectedKey;

    public bool $multiple;

    /** @var string */
    public $maxWidth;

    public $only;

    // Options that apply if using custom select...
    public bool $useCustomSelect;

    public bool $filterable;

    public bool $optional;

    public $placeholder;

    public bool $fixedPosition;

    public function __construct(
        string $name = '',
        string $id = null,
        $value = null,
        bool $multiple = false,
        string $maxWidth = null,
        bool $showErrors = true,
        $leadingAddon = false,
        $inlineAddon = false,
        $inlineAddonPadding = self::DEFAULT_INLINE_ADDON_PADDING,
        $leadingIcon = false,
        $trailingAddon = false,
        $trailingAddonPadding = self::DEFAULT_TRAILING_ADDON_PADDING,
        $trailingIcon = false,
        $only = null,
        bool $useCustomSelect = false,
        bool $filterable = true,
        bool $optional = false,
        string $placeholder = 'Select a timezone',
        bool $fixedPosition = false
    ) {
        parent::__construct(
            $name,
            $id,
            [],
            $value,
            $multiple,
            $maxWidth,
            $showErrors,
            $leadingAddon,
            $inlineAddon,
            $inlineAddonPadding,
            $leadingIcon,
            $trailingAddon,
            $trailingAddonPadding,
            $trailingIcon
        );

        $this->only = is_null($only) ? config('form-components.timezone_subset', false) : $only;
        $this->useCustomSelect = $useCustomSelect;
        $this->filterable = $filterable;
        $this->optional = $optional;
        $this->placeholder = $placeholder;
        $this->fixedPosition = $fixedPosition;
    }
}
