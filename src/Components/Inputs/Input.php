<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Inputs;

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

    /** @var string */
    public $name;

    /** @var string */
    public $id;

    /** @var string */
    public $type;

    /** @var string|mixed */
    public $value;

    public function __construct(
        string $name = '',
        string $id = null,
        string $type = 'text',
        $value = null,
        bool $showErrors = true,
        $leadingAddon = false,
        $inlineAddon = false,
        $inlineAddonPadding = self::DEFAULT_INLINE_ADDON_PADDING,
        $leadingIcon = false,
        $trailingAddon = false,
        $trailingAddonPadding = self::DEFAULT_TRAILING_ADDON_PADDING,
        $trailingIcon = false
    ) {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->type = $type;
        $this->value = old($name, $value);

        $this->showErrors = $showErrors;

        $this->leadingAddon = $leadingAddon;
        $this->inlineAddon = $inlineAddon;
        $this->inlineAddonPadding = $inlineAddonPadding;
        $this->leadingIcon = $leadingIcon;

        $this->trailingAddon = $trailingAddon;
        $this->trailingAddonPadding = $trailingAddonPadding;
        $this->trailingIcon = $trailingIcon;
    }

    public function inputClass(): string
    {
        $class = "form-input form-text {$this->getAddonClass()}";

        if ($this->hasErrorsAndShow($this->name)) {
            $class .= ' input-error';
        }

        return $class;
    }

    public function render(bool $returnPathOnly = true)
    {
        return function (array $data) use ($returnPathOnly) {
            $this->setSlotAddonAttributes($data);

            if ($data['attributes']->offsetExists('aria-describedby') && $this->hasErrorsAndShow($this->name)) {
                $data['attributes']->offsetSet('aria-describedby', "{$data['attributes']->get('aria-describedby')} {$this->id}-error");
            }

            return parent::render($returnPathOnly);
        };
    }
}
