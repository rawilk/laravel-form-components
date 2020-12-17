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
        public bool $border = false,
        public bool $isCheckboxGroup = false,
        public null|string $labelId = null,
    ) {
        $this->inputId = $this->inputId ?? $this->name;
        $this->showErrors = $showErrors;
    }

    public function groupClass(): string
    {
        return collect([
            'form-group',
            $this->hasErrorsAndShow($this->name) ? 'has-error' : null,
            $this->inline ? 'form-group-inline' : null,
            $this->inline && $this->border ? 'form-group-inline--border' : null,
        ])->filter()->implode(' ');
    }
}
