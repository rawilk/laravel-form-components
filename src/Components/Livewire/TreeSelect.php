<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Js;
use Illuminate\Support\Str;
use Livewire\Component;
use Rawilk\FormComponents\Components\Livewire\Concerns\HandlesTreeSelectOptions;

/**
 * @property-read bool $hasValue
 * @property-read bool $hasValueAndCanClear
 */
abstract class TreeSelect extends Component
{
    use HandlesTreeSelectOptions;

    public string $name = '';
    public bool $multiple = false;
    public bool $disabled = false;
    public bool $optional = false;
    public bool $required = false;
    public bool $searchable = true;
    public bool $closeOnSelect = false;
    public bool $autofocus = false;
    public $showCheckbox = null;
    public string $search = '';
    public null|string $clearIcon = null;
    public int $currentOptionIndex = 0;
    public null|string $labelledby = null;
    public string $optionLabelPartial = 'form-components::partials.select.option-label';
    public $noOptionsText;
    public $noResultsText;
    public $value;
    public $placeholder;

    public function getHasValueAndCanClearProperty(): bool
    {
        if (! $this->optional) {
            return false;
        }

        if ($this->disabled) {
            return false;
        }

        return $this->hasValue;
    }

    public function getHasValueProperty(): bool
    {
        return $this->multiple
            ? ! empty($this->value)
            : $this->value !== '' && $this->value !== null;
    }

    /*
     * For multi-selects, the minimum amount of options that must be
     * selected.
     */
    public int $minSelected = 1;

    /*
     * For multi-selects, the maximum amount of options that may
     * be selected.
     */
    public null|int $maxSelected = null;

    protected string $view = 'form-components::livewire.tree-select.tree-select';

    public function selectValue($value): void
    {
        $this->value = $value;

        $this->notifyValueChanged();
    }

    public function updatedValue($value): void
    {
        $this->selectValue($value);
    }

    /**
     * Select an option if not selected, or de-select it
     * if the option can be de-selected.
     *
     * @param null|string $value
     * @return void
     */
    public function toggleOption(null|string $value): void
    {
        if ($this->disabled) {
            return;
        }

        if ($this->multiple) {
            $this->toggleMultiSelectOption($value);

            return;
        }

        $this->toggleSingleSelectOption($value);
    }

    public function clearValue(): void
    {
        if ($this->disabled) {
            return;
        }

        if (! $this->optional) {
            return;
        }

        $this->value = $this->multiple ? [] : null;
        $this->selectValue($this->value);
    }

    public function handleBackspace(): void
    {
        if ($this->disabled) {
            return;
        }

        $this->multiple
            ? $this->toggleMultiSelectOption(end($this->value))
            : $this->toggleSingleSelectOption($this->value);
    }

    public function handleSearch($search): void
    {
        //
    }

    public function configToJs(): Js
    {
        return Js::from([
            'name' => $this->name,
            'disabled' => $this->disabled,
            'searchable' => $this->searchable,
            'closeOnSelect' => $this->closeOnSelect,
            'multiple' => $this->multiple,
            'placeholder' => $this->placeholder,
            'valuePlaceholder' => $this->multiple ? null : $this->labelForValue($this->value),
            'autofocus' => $this->autofocus,
            'optional' => $this->optional,
            'minSelected' => $this->minSelected,
            'maxSelected' => $this->maxSelected,
        ]);
    }

    public function mount(): void
    {
        $this->beforeMount();

        if ($this->multiple && ! is_array($this->value)) {
            $this->value = Arr::wrap($this->value);
        } elseif (! $this->multiple && ! is_string($this->value)) {
            $this->value = (string) $this->value;
        }

        $this->resolveIcons();
        $this->resolveLang();

        if (is_null($this->showCheckbox)) {
            $this->showCheckbox = $this->multiple;
        }

        if ($this->minSelected > 1 || $this->required) {
            $this->optional = false;
        }

        $this->afterMount();
    }

    public function render(): View
    {
        // Used for giving each option an indexed id.
        $this->currentOptionIndex = 0;

        return view($this->view, [
            'options' => $this->options($this->search),
        ]);
    }

    /**
     * Determine if a value is currently selected by the user.
     *
     * @param string $value
     * @return bool
     */
    protected function isCurrentValue(string $value): bool
    {
        if ($this->multiple) {
            return in_array($value, $this->value, false);
        }

        return $value === (string) $this->value;
    }

    protected function notifyValueChanged(): void
    {
        $this->emit("{$this->name}Updated", $this->value, $this->name);

        $this->dispatchBrowserEvent(
            Str::slug("tree-select-{$this->name}-value-changed"),
            [
                'value' => $this->value,
                'label' => $this->multiple ? null : $this->labelForValue($this->value),
            ]
        );
    }

    protected function canSelectAnotherOption(): bool
    {
        if (is_null($this->maxSelected)) {
            return true;
        }

        return count($this->value) < $this->maxSelected;
    }

    public function canDeSelectAnOption(): bool
    {
        if ($this->optional) {
            return true;
        }

        return count($this->value) > $this->minSelected;
    }

    /*
     * We are manually tracking the current option index instead of using
     * the "loop" index to account for child option indexes.
     */
    public function incrementCurrentOptionIndex(): void
    {
        ++$this->currentOptionIndex;
    }

    /*
     * Referencing the variable directly in the blade templates always
     * returns 0, so we'll just return it from the class instead...
     */
    public function getCurrentOptionIndex(): int
    {
        return $this->currentOptionIndex;
    }

    protected function toggleMultiSelectOption($value): void
    {
        $newValue = $this->value;

        if ($this->isCurrentValue((string) $value) && $this->canDeSelectAnOption()) {
            $newValue = array_values(array_filter($newValue, fn ($v) => (string) $v !== (string) $value));
        } elseif (! $this->isCurrentValue((string) $value) && $this->canSelectAnotherOption()) {
            $newValue[] = $value;
        }

        $this->selectValue($newValue);
    }

    protected function toggleSingleSelectOption($value): void
    {
        $newValue = $this->isCurrentValue($value) && $this->optional
            ? null
            : $value;

        if ($newValue !== $this->value) {
            if ($this->closeOnSelect) {
                $this->search = '';
            }

            $this->selectValue($value);
        }
    }

    protected function resolveIcons(): void
    {
        $this->clearIcon = $this->clearIcon ?? config('form-components.components.custom-select.clear_icon');
    }

    protected function resolveLang(): void
    {
        if ($this->placeholder !== false) {
            $this->placeholder = $this->placeholder ?? __('form-components::messages.custom_select_filter_placeholder');
        }

        if ($this->noOptionsText !== false) {
            $this->noOptionsText = $this->noOptionsText ?? __('form-components::messages.custom_select_empty_text');
        }

        if ($this->noResultsText !== false) {
            $this->noResultsText = $this->noResultsText ?? __('form-components::messages.custom_select_no_results');
        }
    }

    /*
     * Lifecycle hooks...
     */

    protected function afterMount(): void
    {
        //
    }

    protected function beforeMount(): void
    {
        //
    }
}
