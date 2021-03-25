<?php

namespace Rawilk\FormComponents\Components;

use Rawilk\FormComponents\Concerns\HandlesValidationErrors;

class FormGroup extends BladeComponent
{
    use HandlesValidationErrors;

    public function __construct(
        public string $name = '',
        public null|string|bool $label = null,
        public null|string $inputId = null,
        public bool $inline = false,
        bool $showErrors = true,
        public null|string $helpText = null,
        public bool $border = true,
        public bool $isCheckboxGroup = false,
        public null|string $labelId = null,
        public bool $marginBottom = true,
    ) {
        $this->inputId = $this->inputId ?? $this->name;
        $this->showErrors = $showErrors;
    }

    public function groupClass(): string
    {
        return collect([
            'form-group',
            $this->hasErrorsAndShow($this->name) ? 'has-error' : null,
            $this->inline ? 'form-group-inline sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start' : null,
            $this->inline && $this->border ? 'form-group-inline--border sm:pt-5 sm:border-t sm:border-blue-gray-200 first:sm:pt-0 first:sm:border-none' : null,
            $this->marginBottom ? 'mb-5 last:mb-0' : null,
        ])->filter()->implode(' ');
    }
}
