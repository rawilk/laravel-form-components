<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Support;

use Livewire\Component;

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
