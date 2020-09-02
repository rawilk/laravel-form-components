<?php

namespace Rawilk\FormComponents\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component as BaseComponent;
use Rawilk\FormComponents\Support\FormDataBinder;

abstract class Component extends BaseComponent
{
    /**
     * Returns true if the component is wired to a Livewire component.
     *
     * @return bool
     */
    public function isWired(): bool
    {
        return app(FormDataBinder::class)->isWired();
    }

    /**
     * Determine if the component is not wired to a Livewire component.
     *
     * @return bool
     */
    public function isNotWired(): bool
    {
        return ! $this->isWired();
    }

    public function render()
    {
        $alias = Str::kebab(class_basename($this));

        $config = config("form-components.components.{$alias}");

        return $config['view'];
    }
}
