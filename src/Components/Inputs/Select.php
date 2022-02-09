<?php

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Select extends Input
{
    public mixed $selectedKey;

    /** @var string */
    public const DEFAULT_TRAILING_ADDON_PADDING = 'pr-14';

    public function __construct(
        public null | string $name = null,
        public null | string $id = null,
        public array | Collection $options = [],
        public mixed $value = null,
        public bool $multiple = false,
        public null | string $maxWidth = null,
        bool $showErrors = true,
        $leadingAddon = false,
        $inlineAddon = false,
        $inlineAddonPadding = self::DEFAULT_INLINE_ADDON_PADDING,
        $leadingIcon = false,
        $trailingAddon = false,
        $trailingAddonPadding = self::DEFAULT_TRAILING_ADDON_PADDING,
        $trailingIcon = false,
        public null | string $containerClass = null,
        public $extraAttributes = '',
        public $after = null,
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
            extraAttributes: $extraAttributes,
        );

        $this->selectedKey = $this->name ? old($this->name, $this->value) : $this->value;
    }

    public function isSelected($key): bool
    {
        /*
         * Not using a strict comparison so that numeric key values can be shown
         * as "selected" too. e.g. 1 == '1'
         *
         * See: https://github.com/rawilk/laravel-form-components/issues/11
         */
        if ($this->selectedKey == $key) {
            return true;
        }

        return is_array($this->selectedKey) && in_array($key, $this->selectedKey, false);
    }

    public function inputClass(): string
    {
        return Arr::toCssClasses([
            'form-select',
            'block w-full pl-3 pr-10 py-2 rounded-md border-slate-300 sm:text-sm focus:outline-none focus:border-blue-300 focus:ring-4 focus:ring-opacity-50 focus:ring-blue-400',
            $this->getAddonClass(),
            'input-error' => $this->hasErrorsAndShow($this->name),
        ]);
    }
}
