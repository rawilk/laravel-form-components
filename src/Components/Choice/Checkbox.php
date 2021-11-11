<?php

namespace Rawilk\FormComponents\Components\Choice;

use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasModels;

class Checkbox extends BladeComponent
{
    use HandlesValidationErrors;
    use HasModels;

    public string $type = 'checkbox';

    public function __construct(
        public null | string $name = null,
        public null | string $id = null,
        public mixed $value = null,
        public null | string $label = null,
        public null | string $description = '',
        public bool $checked = false,
        public $extraAttributes = '',
    ) {
        $this->id = $this->id ?? $this->name;

        if ($this->name) {
            $this->checked = (bool) old($this->name, $this->checked);
        }
    }

    public function render()
    {
        return view('form-components::components.choice.checkbox-or-radio');
    }
}
