<?php

namespace Rawilk\FormComponents\Components;

use Rawilk\FormComponents\Concerns\HandlesBoundValues;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;

class FormCheckbox extends Component
{
    use HandlesValidationErrors, HandlesBoundValues;

    public string $name;
    public string $label;
    public $value;
    public bool $checked = false;
    public string $description;

    public function __construct(
        string $name = '',
        string $label = '',
        $value = 1,
        string $description = '',
        $bind = null,
        bool $default = false,
        bool $showErrors = true
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->description = $description;
        $this->showErrors = $showErrors;

        if (old($name)) {
            $this->checked = true;
        }

        if (! session()->hasOldInput() && $this->isNotWired()) {
            $boundValue = $this->getBoundValue($bind, $name);

            $this->checked = is_null($boundValue) ? $default : $boundValue;
        }
    }
}
