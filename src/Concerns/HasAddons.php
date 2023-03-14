<?php

namespace Rawilk\FormComponents\Concerns;

use Illuminate\Support\Arr;
use Illuminate\View\ComponentSlot;

/**
 * @mixin \Illuminate\View\Component
 */
trait HasAddons
{
    public null|string|ComponentSlot $leadingAddon = null;

    public null|string|ComponentSlot $inlineAddon = null;

    public null|string|ComponentSlot $leadingIcon = null;

    public null|string|ComponentSlot $trailingAddon = null;

    public null|string|ComponentSlot $trailingInlineAddon = null;

    public null|string|ComponentSlot $trailingIcon = null;

    protected function getAddonClass(): string
    {
        return Arr::toCssClasses([
            $this->leadingAddonClass(),
            $this->trailingAddonClass(),
        ]);
    }

    protected function leadingAddonClass(): ?string
    {
        if ($this->hasLeadingAddon()) {
            return 'has-leading-addon';
        }

        if ($this->inlineAddon) {
            return 'has-inline-addon';
        }

        return $this->leadingIcon ? 'has-leading-icon' : null;
    }

    protected function trailingAddonClass(): ?string
    {
        if ($this->trailingAddon) {
            return 'has-trailing-addon';
        }

        if ($this->trailingInlineAddon) {
            return 'has-trailing-inline-addon';
        }

        return $this->hasTrailingIcon() ? 'has-trailing-icon' : null;
    }

    /**
     * When certain props are set via slot instead of a prop
     * (e.g. <x-slot:leading-addon> instead of leading-addon="")
     * we need to set them in the render method as they don't get set in the constructor.
     */
    protected function setSlotAddonAttributes(array $data): void
    {
        $slots = [
            'leadingAddon',
            'inlineAddon',
            'leadingIcon',
            'trailingAddon',
            'trailingInlineAddon',
            'trailingIcon',
        ];

        foreach ($data['__laravel_slots'] ?? [] as $slot => $slotValue) {
            if (in_array($slot, $slots, true)) {
                $this->{$slot} = $slotValue;
            }
        }
    }

    protected function hasTrailingIcon(): bool
    {
        return (bool) $this->trailingIcon;
    }

    protected function hasLeadingAddon(): bool
    {
        return (bool) $this->leadingAddon;
    }
}
