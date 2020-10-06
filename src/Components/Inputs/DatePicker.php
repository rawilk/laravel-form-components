<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

class DatePicker extends Input
{
    public function __construct(
        string $name = '',
        string $id = null,
        string $type = 'text',
        $value = null,
        string $maxWidth = null,
        bool $showErrors = true,
        $leadingAddon = false,
        $inlineAddon = false,
        $inlineAddonPadding = self::DEFAULT_INLINE_ADDON_PADDING,
        $leadingIcon = false,
        $trailingAddon = false,
        $trailingAddonPadding = self::DEFAULT_TRAILING_ADDON_PADDING,
        $trailingIcon = false
    ) {
        parent::__construct(
            $name,
            $id,
            $type,
            $value,
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
    }
}
