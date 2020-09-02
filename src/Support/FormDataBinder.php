<?php

namespace Rawilk\FormComponents\Support;

use Illuminate\Support\Arr;

class FormDataBinder
{
    private array $bindings = [];

    /*
     * Are we wired to a Livewire component?
     */
    private bool $wire = false;

    public function bind($target): void
    {
        $this->bindings[] = $target;
    }

    /**
     * Get the latest bound target.
     *
     * @return mixed
     */
    public function get()
    {
        return Arr::last($this->bindings);
    }

    /**
     * Remove the latest binding.
     */
    public function pop(): void
    {
        array_pop($this->bindings);
    }

    public function isWired(): bool
    {
        return $this->wire;
    }

    public function wire(): void
    {
        $this->wire = true;
    }

    public function endWire(): void
    {
        $this->wire = false;
    }
}
