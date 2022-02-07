<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;
use Rawilk\FormComponents\Components\Livewire\Concerns\HandlesSelectOptions;

abstract class CustomSelect extends Component
{
    use HandlesSelectOptions;

    public null|string $name = null;
    public null|string $selectId = null;
    public $value;
    public bool $multiple = false;
    public int $minSelected = 1;
    public null|int $maxSelected = null;
    public bool $disabled = false;
    public null|string $labelledby = null;
    public bool $searchable = true;
    public bool $closeOnSelect = false;
    public bool $autofocus = false;
    public bool $optional = false;
    public null|string $clearIcon = null;
    public bool|null|string $placeholder = null;
    public bool|null|string $noOptionsText = null;
    public bool|null|string $noResultsText = null;
    public null|bool $showCheckbox = null;
    public $search = '';
    public $extraAttributes = '';
    public bool $showErrors = true;
    public bool $defer = false;

    protected string $view = 'form-components::livewire.custom-select.custom-select';

    public function updatedValue(): void
    {
        $this->notifyValueChanged();
    }

    public function updateValue($value): void
    {
        $this->value = $value;

        // We need to let our JavaScript know what the new value is.
        $this->dispatchBrowserEvent(
            Str::slug("{$this->name}-value-manually-updated"),
            $this->value,
        );
    }

    protected function getListeners(): array
    {
        return array_merge($this->listeners, [
            "{$this->name}Refresh" => '$refresh',
            "{$this->name}ManuallyUpdated" => 'updateValue',
        ]);
    }

    public function render(): View
    {
        return view($this->view, [
            'options' => $this->options($this->search),
        ]);
    }

    protected function notifyValueChanged(): void
    {
        $this->emit("{$this->name}Updated", $this->value, $this->name);
    }

    public static function livewireRefresh(string $name): string
    {
        return '$wire.emit(\'' . $name . 'Refresh\');';
    }
}
