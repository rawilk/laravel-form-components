<?php

namespace Rawilk\FormComponents\Concerns;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

trait HandlesValidationErrors
{
    public bool $showErrors = true;

    public function hasErrorsAndShow(string $name = null, string $bag = 'default'): bool
    {
        return $this->showErrors
            ? $this->hasError($name, $bag)
            : false;
    }

    public function hasError(string $name = null, string $bag = 'default'): bool
    {
        $errors = View::shared('errors', fn () => request()->session()->get('errors', new ViewErrorBag));

        $name = str_replace(['[', ']'], ['.', ''], $name);

        return $errors->getBag($bag)->has($name);
    }
}
