<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Collection;
use Illuminate\Support\Js;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\GetsSelectOptionProperties;

class TreeSelectOption extends BladeComponent
{
    use GetsSelectOptionProperties;

    public bool $hasChildren = false;

    public function __construct(
        public $value = null,
        public $label = null,
        public $selectedLabel = null,
        public bool $disabled = false,
        public int $level = 0,
        public array|Collection|null|string $children = [],
    ) {
        $this->hasChildren = $this->hasChildren();
    }

    public function configToJs(): Js
    {
        return Js::from([
            'optionDisabled' => $this->disabled,
            'optionValue' => $this->value,
            'optionLabel' => $this->label,
            'optionSelectedLabel' => $this->selectedLabel ?? $this->label,
            'hasChildren' => $this->hasChildren,
            'children' => $this->children,
            'level' => $this->level,
        ]);
    }

    private function hasChildren(): bool
    {
        if (! is_array($this->children) && ! $this->children instanceof Collection) {
            return false;
        }

        return $this->children instanceof Collection
            ? $this->children->isNotEmpty()
            : count($this->children) > 0;
    }
}
