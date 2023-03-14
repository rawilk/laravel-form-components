<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Rawilk\FormComponents\Components\Livewire\Concerns\HandlesSelectOptions;
use Rawilk\FormComponents\Components\Livewire\Concerns\HasCustomSelectProperties;

abstract class CustomSelect extends Component
{
    use HandlesSelectOptions;
    use HasCustomSelectProperties;

    public mixed $value;

    public $search = '';

    public bool $defer = true;

    protected string $view = 'form-components::livewire.custom-select.custom-select';

    public function updatedValue(): void
    {
        // If defer is active, we will assume you are listening for the input even and manually updating the value
        // with alpine yourself.
        if ($this->defer) {
            return;
        }

        $this->emitUp("{$this->name}Updated", $this->value);
    }

    public function updateValue(mixed $value): void
    {
        $this->value = $value;
    }

    protected function getListeners(): array
    {
        return array_merge($this->listeners, [
            "{$this->name}Refresh" => '$refresh',
            "{$this->name}Updated" => 'updateValue',
        ]);
    }

    public function render(): View
    {
        return view($this->view, [
            'options' => $this->options($this->search),
        ]);
    }
}
