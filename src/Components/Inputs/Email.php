<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

class Email extends Input
{
    public function render()
    {
        $this->type = 'email';

        return parent::render();
    }

    public static function getName(): string
    {
        return 'inputs.input';
    }
}
