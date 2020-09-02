<?php

namespace Rawilk\FormComponents\Concerns;

trait HasAddons
{
    public $leadingAddon;
    public $inlineAddon;
    public $inlineAddonPadding;
    public $leadingIcon;

    public $trailingAddon;
    public $trailingAddonPadding;
    public $trailingIcon;

    protected function getAddonClass(): string
    {
        $class = '';

        if ($this->leadingAddon) {
            $class .= ' has-leading-addon';
        } elseif ($this->inlineAddon) {
            $class .= " {$this->inlineAddonPadding}";
        } elseif ($this->leadingIcon) {
            $class .= ' has-leading-icon';
        }

        if ($this->trailingAddon) {
            $class .= " {$this->trailingAddonPadding}";
        } elseif ($this->trailingIcon) {
            $class .= ' has-trailing-icon';
        }

        return $class;
    }

    /**
     * When certain props are set via slot instead of a prop (e.g. <x-slot name="leadingAddon"> instead of leading-addon="")
     * we need to set them in the render method as they don't get set in the constructor.
     *
     * @param array $data
     */
    protected function setSlotAttributes(array $data): void
    {
        if ($data['leadingAddon'] !== false) {
            $this->leadingAddon = $data['leadingAddon'];
        } elseif ($data['inlineAddon'] !== false) {
            $this->inlineAddon = $data['inlineAddon'];
        } elseif ($data['leadingIcon'] !== false) {
            $this->leadingIcon = $data['leadingIcon'];
        }

        if ($data['trailingAddon'] !== false) {
            $this->trailingAddon = $data['trailingAddon'];
        } elseif ($data['trailingIcon'] !== false) {
            $this->trailingIcon = $data['trailingIcon'];
        }
    }
}
