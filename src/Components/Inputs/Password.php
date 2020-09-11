<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

class Password extends Input
{
    public bool $showToggle;
    public ?string $showPasswordIcon;
    public ?string $hidePasswordIcon;

    public function __construct(
        string $name = '',
        string $id = null,
        $value = null,
        string $maxWidth = null,
        bool $showErrors = true,
        $leadingAddon = false,
        $inlineAddon = false,
        $inlineAddonPadding = self::DEFAULT_INLINE_ADDON_PADDING,
        $leadingIcon = false,
        bool $showToggle = true,
        string $showPasswordIcon = null,
        string $hidePasswordIcon = null
    )
    {
        parent::__construct(
            $name,
            $id,
            'password',
            $value,
            $maxWidth,
            $showErrors,
            $leadingAddon,
            $inlineAddon,
            $inlineAddonPadding,
            $leadingIcon,
            null,
            null,
            null
        );

        $this->showToggle = $showToggle;
        $this->showPasswordIcon = $showPasswordIcon ?? config('form-components.components.password.show_password_icon');
        $this->hidePasswordIcon = $hidePasswordIcon ?? config('form-components.components.password.hide_password_icon');
    }

    public function inputClass(): string
    {
        $class = parent::inputClass();

        if ($this->showToggle) {
            $class .= ' has-trailing-icon';
        }

        return $class;
    }
}
