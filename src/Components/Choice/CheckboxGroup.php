<?php

namespace Rawilk\FormComponents\Components\Choice;

use Rawilk\FormComponents\Components\BladeComponent;

class CheckboxGroup extends BladeComponent
{
    public function __construct(public bool $stacked = true, public int | string $gridCols = 3)
    {
    }
}
