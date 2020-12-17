<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

class Form extends BladeComponent
{
    /*
     * Form method spoofing to support PUT, PATCH and DELETE actions.
     * https://laravel.com/docs/master/routing#form-method-spoofing
     */
    public bool $spoofMethod;

    public function __construct(
        public string $action = '',
        public string $method = 'POST',
        public bool $hasFiles = false,
        public bool $spellcheck = false,
    ) {
        $this->method = strtoupper($this->method);
        $this->spoofMethod = in_array($this->method, ['PUT', 'PATCH', 'DELETE'], true);
    }

    public function hasError(string $bag = 'default'): bool
    {
        $errors = View::shared('errors', fn () => request()->session()->get('errors', new ViewErrorBag));

        return $errors->getBag($bag)->isNotEmpty();
    }
}
