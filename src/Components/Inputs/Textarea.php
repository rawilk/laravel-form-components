<?php

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class Textarea extends Input
{
    public function __construct(
        ?string $name = null,
        ?string $id = null,
        mixed $value = null,
        ?string $containerClass = null,
        ?string $size = null,
        ?bool $showErrors = null,

        // Extra attributes
        null|HtmlString|array|string|Collection $extraAttributes = null,

        // Addons
        ?string $leadingAddon = null,
        ?string $leadingIcon = null,
        ?string $inlineAddon = null,
        ?string $trailingAddon = null,
        ?string $trailingInlineAddon = null,
        ?string $trailingIcon = null,

        // Textarea specific
        public ?bool $autoResize = null,
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

        $this->autoResize = $autoResize ?? config('form-components.defaults.textarea.auto_resize', true);
    }

    public function inputClass(): string
    {
        return Arr::toCssClasses([
            parent::inputClass(),
            'overflow-hidden' => $this->autoResize,
        ]);
    }
}
