<?php

namespace Rawilk\LaravelFormComponents\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rawilk\LaravelFormComponents\LaravelFormComponents
 */
class LaravelFormComponentsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-form-components';
    }
}
