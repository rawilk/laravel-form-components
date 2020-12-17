<?php

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Collection;

class Select extends Input
{
    public mixed $selectedKey;

    /** @var string */
    public const DEFAULT_TRAILING_ADDON_PADDING = 'pr-14';

    public function __construct(
        public null|string $name = null,
        public null|string $id = null,
        public array|Collection $options = [],
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
        public null|string $containerClass = null,
    ) {
        parent::__construct(
            name: $name,
            id: $id,
            value: $value,
            maxWidth: $maxWidth,
            showErrors: $showErrors,
            containerClass: $containerClass,
            leadingAddon: $leadingAddon,
            inlineAddon: $inlineAddon,
            inlineAddonPadding: $inlineAddonPadding,
            leadingIcon: $leadingIcon,
            trailingAddon: $trailingAddon,
            trailingAddonPadding: $trailingAddonPadding,
            trailingIcon: $trailingIcon,
        );

        $this->selectedKey = old($this->name, $this->value);
    }

    public function isSelected($key): bool
    {
        if ($this->selectedKey === $key) {
            return true;
        }

        return is_array($this->selectedKey) && in_array($key, $this->selectedKey, false);
    }

    public function inputClass(): string
    {
        return collect([
            'form-select',
            $this->getAddonClass(),
            $this->hasErrorsAndShow($this->name) ? 'input-error' : null,
        ])->filter()->implode(' ');
    }
}
