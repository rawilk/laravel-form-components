<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\RichText;

use Illuminate\Support\Js;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasModels;
use Rawilk\FormComponents\Dto\QuillOptions;

class Quill extends BladeComponent
{
    use HandlesValidationErrors;
    use HasModels;

    protected static array $assets = ['alpine', 'quill'];

    public function __construct(
        public null|string $name = null,
        public null|string $id = null,
        public null|string $value = null,
        bool $showErrors = true,
        public bool $autofocus = false,
        public bool $readonly = false,
        public null|string $placeholder = null,
        public null|QuillOptions $quillOptions = null,
    ) {
        $this->id = $this->id ?? $this->name;
        $this->value = $this->name ? old($this->name, $this->value) : $this->value;
        $this->showErrors = $showErrors;

        if (is_null($this->quillOptions)) {
            $this->quillOptions = QuillOptions::defaults();
        }
    }

    public function options(): Js
    {
        return Js::from([
            'autofocus' => $this->autofocus,
            'theme' => $this->quillOptions->theme,
            'readOnly' => $this->readonly,
            'placeholder' => $this->placeholder,
            'toolbar' => $this->quillOptions->getToolbar(),
            'toolbarHandlers' => count($this->quillOptions->toolbarHandlers) ? $this->quillOptions->toolbarHandlers : null,
        ]);
    }
}
