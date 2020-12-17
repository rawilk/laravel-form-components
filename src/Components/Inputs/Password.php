<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

class Password extends Input
{
    protected static array $assets = ['alpine'];
    protected bool $ignoreAddons = true;

    public function __construct(
        public null|string $name = null,
        public null|string $id = null,
        public mixed $value = null,
        public null|string $maxWidth = null,
        bool $showErrors = true,
        $leadingAddon = false,
        $inlineAddon = false,
        $inlineAddonPadding = self::DEFAULT_INLINE_ADDON_PADDING,
        $leadingIcon = false,
        public bool $showToggle = true,
        public null|string $showPasswordIcon = null,
        public null|string $hidePasswordIcon = null,
        public null|string $containerClass = null,
    ) {
        parent::__construct(
            name: $name,
            id: $id,
            type: 'password',
            value: $value,
            maxWidth: $maxWidth,
            showErrors: $showErrors,
            containerClass: $containerClass,
            leadingAddon: $leadingAddon,
            inlineAddon: $inlineAddon,
            inlineAddonPadding: $inlineAddonPadding,
            leadingIcon: $leadingIcon,
        );

        $this->showPasswordIcon = $this->showPasswordIcon ?? config('form-components.components.password.show_password_icon');
        $this->hidePasswordIcon = $this->hidePasswordIcon ?? config('form-components.components.password.hide_password_icon');
    }

    public function inputClass(): string
    {
        return collect([
            parent::inputClass(),
            $this->showToggle ? 'password-toggleable has-trailing-icon' : null,
        ])->filter()->implode(' ');
    }

    public function containerClass(): string
    {
        $shadowColor = $this->hasErrorsAndShow($this->name)
            ? 'danger'
            : 'primary';

        return collect([
            $this->getContainerClass(),
            $this->showToggle ? "focus-within:ring-4 focus-within:ring-opacity-50 focus-within:ring-{$shadowColor}-400 focus-within:border-{$shadowColor}-300 rounded-md" : null,
        ])->filter()->implode(' ');
    }
}
