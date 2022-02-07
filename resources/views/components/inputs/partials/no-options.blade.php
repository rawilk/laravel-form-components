@props([
    'type' => 'custom',
    'search' => null,
    'noResultsText' => null,
    'noOptionsText' => null,
    'name' => null,
])

<li wire:key="select{{ $name }}{{ $search ? 'NoResults' : 'NoOptions' }}"
    @if ($type === 'tree') data-level="0" @endif
    {{ $attributes->class(["{$type}-select-option relative select-no-results"]) }}
>
    <div class="{{ $type }}-select-option__container">
        <div class="{{ $type }}-select-option__label flex-1">
            <span>{{ $search ? $noResultsText : $noOptionsText }}</span>
        </div>
    </div>
</li>
