<?php

namespace Rawilk\FormComponents\Components;

use Rawilk\FormComponents\Concerns\HandlesValidationErrors;

class FormGroup extends Component
{
    use HandlesValidationErrors;

    public string $name;
    public string $label;
    public bool $inline;
    public string $helpText;
    public bool $border;
    public string $labelFor;
    public bool $isCheckbox;

    public function __construct(
        string $name = '',
        string $label = '',
        bool $inline = false,
        bool $showErrors = true,
        string $helpText = '',
        bool $border = false,
        string $labelFor = null,
        bool $isCheckbox = false
    ) {
        $this->name = $name;
        $this->labelFor = $labelFor ?? $this->name;
        $this->label = $label;
        $this->inline = $inline;
        $this->showErrors = $name && $showErrors;
        $this->helpText = $helpText;
        $this->border = $border;
        $this->isCheckbox = $isCheckbox;
    }

    public function groupClass(): string
    {
        $class = 'form-group';

        if ($this->hasErrorAndShow($this->name)) {
            $class .= ' has-error';
        }

        if ($this->inline) {
            $class .= ' form-group-inline';
        }

        if ($this->inline && $this->border) {
            $class .= ' form-group-inline--border';
        }

        return $class;
    }
}
