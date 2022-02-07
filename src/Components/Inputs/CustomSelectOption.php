<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Js;
use Rawilk\FormComponents\Components\BladeComponent;

class CustomSelectOption extends BladeComponent
{
    public function __construct(
        public $value = null,
        public $label = null,
        public $selectedLabel = null,
        public bool $disabled = false,
        public bool $isOptGroup = false,
    ) {
    }

    public function configToJs(): Js
    {
        return Js::from([
            'optionDisabled' => $this->disabled,
            'optionValue' => $this->value,
            'optionLabel' => $this->label,
            'optionSelectedLabel' => $this->selectedLabel ?? $this->label,
            'isOptGroup' => $this->isOptGroup,
        ]);
    }
}
