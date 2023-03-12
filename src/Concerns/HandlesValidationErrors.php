<?php

namespace Rawilk\FormComponents\Concerns;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

/**
 * @property null|string $id
 * @property null|string $name
 */
trait HandlesValidationErrors
{
    public bool $showErrors = true;

    public function ariaDescribedBy(): ?string
    {
        $hasError = $this->hasErrorsAndShow($this->name);
        $hasDefinedAriaDescribedBy = $this->attributes->offsetExists('aria-describedby');

        if ($hasError && $hasDefinedAriaDescribedBy) {
            return "aria-describedby=\"{$this->attributes->get('aria-describedby')} {$this->id}-error\"";
        }

        if ($hasError) {
            return "aria-describedby=\"{$this->id}-error\"";
        }

        return $hasDefinedAriaDescribedBy
            ? "aria-describedby=\"{$this->attributes->get('aria-describedby')}\""
            : null;
    }

    public function hasErrorsAndShow(string $name = null, string $bag = 'default'): bool
    {
        return $this->showErrors && $this->hasError($name, $bag);
    }

    public function hasError(string $name = null, string $bag = 'default'): bool
    {
        $errors = View::shared('errors', fn () => session()->get('errors', new ViewErrorBag));

        $name = str_replace(['[', ']'], ['.', ''], (string) $name);

        return $errors->getBag($bag)->has($name);
    }
}
