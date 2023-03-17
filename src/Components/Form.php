<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

class Form extends BladeComponent
{
    public string $action;

    public string $method;

    public bool $hasFiles;

    public bool $spellcheck;

    /*
     * Form method spoofing to support PUT, PATCH and DELETE actions.
     * https://laravel.com/docs/master/routing#form-method-spoofing
     */
    public bool $spoofMethod;

    public function __construct(string $action = '', string $method = 'POST', bool $hasFiles = false, bool $spellcheck = false)
    {
        $this->action = $action;
        $this->method = strtoupper($method);
        $this->hasFiles = $hasFiles;
        $this->spellcheck = $spellcheck;

        $this->spoofMethod = in_array($this->method, ['PUT', 'PATCH', 'DELETE'], true);
    }

    public function hasError(string $bag = 'default'): bool
    {
        $errors = View::shared('errors', fn () => request()->session()->get('errors', new ViewErrorBag));

        return $errors->getBag($bag)->isNotEmpty();
    }
}
