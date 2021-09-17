<?php

namespace Rawilk\FormComponents\Concerns;

use Illuminate\Support\Arr;

/**
 * @mixin \Illuminate\View\Component
 */
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
        return Arr::toCssClasses([
            $this->leadingAddonClass(),
            $this->trailingAddonClass(),
        ]);
    }

    protected function leadingAddonClass(): null|string
    {
        if ($this->leadingAddon) {
            return 'has-leading-addon rounded-none rounded-r-md';
        }

        if ($this->inlineAddon) {
            return $this->inlineAddonPadding . ' rounded-md';
        }

        return $this->leadingIcon ? 'has-leading-icon pl-10 rounded-md' : 'rounded-md';
    }

    protected function trailingAddonClass(): null|string
    {
        if (property_exists($this, 'ignoreAddons') && $this->ignoreAddons) {
            return null;
        }

        if ($this->trailingAddon) {
            return $this->trailingAddonPadding;
        }

        return $this->trailingIcon ? 'has-trailing-icon pr-10' : null;
    }

    /**
     * When certain props are set via slot instead of a prop
     * (e.g. <x-slot name="leadingAddon"> instead of leading-addon="")
     * we need to set them in the render method as they don't get set in the constructor.
     *
     * @param array $data
     */
    protected function setSlotAddonAttributes(array $data): void
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
