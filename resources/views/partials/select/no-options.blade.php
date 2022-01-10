<li wire:key="select{{ $name }}{{ $search ? 'NoResults' : 'NoOptions' }}"
    data-level="0"
    class="tree-select-option relative"
>
    <div class="tree-select-option__container">
        <div class="tree-select-option__label flex-1">
            <span>{{ $search ? $noResultsText : $noOptionsText }}</span>
        </div>
    </div>
</li>
