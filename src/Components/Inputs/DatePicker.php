<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

class DatePicker extends Input
{
    protected static array $assets = ['alpine', 'flatpickr'];

    public null|string $placeholder;

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
        $trailingAddon = false,
        $trailingAddonPadding = self::DEFAULT_TRAILING_ADDON_PADDING,
        $trailingIcon = false,
        public array $options = [], // date picker options
        public bool $clickOpens = false,
        public bool $allowInput = true,
        public bool $enableTime = false,
        public bool | null | string $format = false,
        public bool $clearable = false,
        null|string $placeholder = 'form-components::messages.date_picker_placeholder',
        public bool | null | string  $toggleIcon = null,
        public null | string $clearIcon = null,
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
            trailingAddon: $trailingAddon,
            trailingAddonPadding: $trailingAddonPadding,
            trailingIcon: $trailingIcon,
            extraAttributes: $extraAttributes,
        );

        $this->resolveIcons();
        $this->placeholder = __($placeholder);
    }

    public function options(): array
    {
        $defaultOptions = [
            'clickOpens' => $this->clickOpens,
            'allowInput' => $this->allowInput,
            'enableTime' => $this->enableTime,
        ];

        if ($this->format !== false) {
            $defaultOptions['dateFormat'] = $this->format;
        }

        return array_merge($defaultOptions, $this->options);
    }

    public function jsonOptions(): string
    {
        if (empty($this->options())) {
            return '';
        }

        return '...' . json_encode((object) $this->options()) . ',';
    }

    private function resolveIcons(): void
    {
        /** @psalm-suppress RedundantCondition */
        $this->toggleIcon = is_null($this->toggleIcon) && $this->toggleIcon !== false
            ? config('form-components.components.date-picker.icon')
            : $this->toggleIcon;
        $this->clearIcon = is_null($this->clearIcon) ? config('form-components.components.date-picker.clear_icon') : $this->clearIcon;

        if ($this->toggleIcon !== false) {
            $this->leadingAddon = true; // for styling...
        }

        if ($this->clearable) {
            $this->trailingIcon = true; // for styling...
        }
    }
}
