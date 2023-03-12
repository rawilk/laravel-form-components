<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Components\Livewire\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

trait HasCustomSelectProperties
{
    public ?string $name = null;

    public ?string $selectId = null;

    public ?bool $showErrors = null;

    public bool $multiple = false;

    public ?string $size = null;

    public ?int $minSelected = null;

    public ?int $maxSelected = null;

    public ?bool $optional = null;

    public ?string $buttonIcon = null;

    public ?bool $searchable = true;

    public ?string $livewireSearch = null;

    public ?bool $clearable = null;

    public ?string $clearIcon = null;

    public ?string $optionSelectedIcon = null;

    public ?string $placeholder = null;

    public ?string $noResultsText = null;

    public ?string $noOptionsText = null;

    public bool $alwaysOpen = false;

    public ?string $containerClass = null;

    public null|string|HtmlString|array|Collection $extraAttributes = null;

    public bool $autofocus = false;

    public ?string $leadingAddon = null;

    public ?string $leadingIcon = null;

    public ?string $inlineAddon = null;

    public ?string $trailingAddon = null;
}
