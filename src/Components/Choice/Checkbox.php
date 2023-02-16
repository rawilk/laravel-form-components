<?php

namespace Rawilk\FormComponents\Components\Choice;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasExtraAttributes;
use Rawilk\FormComponents\Concerns\HasModels;

class Checkbox extends BladeComponent
{
    use HandlesValidationErrors;
    use HasModels;
    use HasExtraAttributes;

    public string $type = 'checkbox';

    public function __construct(
        public ?string $name = null,
        public ?string $id = null,
        public mixed $value = null,
        public ?string $label = null,
        public ?string $description = '',
        public bool $checked = false,

        // Extra Attributes
        null|string|HtmlString|array|Collection $extraAttributes = null,
    ) {
        $this->id = $this->id ?? $this->name;

        if ($this->name) {
            $this->checked = (bool) old($this->name, $this->checked);
        }

        $this->setExtraAttributes($extraAttributes);
    }

    public function render()
    {
        return view('form-components::components.choice.checkbox-or-radio');
    }
}
