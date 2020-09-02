<?php

namespace Rawilk\FormComponents\Components;

use Rawilk\FormComponents\Concerns\HandlesDefaultAndOldValue;
use Rawilk\FormComponents\Concerns\HandlesValidationErrors;
use Rawilk\FormComponents\Concerns\HasAddons;

class FormInput extends Component
{
    use HandlesValidationErrors, HandlesDefaultAndOldValue, HasAddons;

    public string $name;
    public string $label;
    public string $type;

    /** @var mixed */
    public $value;

    public function __construct(
        string $name = '',
        string $label = '',
        string $type = 'text',
        $bind = null,
        $default = null,
        $language = null,
        bool $showErrors = true,
        $leadingAddon = false,
        $inlineAddon = false,
        $inlineAddonPadding = 'pl-16 sm:pl-14',
        $leadingIcon = false,
        $trailingAddon = false,
        $trailingAddonPadding = 'pr-12',
        $trailingIcon = false
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->showErrors = $showErrors;

        if ($language) {
            $this->name = "{$name}[{$language}]";
        }

        $this->setValue($name, $bind, $default, $language);

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
        return "form-input form-text {$this->getAddonClass()}";
    }

    public function render()
    {
        return function (array $data) {
            $this->setSlotAttributes($data);

            if ($data['attributes']->offsetExists('aria-describedby')) {
                $id = $data['attributes']->get('id') ?? $this->name;

                $data['attributes']->offsetSet('aria-describedby', "{$data['attributes']->get('aria-describedby')} {$id}-error");
            }

            return parent::render();
        };
    }
}
