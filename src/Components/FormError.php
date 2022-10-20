<?php

namespace Rawilk\FormComponents\Components;

use Illuminate\Support\ViewErrorBag;

class FormError extends BladeComponent
{
    public function __construct(
        public ?string $name = null,
        public ?string $inputId = null,
        public string $bag = 'default',
        public string $tag = 'p',
    ) {
        $this->name = str_replace(['[', ']'], ['.', ''], $this->name);
        $this->inputId = $this->inputId ?? $this->name;
    }

    public function messages(ViewErrorBag $errors): array
    {
        $bag = $errors->getBag($this->bag);

        return $bag->has($this->name) ? $bag->get($this->name) : [];
    }
}
