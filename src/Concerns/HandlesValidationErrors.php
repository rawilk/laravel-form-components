<?php

namespace Rawilk\FormComponents\Concerns;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

trait HandlesValidationErrors
{
    public bool $showErrors = true;

    public function ariaDescribedBy()
    {
        $hasError = $this->hasErrorsAndShow($this->name);
        if ($this->attributes->offsetExists('aria-describedby') && $hasError) {
            return "aria-describedby=\"{$this->attributes->get('aria-describedby')} {$this->id}-error\"";
        }

        if ($hasError) {
            return "aria-describedby=\"{$this->id}-error\"";
        }

        return '';
    }

    public function hasErrorsAndShow(string $name = null, string $bag = 'default'): bool
    {
        return $this->showErrors
            ? $this->hasError($name, $bag)
            : false;
    }

    public function hasError(string $name = null, string $bag = 'default'): bool
    {
        $errors = View::shared('errors', fn () => request()->session()->get('errors', new ViewErrorBag));

        $name = str_replace(['[', ']'], ['.', ''], (string) $name);

        return $errors->getBag($bag)->has($name);
    }
}
