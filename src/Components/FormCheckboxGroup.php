<?php

namespace Rawilk\FormComponents\Components;

class FormCheckboxGroup extends Component
{
    public bool $stacked;

    public function __construct(bool $stacked = true)
    {
        $this->stacked = $stacked;
    }
}
