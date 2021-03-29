<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CustomSelect extends Select
{
    protected static array $assets = ['alpine', 'popper'];

    public null|string $placeholder;
    public null|string $emptyText;

    public function __construct(
        public null|string $name = null,
        public null|string $id = null,
        public array|Collection $options = [],
        public mixed $value = null,
        public bool $multiple = false,
        public null|string $maxWidth = null,
        bool $showErrors = true,
        $leadingAddon = false,
        $inlineAddon = false,
        $inlineAddonPadding = self::DEFAULT_INLINE_ADDON_PADDING,
        $leadingIcon = false,
        null|string $placeholder = 'form-components::messages.custom_select_placeholder',
        public bool $optional = false,
        public string $valueField = 'value',
        public string $textField = 'text',
        public string $disabledField = 'disabled',
        public bool $filterable = false,
        public null|string $clearIcon = null,
        public bool $disabled = false,
        public null|string $selectedIcon = null,
        public null|string $uncheckIcon = null,
        public bool $maxOptionsSelected = false,
        public bool|null|string $optionDisplay = false,
        public bool|null|string $buttonDisplay = false,
        public array $wireListeners = [],
        null|string $emptyText = 'form-components::messages.custom_select_empty_text',
        public bool $convertValuesToString = false,
        public null|string $containerClass = null,
        public $extraAttributes = '',
    ) {
        parent::__construct(
            name: $name,
            id: $id,
            options: $options,
            value: $value,
            multiple: $multiple,
            maxWidth: $maxWidth,
            showErrors: $showErrors,
            leadingAddon: $leadingAddon,
            inlineAddon: $inlineAddon,
            inlineAddonPadding: $inlineAddonPadding,
            leadingIcon: $leadingIcon,
            containerClass: $containerClass,
            extraAttributes: $extraAttributes,
        );

        $this->resolveIcons();
        $this->normalizeOptions($convertValuesToString);
        $this->placeholder = __($placeholder);
        $this->emptyText = __($emptyText);
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
        return collect([
            'custom-select__button',
            'cursor-default relative w-full rounded-md border border-blue-gray-300 bg-white pl-3 pr-10 py-2 text-left transition',
            'focus:outline-none focus:ring-4 focus:ring-opacity-50 focus:ring-blue-400',
            'sm:text-sm',
            $this->getAddonClass(),
            $this->hasErrorsAndShow($this->name) ? 'input-error' : null,
            $this->disabled ? 'bg-blue-gray-50 text-blue-gray-500 cursor-not-allowed' : null,
        ])->filter()->implode(' ');
    }

    public function selectedKeyToJS(): mixed
    {
        if (is_null($this->selectedKey)) {
            return "''";
        }

        return is_string($this->selectedKey)
            ? "'{$this->selectedKey}'"
            : $this->selectedKey;
    }

    public function getContainerClass(): string
    {
        return collect([
            'custom-select-container',
            'form-text-container',
            'flex rounded-sm shadow-sm relative',
            $this->maxWidth,
            $this->containerClass,
        ])->filter()->implode(' ');
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
        ];
    }

    public function configToJson(): string
    {
        return '...' . json_encode((object) $this->config()) . ',';
    }

    private function resolveIcons(): void
    {
        $this->clearIcon = $this->clearIcon ?? config('form-components.components.custom-select.clear_icon');
        $this->selectedIcon = $this->selectedIcon ?? config('form-components.components.custom-select.selected_icon');
        $this->uncheckIcon = $this->uncheckIcon ?? config('form-components.components.custom-select.uncheck_icon');
    }
}
