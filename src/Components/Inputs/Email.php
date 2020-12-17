<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Closure;

class Email extends Input
{
    public function render(bool $returnPathOnly = true): Closure
    {
        $this->type = 'email';

        return parent::render($returnPathOnly);
    }
}
