<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\RichText;

use Illuminate\Support\Arr;
use Illuminate\Support\Js;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasModels;
use Rawilk\FormComponents\Dto\QuillOptions;

class Quill extends BladeComponent
{
    use HandlesValidationErrors;
    use HasModels;

    public function __construct(
        public ?string $name = null,
        public ?string $id = null,
        public ?string $value = null,
        ?bool $showErrors = null,
        public ?bool $autoFocus = null,
        public bool $readonly = false,
        public ?string $placeholder = null,

        // $quillOptions is not type hinted on purpose here.
        public $quillOptions = null,
    ) {
        $this->id = $id ?? $name;

        $this->showErrors = $showErrors ?? config('form-components.defaults.global.show_errors', true);

        $this->autoFocus = $autoFocus ?? config('form-components.defaults.rich-text.quill.auto_focus', false);

        $this->quillOptions = $quillOptions ?? QuillOptions::defaults();
    }

    public function containerClass(): string
    {
        return Arr::toCssClasses([
            'quill-wrapper',
            'has-error' => $this->hasErrorsAndShow($this->name),
        ]);
    }

    public function options(): Js
    {
        return Js::from([
            'autofocus' => $this->autoFocus,
            'theme' => $this->quillOptions->theme,
            'readOnly' => $this->readonly,
            'placeholder' => $this->placeholder,
            'toolbar' => $this->quillOptions->getToolbar(),
        ]);
    }
}
