<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Illuminate\Support\Arr;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasAddons;
use Rawilk\FormComponents\Concerns\HasModels;

class Input extends BladeComponent
{
    use HandlesValidationErrors;
    use HasAddons;
    use HasModels;

    /*
     * Normally we want arrays to be encoded, but some components don't need that, like CustomSelect.
     */
    protected bool $jsonEncodeArrayValues = true;

    /** @var string */
    public const DEFAULT_INLINE_ADDON_PADDING = 'pl-16 sm:pl-14';

    /** @var string */
    public const DEFAULT_TRAILING_ADDON_PADDING = 'pr-12';

    public function __construct(
        public null | string $name = null,
        public null | string $id = null,
        public string $type = 'text',
        public mixed $value = null,
        public null | string $maxWidth = null,
        bool $showErrors = true,
        public null | string $containerClass = null,
        $leadingAddon = false,
        $inlineAddon = false,
        $inlineAddonPadding = self::DEFAULT_INLINE_ADDON_PADDING,
        $leadingIcon = false,
        $trailingAddon = false,
        $trailingAddonPadding = self::DEFAULT_TRAILING_ADDON_PADDING,
        $trailingIcon = false,
        public $extraAttributes = '',
        public $after = null,
    ) {
        $this->id = $this->id ?? $this->name;
        $this->value = $this->name ? old($this->name, $this->value) : $this->value;
        $this->resolveMaxWidth();

        $this->showErrors = $showErrors;

        $this->leadingAddon = $leadingAddon;
        $this->inlineAddon = $inlineAddon;
        $this->inlineAddonPadding = $inlineAddonPadding;
        $this->leadingIcon = $leadingIcon;

        $this->trailingAddon = $trailingAddon;
        $this->trailingAddonPadding = $trailingAddonPadding;
        $this->trailingIcon = $trailingIcon;

        if (is_array($this->value) && $this->jsonEncodeArrayValues) {
            $this->value = json_encode($this->value);
        }
    }

    public function inputClass(): string
    {
        return Arr::toCssClasses([
            'form-input',
            'form-text',
            'flex-1 block w-full px-3 py-2 border-slate-300 placeholder-slate-400 sm:text-sm',
            'focus:border-blue-300 focus:ring-opacity-50 focus:ring-4 focus:ring-blue-400' => ! $this->isPasswordToggleable(),
            $this->getAddonClass(),
            'input-error' => $this->hasErrorsAndShow($this->name),
        ]);
    }

    /*
     * Should always return false, except on the Password input class when
     * $showToggle is set to true.
     */
    public function isPasswordToggleable(): bool
    {
        return false;
    }

    public function render()
    {
        return function (array $data) {
            $this->setSlotAddonAttributes($data);

            return static::viewName();
        };
    }

    public function getContainerClass(): string
    {
        return Arr::toCssClasses([
            'form-text-container',
            'flex rounded-sm shadow-sm relative',
            $this->maxWidth,
            $this->containerClass,
        ]);
    }

    protected function resolveMaxWidth(): void
    {
        if ($this->maxWidth) {
            $this->maxWidth = "max-w-{$this->maxWidth}";
        }
    }
}
