<li wire:key="treeSelect{{ $name }}Option-{{ $option[$valueKey] ?? '' }}"
    x-data="treeSelectOption(
        {{ \Illuminate\Support\Js::from([
            'optionDisabled' => $optionDisabled = $this->optionIsDisabled($option),
            'optionValue' => $option[$valueKey],
            'hasChildren' => $hasChildren = $this->hasChildren($option),
            'level' => $level,
            '_optionIndex' => $this->getCurrentOptionIndex(),
         ]) }})"
    data-level="{{ $level }}"
    x-bind:data-disabled="disabled ? '1' : '0'"
    x-on:mouseover.stop="focus({ updateParentIndex: true, scroll: false })"
    x-on:tree-select-{{ Str::slug($name) }}-option-focused.window="onReceivedFocus"
    role="option"
    @class([
        'tree-select-option',
        'relative group',
        'has-children' => $hasChildren,
        'selected' => $selected = $this->isSelected($option),
        'disabled' => $optionDisabled,
    ])
    x-bind:class="{ 'has-focus': hasFocus }"
    aria-selected="{{ $selected ? 'true' : 'false' }}"
    tabindex="-1"
    id="treeSelectOption-{{ $this->getCurrentOptionIndex() }}"
>
    <div class="tree-select-option__container">
        {{-- arrow --}}
        <div
            @if ($hasChildren)
                x-on:click="expanded = ! expanded"
                role="button"
            @endif
            @class([
                'flex-shrink-0 w-7 h-7 flex items-center',
                'cursor-pointer rounded-full group' => $hasChildren,
            ])
        >
            @if ($hasChildren)
                <x-heroicon-s-chevron-right
                    class="h-4 w-4 text-blue-gray-400 group-hover:text-blue-gray-600 transition-colors"
                    x-bind:class="{ 'rotate-90': expanded }"
                />
            @endif
        </div>
        <div
            x-on:click.stop="toggle"
            @class([
                'tree-select-option__label',
                'flex-1 flex',
                'cursor-pointer' => ! $optionDisabled,
            ])
        >
            {{-- checkbox --}}
            @if ($showCheckbox)
                <div class="flex-shrink-0 mr-2">
                    <x-dynamic-component
                        :component="$multiple ? 'checkbox' : 'radio'"
                        :checked="$selected"
                        name="{{ $name }}"
                        value="{{ $option[$valueKey] }}"
                        :id="$name . $option[$valueKey]"
                        :disabled="$optionDisabled"
                    />
                </div>
            @endif

            {{-- label --}}
            <div class="flex-1 w-0 truncate">
                @include($optionLabelPartial)
            </div>
        </div>
    </div>

    @if ($hasChildren)
        <div class="tree-select-option__children"
             x-bind:class="{ 'hidden': ! expanded }"
        >
            <ul>
                @foreach ($this->optionChildren($option) as $child)
                    @php($this->incrementCurrentOptionIndex())
                    @include('form-components::livewire.tree-select.tree-select-option', [
                        'level' => $level + 1,
                        'option' => $child,
                    ])
                @endforeach
            </ul>
        </div>
    @endif
</li>
