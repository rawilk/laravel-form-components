<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Closure;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasAddons;

class Input extends BladeComponent
{
    use HandlesValidationErrors;
    use HasAddons;

    /** @var string */
    public const DEFAULT_INLINE_ADDON_PADDING = 'pl-16 sm:pl-14';

    /** @var string */
    public const DEFAULT_TRAILING_ADDON_PADDING = 'pr-12';

    public function __construct(
        public null|string $name = null,
        public null|string $id = null,
        public string $type = 'text',
        public mixed $value = null,
        public null|string $maxWidth = null,
        bool $showErrors = true,
        public null|string $containerClass = null,
        $leadingAddon = false,
        $inlineAddon = false,
        $inlineAddonPadding = self::DEFAULT_INLINE_ADDON_PADDING,
        $leadingIcon = false,
        $trailingAddon = false,
        $trailingAddonPadding = self::DEFAULT_TRAILING_ADDON_PADDING,
        $trailingIcon = false,
        public $extraAttributes = '',
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

        if (is_array($this->value)) {
            $this->value = json_encode($this->value);
        }
    }

    public function inputClass(): string
    {
        return collect([
            'form-input',
            'form-text',
            'flex-1 block w-full px-3 py-2 border-blue-gray-300 placeholder-blue-gray-400 sm:text-sm',
            $this->isPasswordToggleable() ? null : 'focus:border-blue-300 focus:ring-opacity-50 focus:ring-4 focus:ring-blue-400',
            $this->getAddonClass(),
            $this->hasErrorsAndShow($this->name) ? 'input-error' : null,
        ])->filter()->implode(' ');
    }

    /*
     * Should always return false, except on the Password input class when
     * $showToggle is set to true.
     */
    public function isPasswordToggleable(): bool
    {
        return false;
    }

    public function render(bool $returnPathOnly = true): Closure
    {
        return function (array $data) use ($returnPathOnly) {
            $this->setSlotAddonAttributes($data);

            if ($data['attributes']->offsetExists('aria-describedby') && $this->hasErrorsAndShow($this->name)) {
                $data['attributes']->offsetSet('aria-describedby', "{$data['attributes']->get('aria-describedby')} {$this->id}-error");
            }

            return parent::render($returnPathOnly);
        };
    }

    public function getContainerClass(): string
    {
        return collect([
            'form-text-container',
            'flex rounded-sm shadow-sm relative',
            $this->maxWidth,
            $this->containerClass,
        ])->filter()->implode(' ');
    }

    protected function resolveMaxWidth(): void
    {
        if ($this->maxWidth) {
            $this->maxWidth = "max-w-{$this->maxWidth}";
        }
    }
}
