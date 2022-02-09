<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Arr;

class Password extends Input
{
    protected static array $assets = ['alpine'];
    protected bool $ignoreAddons = true;

    public function __construct(
        public null | string $name = null,
        public null | string $id = null,
        public mixed $value = null,
        public null | string $maxWidth = null,
        bool $showErrors = true,
        $leadingAddon = false,
        $inlineAddon = false,
        $inlineAddonPadding = self::DEFAULT_INLINE_ADDON_PADDING,
        $leadingIcon = false,
        public bool $showToggle = true,
        public null | string $showPasswordIcon = null,
        public null | string $hidePasswordIcon = null,
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
            extraAttributes: $extraAttributes,
        );

        $this->showPasswordIcon = $this->showPasswordIcon ?? config('form-components.components.password.show_password_icon');
        $this->hidePasswordIcon = $this->hidePasswordIcon ?? config('form-components.components.password.hide_password_icon');
    }

    public function inputClass(): string
    {
        return Arr::toCssClasses([
            parent::inputClass(),
            'password-toggleable border-r-0 rounded-r-none focus:ring-0 focus:border-slate-300' => $this->showToggle,
            'focus:border-blue-300' => $this->showToggle && ! $this->hasErrorsAndShow($this->name),
        ]);
    }

    public function isPasswordToggleable(): bool
    {
        return $this->showToggle;
    }

    public function containerClass(): string
    {
        $colorClasses = $this->hasErrorsAndShow($this->name)
            ? 'focus-within:ring-red-400 focus-within:border-red-300'
            : 'focus-within:ring-blue-400 focus-within:border-blue-300';

        return Arr::toCssClasses([
            $this->getContainerClass(),
            'group',
            'password-input-container',
            'focus-within:ring-4 focus-within:ring-opacity-50 rounded-lg' => $this->showToggle,
            $colorClasses => $this->showToggle,
        ]);
    }
}
