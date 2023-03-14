<?php

namespace Rawilk\FormComponents\Components\Choice;

use Illuminate\Support\Arr;
use Rawilk\FormComponents\Components\BladeComponent;

class CheckboxGroup extends BladeComponent
{
    public function __construct(
        public bool $stacked = true,
        public int|string $gridCols = 3,

        // Attributes passed down to children checkbox/radios.
        public ?string $inputSize = null,
    ) {
        $this->inputSize = $inputSize ?? config('form-components.defaults.choice.size');
    }

    public function classes(): string
    {
        return Arr::toCssClasses([
            'form-checkbox-group',
            'form-checkbox-group--inline' => ! $this->stacked,
            'form-checkbox-group--stacked' => $this->stacked,
            "form-checkbox-group--{$this->inputSize}" => $this->inputSize,
        ]);
    }
}
