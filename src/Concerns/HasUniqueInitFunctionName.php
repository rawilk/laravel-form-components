<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Concerns;

use Illuminate\Support\Str;

/**
 * Some components need to have a unique init function name for each instance
 * to prevent config options passed into a slot from overriding each other.
 *
 * @property null|string $id
 * @property null|string $name
 */
trait HasUniqueInitFunctionName
{
    protected ?string $componentId = null;

    abstract protected function initFunctionSuffix(): string;

    public function initFunctionName(): string
    {
        $name = Str::studly($this->id ?? $this->name ?? $this->componentId());

        return "{$name}{$this->initFunctionSuffix()}";
    }

    protected function componentId(): string
    {
        if ($this->componentId) {
            return $this->componentId;
        }

        return $this->componentId = $this->initFunctionSuffix() . Str::random(8);
    }
}
