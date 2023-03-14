<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\ComponentSlot;

abstract class BladeComponent extends Component
{
    public function render()
    {
        return view("form-components::components.{$this::getName()}");
    }

    /**
     * This method is derived from livewire/livewire from Component.php.
     */
    public static function getName(): string
    {
        $namespace = collect(explode('.', str_replace(['/', '\\'], '.', 'Rawilk\\FormComponents\\Components')))
            ->map([Str::class, 'kebab'])
            ->implode('.');

        $fullName = collect(explode('.', str_replace(['/', '\\'], '.', static::class)))
            ->map([Str::class, 'kebab'])
            ->implode('.');

        if (str($fullName)->startsWith($namespace)) {
            return (string) str($fullName)->substr(strlen($namespace) + 1);
        }

        return $fullName;
    }

    /**
     * Ensures we always have an instance of ComponentSlot for merging attributes in slots.
     * Useful when the "slot" may not always be provided to the component but we
     * need some default attributes always present.
     */
    public function componentSlot(mixed $slot): ComponentSlot
    {
        return $slot instanceof ComponentSlot
            ? $slot
            : new ComponentSlot;
    }
}
