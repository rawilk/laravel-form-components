<?php

namespace Rawilk\FormComponents\Components;

use Illuminate\Support\Str;

class Label extends BladeComponent
{
    /** @var string */
    public $for;

    public function __construct(string $for = '')
    {
        $this->for = $for;
    }

    public function fallback(): string
    {
        return Str::ucfirst(str_replace('_', ' ', $this->for));
    }

    public function hasLabel($slot): bool
    {
        return ! $slot->isEmpty()
            || (bool) $this->fallback();
    }
}
