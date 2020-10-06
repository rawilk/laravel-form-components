<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

class DatePicker extends Input
{
    protected static array $assets = ['alpine', 'flatpickr'];

    public array $options;
    public $toggleIcon;
    public $clearIcon;
    public bool $clearable;
    public string $placeholder;

    /*
     * Convenience options
     */
    public bool $clickOpens;
    public bool $allowInput;
    public bool $enableTime;
    public $format;

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
        $trailingAddon = false,
        $trailingAddonPadding = self::DEFAULT_TRAILING_ADDON_PADDING,
        $trailingIcon = false,
        array $options = [],
        bool $clickOpens = false,
        bool $allowInput = true,
        bool $enableTime = false,
        $format = false,
        bool $clearable = false,
        string $placeholder = 'Y-m-d',
        $toggleIcon = null,
        $clearIcon = null
    ) {
        parent::__construct(
            $name,
            $id,
            'text',
            $value,
            $maxWidth,
            $showErrors,
            $leadingAddon,
            $inlineAddon,
            $inlineAddonPadding,
            $leadingIcon,
            $trailingAddon,
            $trailingAddonPadding,
            $trailingIcon
        );

        $this->options = $options;
        $this->clickOpens = $clickOpens;
        $this->allowInput = $allowInput;
        $this->enableTime = $enableTime;
        $this->format = $format;
        $this->clearable = $clearable;
        $this->placeholder = $placeholder;

        $this->toggleIcon = is_null($toggleIcon) ? config('form-components.components.date-picker.icon') : $toggleIcon;
        $this->clearIcon = is_null($clearIcon) ? config('form-components.components.date-picker.clear_icon') : $clearIcon;

        if ($this->toggleIcon !== false) {
            $this->leadingAddon = true; // for styling...
        }

        if ($this->clearable) {
            $this->trailingIcon = true; // for styling...
        }
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
}
