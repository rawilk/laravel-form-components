<?php

namespace Rawilk\FormComponents\Components;

use Illuminate\Support\ViewErrorBag;

class FormError extends BladeComponent
{
    /** @var string */
    public $name;

    /** @var string */
    public $inputId;

    /** @var string */
    public $bag;

    public string $tag;

    public function __construct(string $name = null, string $inputId = null, string $bag = 'default', string $tag = 'p')
    {
        $this->name = str_replace(['[', ']'], ['.', ''], $name);
        $this->inputId = $inputId ?? $name;
        $this->bag = $bag;
        $this->tag = $tag;
    }

    public function messages(ViewErrorBag $errors): array
    {
        $bag = $errors->getBag($this->bag);

        return $bag->has($this->name) ? $bag->get($this->name) : [];
    }
}
