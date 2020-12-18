<?php

namespace Rawilk\FormComponents\Components\Choice;

use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;

class Checkbox extends BladeComponent
{
    use HandlesValidationErrors;

    public string $type = 'checkbox';

    public function __construct(
        public null|string $name = null,
        public null|string $id = null,
        public mixed $value = null,
        public null|string $label = null,
        public null|string $description = '',
        public bool $checked = false,
    ) {
        $this->id = $this->id ?? $this->name;
        $this->checked = (bool) old($this->name, $this->checked);
    }
}
