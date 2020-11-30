<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CustomSelect extends Select
{
    protected static array $assets = ['alpine'];

    /** @var string|null */
    public $placeholder;

    public bool $optional;
    public $valueField;
    public $textField;
    public $disabledField;
    public bool $filterable;
    public $clearIcon;
    public bool $disabled;
    public bool $fixedPosition;
    public $selectedIcon;
    public $uncheckIcon;
    public $maxOptionsSelected;
    public $optionDisplay;
    public $buttonDisplay;
    public string $emptyText;
    public array $wireListeners;

    public function __construct(
        string $name = '',
        string $id = null,
        $options = [],
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
        string $valueField = 'value',
        string $textField = 'text',
        string $disabledField = 'disabled',
        bool $filterable = false,
        string $clearIcon = null,
        bool $disabled = false,
        bool $fixedPosition = false,
        string $selectedIcon = null,
        string $uncheckIcon = null,
        $maxOptionsSelected = false,
        $optionDisplay = false,
        $buttonDisplay = false,
        array $wireListeners = [],
        string $emptyText = 'No options available...',
        bool $convertValuesToString = false
    ) {
        parent::__construct(
            $name,
            $id,
            [],
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

        $this->options = $options;
        $this->placeholder = $placeholder;
        $this->optional = $optional;
        $this->valueField = $valueField;
        $this->textField = $textField;
        $this->disabledField = $disabledField;
        $this->filterable = $filterable;
        $this->clearIcon = $clearIcon ?? config('form-components.components.custom-select.clear_icon');
        $this->disabled = $disabled;
        $this->fixedPosition = $fixedPosition;
        $this->maxOptionsSelected = $maxOptionsSelected;
        $this->optionDisplay = $optionDisplay;
        $this->buttonDisplay = $buttonDisplay;
        $this->wireListeners = $wireListeners;
        $this->selectedIcon = $selectedIcon ?? config('form-components.components.custom-select.selected_icon');
        $this->uncheckIcon = $uncheckIcon ?? config('form-components.components.custom-select.uncheck_icon');
        $this->emptyText = $emptyText;

        $this->normalizeOptions($convertValuesToString);
    }

    private function normalizeOptions(bool $convertValuesToString): void
    {
        if ($this->options instanceof Collection) {
            $this->options = $this->options->toArray();
        }

        if ($convertValuesToString) {
            $this->options = array_map(function ($option) {
                $option[$this->valueField] = (string) $option[$this->valueField];

                return $option;
            }, $this->options);
        }
    }

    public function buttonClass(): string
    {
        return implode(' ', array_filter([
            'custom-select__button',
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
            'data' => $this->options,
            'disabled' => $this->disabled,
            'optional' => $this->optional,
            'multiple' => $this->multiple,
            'filterable' => $this->filterable,
            'placeholder' => $this->placeholder,
            'valueField' => $this->valueField,
            'textField' => $this->textField,
            'disabledField' => $this->disabledField,
            'max' => $this->maxOptionsSelected,
            'wireListeners' => $this->wireListeners,
            'selectId' => empty($this->id) ? Str::random(8) : $this->id,
            'fixedPosition' => $this->fixedPosition,
        ];
    }

    public function configToJson(): string
    {
        return '...' . json_encode((object) $this->config()) . ',';
    }
}
