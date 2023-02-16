<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

trait HasExtraAttributes
{
    public ?HtmlString $extraAttributes = null;

    public function setExtraAttributes(null|string|HtmlString|array|Collection $attributes): void
    {
        if (is_null($attributes)) {
            return;
        }

        $this->extraAttributes = is_iterable($attributes)
            ? $this->getExtraAttributesFromIterable($attributes)
            : $this->getExtraAttributesFromString($attributes);
    }

    private function getExtraAttributesFromIterable(array|Collection $attributes): HtmlString
    {
        $attributes = collect($attributes)
            ->filter()
            ->map(fn ($value, $key) => "{$key}=\"{$value}\"")
            ->implode(PHP_EOL);

        return new HtmlString($attributes);
    }

    private function getExtraAttributesFromString(string|HtmlString $attributes): HtmlString
    {
        return $attributes instanceof HtmlString ? $attributes : new HtmlString($attributes);
    }
}
