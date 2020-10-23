<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Database\Eloquent\Model;
use Rawilk\FormComponents\Components\BladeComponent;

class CustomSelectOption extends BladeComponent
{
    public $option;
    public bool $disabled;
    public $selectedIcon;
    public $uncheckIcon;
    public $valueKey;
    public $textKey;
    public bool $isGroup;

    public function __construct(
        $option = null,
        bool $disabled = false,
        string $selectedIcon = null,
        string $uncheckIcon = null,
        bool $isGroup = false,
        string $valueKey = 'value',
        string $textKey = 'text'
    ) {
        $this->disabled = $disabled;
        $this->selectedIcon = $selectedIcon ?? config('form-components.components.custom-select.selected_icon');
        $this->uncheckIcon = $uncheckIcon ?? config('form-components.components.custom-select.uncheck_icon');
        $this->isGroup = $isGroup;
        $this->valueKey = $valueKey;
        $this->textKey = $textKey;
        $this->option = $this->parseOption($option);
    }

    protected function parseOption($option): array
    {
        ['value' => $value, 'text' => $text] = $this->extractDataFromOption($option);

        return [
            'value' => $value,
            'text' => $text,
            'disabled' => $this->disabled,
        ];
    }

    public function optionValue()
    {
        $value = $this->option['value'] ?? null;

        return is_string($value)
            ? "'{$value}'"
            : $value;
    }

    protected function extractDataFromOption($option): array
    {
        if (is_null($option)) {
            return ['value' => '', 'text' => ''];
        }

        if ($option instanceof Model) {
            return [
                'value' => $option->{$this->valueKey},
                'text' => $option->{$this->textKey},
            ];
        }

        if (is_array($option)) {
            return $this->extractDataFromArray($option);
        }

        return [
            'value' => $option,
            'text' => $option,
        ];
    }

    protected function extractDataFromArray($option): array
    {
        if (count($option) === 1) {
            // This is probably a key/value pair
            $key = array_key_first($option);

            return [
                'value' => $key,
                'text' => $option[$key],
            ];
        }

        return [
            'value' => $option[$this->valueKey] ?? '',
            'text' => $option[$this->textKey] ?? '',
        ];
    }

    public function optionClass(): string
    {
        return implode(' ', array_filter([
            $this->isGroup ? 'custom-select--group' : 'custom-select--option',
            $this->disabled ? 'custom-select--option--disabled' : null,
        ]));
    }
}
