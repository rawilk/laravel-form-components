<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component as IlluminateComponent;

abstract class BladeComponent extends IlluminateComponent
{
    protected static array $assets = [];

    public static function assets(): array
    {
        return static::$assets;
    }

    public function render(bool $returnPathOnly = false)
    {
        $alias = Str::kebab(class_basename($this));

        $config = config("form-components.components.{$alias}");

        return $returnPathOnly
            ? $config['view']
            : view($config['view']);
    }
}
