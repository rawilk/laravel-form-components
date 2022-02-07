<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Livewire;

abstract class TreeSelect extends CustomSelect
{
    public string $childrenField = 'children';

    protected string $view = 'form-components::livewire.tree-select.tree-select';
}
