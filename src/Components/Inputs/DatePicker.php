<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Rawilk\FormComponents\Concerns\HasUniqueInitFunctionName;

class DatePicker extends Input
{
    use HasUniqueInitFunctionName;

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

        // Date picker specific
        public array $options = [],
        public ?bool $clickOpens = null,
        public ?bool $allowInput = null,
        public ?bool $enableTime = null,
        public ?string $format = null,
        public ?string $toggleIcon = null,
        public ?bool $clearable = null,
        public ?string $clearIcon = null,
        public ?string $placeholder = null,
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

        $this->clickOpens = $clickOpens ?? config('form-components.defaults.date_picker.click_opens', true);
        $this->allowInput = $allowInput ?? config('form-components.defaults.date_picker.allow_input', true);
        $this->enableTime = $enableTime ?? config('form-components.defaults.date_picker.enable_time', false);
        $this->format = $format ?? config('form-components.date_picker.format', null);
        $this->clearable = $clearable ?? config('form-components.defaults.date_picker.clearable', true);
        $this->placeholder = $placeholder ?? __(config('form-components.defaults.date_picker.placeholder'));

        $this->toggleIcon = $toggleIcon ?? config('form-components.defaults.date_picker.toggle_icon');
        $this->clearIcon = $clearIcon ?? config('form-components.defaults.date_picker.clear_icon');
    }

    public function options(): array
    {
        $defaultOptions = [
            'clickOpens' => $this->clickOpens,
            'allowInput' => $this->allowInput,
            'enableTime' => $this->enableTime,
        ];

        if ($this->format) {
            $defaultOptions['dateFormat'] = $this->format;
        }

        return array_merge($defaultOptions, $this->options);
    }

    public function isClearable(): bool
    {
        return $this->clearable && $this->clearIcon;
    }

    protected function hasLeadingAddon(): bool
    {
        return $this->toggleIcon || $this->leadingAddon;
    }

    protected function hasTrailingIcon(): bool
    {
        return $this->isClearable() || $this->trailingIcon;
    }

    protected function initFunctionSuffix(): string
    {
        return 'Flatpickr';
    }
}
