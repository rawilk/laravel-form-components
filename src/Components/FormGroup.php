<?php

namespace Rawilk\FormComponents\Components;

use Illuminate\Support\Arr;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;

class FormGroup extends BladeComponent
{
    use HandlesValidationErrors;

    public function __construct(
        public string $name = '',
        public null | string | bool $label = null,
        public null | string $inputId = null,
        public bool $inline = false,
        bool $showErrors = true,
        public null | string $helpText = null,
        public bool $border = true,
        public bool $isCheckboxGroup = false,
        public null | string $labelId = null,
        public bool $marginBottom = true,
        public null | string $hint = null,
        public bool $optional = false,
        public bool $customSelectLabel = false,
    ) {
        $this->inputId = $this->inputId ?? $this->name;
        $this->showErrors = $showErrors;

        if ($this->optional && ! $this->hint) {
            $this->hint = __(config('form-components.optional_hint_text'));
        }
    }

    public function groupClass(): string
    {
        return Arr::toCssClasses([
            'form-group',
            'has-error' => $this->hasErrorsAndShow($this->name),
            'form-group-inline sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start' => $this->inline,
            'form-group-inline--border sm:pt-5 sm:border-t sm:border-slate-200 first:sm:pt-0 first:sm:border-none' => $this->inline && $this->border,
            'mb-5 last:mb-0' => $this->marginBottom,
        ]);
    }
}
