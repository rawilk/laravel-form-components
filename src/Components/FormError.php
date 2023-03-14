<?php

namespace Rawilk\FormComponents\Components;

use Illuminate\Support\ViewErrorBag;

class FormError extends BladeComponent
{
    public function __construct(
        public ?string $name = null,
        public ?string $inputId = null,
        public string $bag = 'default',
        public ?string $tag = null,
    ) {
        $this->name = str_replace(['[', ']'], ['.', ''], $name);
        $this->inputId = $inputId ?? $this->name;
        $this->tag = $tag ?? config('form-components.defaults.form_error.tag');
    }

    public function messages(ViewErrorBag $errors): array
    {
        $bag = $errors->getBag($this->bag);

        return $bag->has($this->name) ? $bag->get($this->name) : [];
    }
}
