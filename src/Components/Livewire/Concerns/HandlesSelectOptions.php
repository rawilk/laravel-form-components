<?php

namespace Rawilk\FormComponents\Components\Livewire\Concerns;

use Rawilk\FormComponents\Concerns\GetsSelectOptionProperties;

trait HandlesSelectOptions
{
    use GetsSelectOptionProperties;

    public ?string $valueField = null;

    public ?string $labelField = null;

    public ?string $selectedLabelField = null;

    public ?string $disabledField = null;

    public ?string $childrenField = null;

    public function handleSearch(?string $search): void
    {
        $this->search = $search;
    }

    public function options(string $search = null)
    {
        return collect();
    }
}
