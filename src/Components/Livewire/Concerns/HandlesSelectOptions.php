<?php

namespace Rawilk\FormComponents\Components\Livewire\Concerns;

use Rawilk\FormComponents\Concerns\GetsSelectOptionProperties;

trait HandlesSelectOptions
{
    use GetsSelectOptionProperties;

    public string $valueField = 'id';
    public string $labelField = 'name';
    public null|string $selectedLabelField = null;
    public string $disabledField = 'disabled';
    public string $isOptGroupField = 'is_opt_group';

    public function handleSearch($search): void
    {
        $this->search = $search;
    }

    public function options($search = null)
    {
        return collect();
    }
}
