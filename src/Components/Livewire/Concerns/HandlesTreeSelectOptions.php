<?php

namespace Rawilk\FormComponents\Components\Livewire\Concerns;

trait HandlesTreeSelectOptions
{
    public string $valueKey = 'id';
    public string $labelKey = 'name';
    public string $childrenKey = 'children';

    public function options($search = null)
    {
        return collect();
    }

    /*
     * This method should be overridden in each tree-select
     * component if disabling specific options is necessary.
     */
    public function optionIsDisabled($option): bool
    {
        return false;
    }

    public function optionLabel($option): null|string
    {
        return $option[$this->labelKey] ?? '';
    }

    public function isSelected($option): bool
    {
        return $this->isCurrentValue((string) $option[$this->valueKey]);
    }

    /*
     * This method should be overridden in each tree-select
     * component to determine if a given option has children.
     */
    public function hasChildren($option): bool
    {
        return false;
    }

    public function optionChildren($option)
    {
        return $option[$this->childrenKey] ?? [];
    }

    /*
     * This method should be overridden in each tree-select
     * component for displaying a label for a selected value.
     * Defaults to the raw value.
     */
    public function labelForValue($value)
    {
        return $value;
    }
}
