<?php

namespace Rawilk\FormComponents\Components;

use Rawilk\FormComponents\Concerns\HandlesValidationErrors;

class FormGroup extends BladeComponent
{
    use HandlesValidationErrors;

    /** @var string */
    public $name;

    /** @var string */
    public $label;

    /** @var string */
    public $inputId;

    /** @var string */
    public $helpText;

    /** @var null|string */
    public $labelId;

    public bool $inline;
    public bool $border;
    public bool $isCheckboxGroup;

    public function __construct(
        string $name = '',
        string $label = null,
        string $inputId = null,
        bool $inline = false,
        bool $showErrors = true,
        string $helpText = null,
        bool $border = false,
        bool $isCheckboxGroup = false,
        string $labelId = null
    ) {
        $this->name = $name;
        $this->inputId = $inputId ?? $name;
        $this->label = $label;
        $this->inline = $inline;
        $this->showErrors = $showErrors;
        $this->helpText = $helpText;
        $this->border = $border;
        $this->isCheckboxGroup = $isCheckboxGroup;
        $this->labelId = $labelId;
    }

    public function groupClass(): string
    {
        $class = 'form-group';

        if ($this->hasErrorsAndShow($this->name)) {
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
