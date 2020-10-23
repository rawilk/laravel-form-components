<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Controllers;

use Rawilk\FormComponents\Controllers\Concerns\CanPretendToBeAFile;

final class FormComponentsJavaScriptAssets
{
    use CanPretendToBeAFile;

    public function source()
    {
        return $this->pretendResponseIsFile(__DIR__ . '/../../dist/form-components.js');
    }

    public function maps()
    {
        return $this->pretendResponseIsFile(__DIR__ . '/../../dist/form-components.js.map');
    }
}
