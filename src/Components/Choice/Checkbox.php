<?php

namespace Rawilk\FormComponents\Components\Choice;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasExtraAttributes;
use Rawilk\FormComponents\Concerns\HasModels;

class Checkbox extends BladeComponent
{
    use HandlesValidationErrors {
        ariaDescribedBy as validationAriaDescribedBy;
    }
    use HasExtraAttributes;
    use HasModels;

    public string $type = 'checkbox';

    public function __construct(
        public ?string $name = null,
        public ?string $id = null,
        public mixed $value = null,
        public ?string $label = null,
        public ?string $description = null,
        public bool $checked = false,
        public ?string $containerClass = null,
        public ?string $size = null,
        public ?bool $inlineDescription = null,
        public ?bool $labelLeft = null,

        // Extra Attributes
        string|HtmlString|array|Collection|null $extraAttributes = null,
    ) {
        $this->id = $id ?? $name;

        if ($name) {
            $this->checked = (bool) old($name, $checked);
        }

        $this->size = $size ?? config('form-components.defaults.choice.size');
        $this->inlineDescription = $this->inlineDescription ?? config('form-components.defaults.choice.inline_description', false);
        $this->labelLeft = $labelLeft ?? config('form-components.defaults.choice.label_left', false);

        $this->setExtraAttributes($extraAttributes);
    }

    public function inputClass(): string
    {
        return Arr::toCssClasses([
            'form-choice',
            $this->type === 'checkbox' ? 'form-checkbox' : 'form-radio',
        ]);
    }

    public function containerClass(?string $inputSize = null): string
    {
        // Input size from parent has priority over individual defined size.
        if ($inputSize) {
            $this->size = $inputSize;
        }

        return Arr::toCssClasses([
            'choice-container',
            'choice-container--label-left' => $this->labelLeft,
            config('form-components.defaults.choice.container_class', ''),
            "form-choice--{$this->size}" => $this->size,
            $this->containerClass,
        ]);
    }

    public function ariaDescribedBy(): ?string
    {
        $describedBy = $this->validationAriaDescribedBy();

        if ($this->description && ! Str::contains($describedBy, "{$this->id}-description")) {
            $describedBy = is_null($describedBy)
                ? "aria-describedby=\"{$this->id}-description\""
                : Str::replaceLast('"', " {$this->id}-description\"", $describedBy);
        }

        return $describedBy;
    }

    public function isDisabled(): bool
    {
        return $this->attributes->offsetExists('disabled')
            && $this->attributes->get('disabled') !== false;
    }

    public static function getName(): string
    {
        return 'choice.checkbox-or-radio';
    }
}
