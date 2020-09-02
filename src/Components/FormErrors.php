<?php

namespace Rawilk\FormComponents\Components;

class FormErrors extends Component
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = str_replace(['[', ']'], ['.', ''], $name);
    }
}
