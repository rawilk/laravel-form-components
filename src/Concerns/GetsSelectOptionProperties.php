<?php

namespace Rawilk\FormComponents\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * @property string $childrenField
 * @property string $disabledField
 * @property string $labelField
 * @property string $selectedLabelField
 * @property string $valueField
 */
trait GetsSelectOptionProperties
{
    public function optionChildren($option, ?string $childrenField = null)
    {
        return $this->optionProperty($option, $childrenField ?? $this->childrenField, []);
    }

    public function optionLabel($option, ?string $labelField = null, ?string $valueField = null)
    {
        return $this->optionProperty(
            $option,
            $labelField ?? $this->labelField,
            $this->optionValue($option, $valueField)
        );
    }

    public function optionSelectedLabel($option, ?string $selectedLabelField = null, ?string $labelField = null, ?string $valueField = null)
    {
        return $this->optionProperty(
            $option,
            $selectedLabelField ?? $this->selectedLabelField,
            $this->optionLabel($option, $labelField, $valueField)
        );
    }

    public function optionValue($option, ?string $valueField = null)
    {
        return $this->optionProperty($option, $valueField ?? $this->valueField);
    }

    public function optionIsDisabled($option, ?string $disabledField = null): bool
    {
        $disabled = $this->optionProperty($option, $disabledField ?? $this->disabledField, false);

        return is_bool($disabled) ? $disabled : false;
    }

    public function optionIsOptGroup($option, ?string $childrenField = null): bool
    {
        // We will consider an option an "opt group" if it has children.
        $children = $this->optionChildren($option, $childrenField);

        return ! empty($children);
    }

    protected function optionProperty($option, $field, $default = null)
    {
        if (is_array($option)) {
            return Arr::get($option, $field, $default);
        }

        if ($option instanceof Model) {
            $value = $option->{$field};

            return is_null($value) ? $default : $value;
        }

        // We have a simple array of options, so just return the "value".
        return $option;
    }
}
