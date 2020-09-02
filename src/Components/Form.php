<?php

namespace Rawilk\FormComponents\Components;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

class Form extends Component
{
    public string $method;
    public bool $spellcheck;

    /*
     * Form method spoofing to support PUT, PATCH and DELETE actions.
     * https://laravel.com/docs/master/routing#form-method-spoofing
     */
    public bool $spoofMethod = false;

    public function __construct(string $method = 'POST', bool $spellcheck = false)
    {
        $this->method = strtoupper($method);
        $this->spellcheck = $spellcheck;

        $this->spoofMethod = in_array($this->method, ['PUT', 'PATCH', 'DELETE'], true);
    }

    public function hasError(string $bag = 'default'): bool
    {
        $errors = View::shared('errors', fn () => request()->session()->get('errors', new ViewErrorBag));

        return $errors->getBag($bag)->isNotEmpty();
    }
}
