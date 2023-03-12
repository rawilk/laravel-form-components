<?php

namespace Rawilk\FormComponents\Concerns;

/**
 * @mixin \Illuminate\View\Component
 */
trait HasModels
{
    protected ?bool $hasWireModel = null;

    protected ?bool $hasXModel = null;

    public function hasBoundModel(): bool
    {
        return $this->hasWireModel() || $this->hasXModel();
    }

    public function hasWireModel(): bool
    {
        if ($this->hasWireModel !== null) {
            return $this->hasWireModel;
        }

        return $this->hasWireModel = $this->attributes->hasStartsWith('wire:model');
    }

    public function hasXModel(): bool
    {
        if ($this->hasXModel !== null) {
            return $this->hasXModel;
        }

        return $this->hasXModel = $this->attributes->hasStartsWith('x-model');
    }
}
