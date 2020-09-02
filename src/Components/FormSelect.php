<?php

namespace Rawilk\FormComponents\Components;

use Rawilk\FormComponents\Concerns\HandlesBoundValues;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasAddons;

class FormSelect extends Component
{
    use HandlesValidationErrors, HandlesBoundValues, HasAddons;

    public string $name;
    public $options;
    public $selectedKey;
    public bool $multiple;

    public function __construct(
        string $name = '',
        $options = [],
        $bind = null,
        $default = null,
        bool $multiple = false,
        bool $showErrors = true,
        $leadingAddon = false,
        $inlineAddon = false,
        $inlineAddonPadding = 'pl-16 sm:pl-14',
        $leadingIcon = false,
        $trailingAddon = false,
        $trailingAddonPadding = 'pr-14',
        $trailingIcon = false
    ) {
        $this->name = $name;
        $this->options = $options;

        if ($this->isNotWired()) {
            $default = $this->getBoundValue($bind, $name) ?: $default;

            $this->selectedKey = old($name, $default);
        }

        $this->multiple = $multiple;
        $this->showErrors = $showErrors;

        $this->leadingAddon = $leadingAddon;
        $this->inlineAddon = $inlineAddon;
        $this->inlineAddonPadding = $inlineAddonPadding;
        $this->leadingIcon = $leadingIcon;

        $this->trailingAddon = $trailingAddon;
        $this->trailingAddonPadding = $trailingAddonPadding;
        $this->trailingIcon = $trailingIcon;
    }

    public function isSelected($key): bool
    {
        if ($this->isWired()) {
            return false;
        }

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
        return "form-select {$this->getAddonClass()}";
    }

    public function render()
    {
        return function (array $data) {
            $this->setSlotAttributes($data);

            return parent::render();
        };
    }
}
