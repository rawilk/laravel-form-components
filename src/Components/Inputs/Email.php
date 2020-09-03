<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

class Email extends Input
{
    public function render(bool $returnPathOnly = true)
    {
        $this->type = 'email';

        return parent::render($returnPathOnly);
    }
}
