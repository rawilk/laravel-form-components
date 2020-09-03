<?php

namespace Rawilk\FormComponents\Components\Choice;

use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;

class Checkbox extends BladeComponent
{
    use HandlesValidationErrors;

    public string $type = 'checkbox';

    /** @var string */
    public $name;

    /** @var string */
    public $id;

    /** @var string */
    public $label;

    /** @var mixed */
    public $value;

    /** @var string */
    public $description;

    public bool $checked;

    public function __construct(
        string $name = '',
        string $id = null,
        $value = null,
        string $label = null,
        string $description = '',
        bool $checked = false
    )
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->value = $value;
        $this->description = $description;
        $this->label = $label;
        $this->checked = (bool) old($name, $checked);
    }
}
