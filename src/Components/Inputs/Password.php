<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class Password extends Input
{
    public function __construct(
        ?string $name = null,
        ?string $id = null,
        mixed $value = null,
        ?string $containerClass = null,
        ?string $size = null,
        ?bool $showErrors = null,

        // Extra Attributes
        null|HtmlString|array|string|Collection $extraAttributes = null,

        // Addons
        ?string $leadingAddon = null,
        ?string $leadingIcon = null,
        ?string $inlineAddon = null,
        ?string $trailingAddon = null,
        ?string $trailingInlineAddon = null,
        ?string $trailingIcon = null,

        // Password specific
        public ?bool $showToggle = null,
        public ?string $showPasswordIcon = null,
        public ?string $hidePasswordIcon = null,
        public bool $initiallyShowPassword = false,
    ) {
        parent::__construct(
            name: $name,
            id: $id,
            value: $value,
            containerClass: $containerClass,
            size: $size,
            showErrors: $showErrors,
            extraAttributes: $extraAttributes,
            leadingAddon: $leadingAddon,
            leadingIcon: $leadingIcon,
            inlineAddon: $inlineAddon,
            trailingAddon: $trailingAddon,
            trailingInlineAddon: $trailingInlineAddon,
            trailingIcon: $trailingIcon,
        );

        $this->showToggle = $showToggle ?? config('form-components.defaults.password.show_toggle', true);
        $this->showPasswordIcon = $showPasswordIcon ?? config('form-components.defaults.password.show_icon', 'heroicon-m-eye');
        $this->hidePasswordIcon = $hidePasswordIcon ?? config('form-components.defaults.password.hide_icon', 'heroicon-m-eye-slash');
    }

    public function inputClass(): string
    {
        return Arr::toCssClasses([
            parent::inputClass(),
            'password-toggleable' => $this->showToggle,
        ]);
    }

    public function containerClass(): string
    {
        return Arr::toCssClasses([
            parent::containerClass(),
            'password-toggleable-container' => $this->showToggle,
        ]);
    }
}
