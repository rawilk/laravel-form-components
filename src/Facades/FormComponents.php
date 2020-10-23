<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void addStyle(string $style)
 * @method static void addScript(string $script)
 * @method static string javaScript(array $options = [])
 *
 * @see \Rawilk\FormComponents\FormComponents
 */
class FormComponents extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'form-components';
    }
}
