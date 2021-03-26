<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

use Closure;
use Rawilk\FormComponents\Components\BladeComponent;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasAddons;

class Input extends BladeComponent
{
    use HandlesValidationErrors, HasAddons;

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

        $this->resolveSvgIcons();
    }

    public function inputClass(): string
    {
        return collect([
            'form-input',
            'form-text',
            $this->getAddonClass(),
            $this->hasErrorsAndShow($this->name) ? 'input-error' : null,
        ])->filter()->implode(' ');
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
