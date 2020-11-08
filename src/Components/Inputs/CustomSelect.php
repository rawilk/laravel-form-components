<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Str;

class CustomSelect extends Select
{
    protected static array $assets = ['alpine'];

    /** @var string|null */
    public $placeholder;

    public bool $optional;
    public $valueKey;
    public $textKey;
    public bool $filterable;
    public $clearIcon;
    public bool $disabled;
    public bool $fixedPosition;

    public function __construct(
        string $name = '',
        string $id = null,
        array $options = [],
        $value = null,
        bool $multiple = false,
        string $maxWidth = null,
        bool $showErrors = true,
        $leadingAddon = false,
        $inlineAddon = false,
        $inlineAddonPadding = self::DEFAULT_INLINE_ADDON_PADDING,
        $leadingIcon = false,
        $placeholder = 'Select an option',
        $optional = false,
        string $valueKey = 'value',
        string $textKey = 'text',
        bool $filterable = false,
        string $clearIcon = null,
        bool $disabled = false,
        bool $fixedPosition = false
    ) {
        parent::__construct(
            $name,
            $id,
            $options,
            $value,
            $multiple,
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

        $this->placeholder = $placeholder;
        $this->optional = $optional;
        $this->valueKey = $valueKey;
        $this->textKey = $textKey;
        $this->filterable = $filterable;
        $this->clearIcon = $clearIcon ?? config('form-components.components.custom-select.clear_icon');
        $this->disabled = $disabled;
        $this->fixedPosition = $fixedPosition;
    }

    public function buttonClass(): string
    {
        return implode(' ', array_filter([
            'custom-select--btn',
            $this->getAddonClass(),
            $this->hasErrorsAndShow($this->name) ? 'input-error' : null,
        ]));
    }

    public function selectedKeyToJS()
    {
        if (is_null($this->selectedKey)) {
            return "''";
        }

        return is_string($this->selectedKey)
            ? "'{$this->selectedKey}'"
            : $this->selectedKey;
    }

    public function config(): array
    {
        return [
            'open' => false,
            'selected' => '',
            'optional' => $this->optional,
            'multiple' => $this->multiple,
            'filterable' => $this->filterable,
            'placeholder' => $this->placeholder,
            'selectId' => Str::random(8),
            'fixedPosition' => $this->fixedPosition,
        ];
    }

    public function configToJson(): string
    {
        return '...' . json_encode((object) $this->config()) . ',';
    }
}
