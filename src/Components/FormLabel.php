<?php

namespace Rawilk\FormComponents\Components;

class FormLabel extends Component
{
    public string $label;
    public ?string $for;

    public function __construct(string $label = '', string $for = null)
    {
        $this->label = $label;
        $this->for = $for;
    }
}
