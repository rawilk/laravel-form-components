<?php

namespace Rawilk\FormComponents\Components;

use Illuminate\Support\Str;

class Label extends BladeComponent
{
    public function __construct(public ?string $for = null)
    {
    }

    public function fallback(): string
    {
        return Str::ucfirst(str_replace('_', ' ', $this->for));
    }

    public function hasLabel($slot): bool
    {
        return ! $slot->isEmpty()
            || $this->fallback();
    }
}
