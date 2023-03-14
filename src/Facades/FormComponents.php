<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string javaScript(array $options = [])
 *
 * @see \Rawilk\FormComponents\FormComponents
 */
class FormComponents extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Rawilk\FormComponents\FormComponents::class;
    }
}
