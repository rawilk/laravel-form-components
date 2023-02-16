<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Support;

use Livewire\Component;

/**
 * This class is to facilitate tests that need to use a Livewire component,
 * such as some of the switch-toggle tests.
 */
final class BlankLivewireComponent extends Component
{
    public $template;

    public function render(): string
    {
        return <<<HTML
        <div>
            {$this->template}
        </div>
        HTML;
    }
}
