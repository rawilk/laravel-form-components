<?php

namespace Rawilk\FormComponents\Components;

use Illuminate\Support\Arr;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;

use function config;

class FormGroup extends BladeComponent
{
    use HandlesValidationErrors;

    public function __construct(
        public ?string $name = null,
        public ?string $inputId = null,
        public null|bool|string $label = null,
        public ?bool $inline = null,
        bool $showErrors = null,
        public ?string $helpText = null,
        public bool $isCheckboxGroup = false,
        public ?bool $marginBottom = null,
        public ?bool $border = null,
        public ?string $hint = null,
        public bool $optional = false,
    ) {
        $this->inputId = $inputId ?? $name;

        $this->showErrors = $showErrors ?? config('form-components.defaults.global.show_errors', true);
        $this->inline = $inline ?? config('form-components.defaults.form_group.inline', false);
        $this->marginBottom = $marginBottom ?? config('form-components.defaults.form_group.margin_bottom', true);
        $this->border = $border ?? config('form-components.defaults.form_group.border', true);

        if ($optional && ! $hint) {
            $this->hint = __(config('form-components.optional_hint_text'));
        }
    }

    public function groupClass(): string
    {
        return Arr::toCssClasses([
            'has-error' => $this->hasErrorsAndShow($this->name),
            config('form-components.defaults.form_group.class'),
            'form-group--inline' => $this->inline,
        ]);
    }
}
