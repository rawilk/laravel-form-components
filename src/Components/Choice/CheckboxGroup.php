<?php

namespace Rawilk\FormComponents\Components\Choice;

use Rawilk\FormComponents\Components\BladeComponent;

class CheckboxGroup extends BladeComponent
{
    public bool $stacked;

    public function __construct(bool $stacked = true)
    {
        $this->stacked = $stacked;
    }
}
