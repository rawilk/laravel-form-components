<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Js;
use InvalidArgumentException;
use Rawilk\FormComponents\Components\BladeComponent;

class CustomSelectOption extends BladeComponent
{
    protected null|array|Collection $children = null;

    protected ?bool $hasChildren = null;

    public function __construct(
        public mixed $value = null,

        // Only applies if $value is null. If null, we're assuming this component
        // is part of an x-for loop in alpine.
        public string $optionVariable = 'option',

        public int $level = 0,
    ) {
        if (! is_null($value)) {
            throw_unless(
                $value instanceof Model || is_iterable($value),
                new InvalidArgumentException('The value must be an Eloquent model or an array.'),
            );
        }
    }

    public function optionValue(): string|Js
    {
        if (! $this->value) {
            return $this->optionVariable;
        }

        return Js::from($this->value);
    }

    public function optionLabel(string $labelField): mixed
    {
        if ($this->value instanceof Model) {
            return $this->value->{$labelField};
        }

        if (is_iterable($this->value)) {
            return Arr::get($this->value, $labelField);
        }

        return $this->value;
    }

    public function optionIsDisabled(string $disabledField): bool
    {
        $isDisabled = $this->value instanceof Model
            ? $this->value->{$disabledField}
            : Arr::get($this->value, $disabledField, false);

        return is_bool($isDisabled) ? $isDisabled : false;
    }

    public function optionChildren(string $childrenField): array|Collection
    {
        if (! is_null($this->children)) {
            return $this->children;
        }

        $children = $this->value instanceof Model
            ? $this->value->{$childrenField}
            : Arr::get($this->value, $childrenField, []);

        return $this->children = is_iterable($children) ? $children : [];
    }

    public function hasChildren(string $childrenField): bool
    {
        if (! is_null($this->hasChildren)) {
            return $this->hasChildren;
        }

        return $this->hasChildren = ! empty($this->optionChildren($childrenField));
    }
}
