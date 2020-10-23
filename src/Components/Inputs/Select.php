<?php

namespace Rawilk\FormComponents\Components\Inputs;

class Select extends Input
{
    /** @var string */
    public const DEFAULT_TRAILING_ADDON_PADDING = 'pr-14';

    public array $options;

    /** @var string */
    public $selectedKey;

    public bool $multiple;

    /** @var string */
    public $maxWidth;

    public function __construct(
        string $name = '',
        string $id = null,
        array $options = [],
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
        $trailingIcon = false
    ) {
        parent::__construct(
            $name,
            $id,
            '',
            null,
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

        $this->options = $options;
        $this->multiple = $multiple;

        $this->selectedKey = old($name, $value);
    }

    public function isSelected($key): bool
    {
        if ($this->selectedKey === $key) {
            return true;
        }

        if (is_array($this->selectedKey) && in_array($key, $this->selectedKey, false)) {
            return true;
        }

        return false;
    }

    public function inputClass(): string
    {
        $class = "form-select {$this->getAddonClass()}";

        if ($this->hasErrorsAndShow($this->name)) {
            $class .= ' input-error';
        }

        return $class;
    }
}
