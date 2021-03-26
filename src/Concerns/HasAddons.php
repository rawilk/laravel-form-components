<?php

namespace Rawilk\FormComponents\Concerns;

use Illuminate\Support\Str;

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
        return collect([
            $this->leadingAddonClass(),
            $this->trailingAddonClass(),
        ])->filter()->implode(' ');
    }

    protected function leadingAddonClass(): null|string
    {
        if ($this->leadingAddon) {
            return 'has-leading-addon';
        }

        if ($this->inlineAddon) {
            return $this->inlineAddonPadding;
        }

        return $this->leadingIcon ? 'has-leading-icon' : null;
    }

    protected function trailingAddonClass(): null|string
    {
        if (property_exists($this, 'ignoreAddons') && $this->ignoreAddons) {
            return null;
        }

        if ($this->trailingAddon) {
            return $this->trailingAddonPadding;
        }

        return $this->trailingIcon ? 'has-trailing-icon' : null;
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

    protected function setSvgHtml (false|string $path): false|string
    {
        $svgPath = config('form-components.svg_path');

        if (is_null($svgPath)) {
            return false;
        }

        $svgAttributes = config('form-components.svg_attributes', []);
        try {
            $path = 'fci-' . str_replace('/', '-', trim($path));
            $svg = app(\BladeUI\Icons\Factory::class)->svg($path, '', $svgAttributes)->toHtml();
        } catch (\BladeUI\Icons\Exceptions\SvgNotFound $e) {
            $svg = false;
        }

        if (!is_null($svg)) {
            return $svg;
        }

        return false;
    }

    protected function resolveSvgIcons(bool $hasTrailingIcon = true): void
    {
        if ($this->leadingIcon && ! Str::contains($this->leadingIcon, ['<', '>'])) {
            $this->leadingIcon = $this->setSvgHtml($this->leadingIcon);
        }
        if ($hasTrailingIcon && $this->trailingIcon && ! Str::contains($this->trailingIcon, ['<', '>'])) {
            $this->trailingIcon = $this->setSvgHtml($this->trailingIcon);
        }
    }
}
