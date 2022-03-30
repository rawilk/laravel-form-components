@aware([
    'name' => '',
    'multiple' => false,
    'showCheckbox' => false,
    'childrenField' => 'children',
    'valueField' => 'id',
    'labelField' => 'name',
    'selectedLabelField' => 'name',
    'disabledField' => 'disabled',
])

<li wire:key="treeSelect{{ $name }}Option-{{ $value }}"
    x-data="treeSelectOption({{ $configToJs() }})"
    x-bind:data-disabled="optionDisabled ? '1' : '0'"
    x-on:mouseover.stop="focus({ updateParentIndex: true, scroll: false })"
    x-on:mouseout.stop="hasFocus = false"
    x-on:tree-select-{{ \Illuminate\Support\Str::slug($name) }}-option-focused.window="onReceivedFocus"
    role="option"
    @class([
        'tree-select-option',
        'relative group',
        'disabled' => $disabled,
        'has-children' => $hasChildren,
    ])
    x-bind:class="{ 'has-focus': hasFocus, 'selected': optionSelected() }"
    x-bind:aria-selected="optionSelected() ? 'true' : 'false'"
    tabindex="-1"
    id="treeSelect{{ $name }}Option-{{ $value }}"
    data-level="{{ $level }}"
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
                    class="h-4 w-4 text-slate-400 group-hover:text-slate-600 transition-colors"
                    x-bind:class="{ 'rotate-90': expanded }"
                />
            @endif
        </div>

        {{-- label --}}
        <div x-on:click.stop="toggle"
             @class([
                'tree-select-option__label',
                'flex-1 flex',
                'cursor-pointer' => ! $disabled,
             ])
        >
            {{-- checkbox --}}
            @if ($showCheckbox)
                <div class="flex-shrink-0 mr-2" x-on:input.prevent.stop="() => {}">
                    <x-dynamic-component
                        :component="$multiple ? 'checkbox' : 'radio'"
                        x-bind:checked="optionSelected()"
                        name="{{ $name }}"
                        value="{{ $value }}"
                        :id="$name . $value"
                        :disabled="$disabled"
                    />
                </div>
            @endif

            {{-- label --}}
            <div class="flex-1 w-0 truncate">
                @if ($slot->isNotEmpty())
                    <span>{{ $slot }}</span>
                @else
                    <span>{{ $label }}</span>
                @endif
            </div>
        </div>
    </div>

    @if ($hasChildren)
        <div class="tree-select-option__children"
             x-bind:class="{ 'hidden': ! expanded }"
        >
            <ul>
                @foreach ($children as $child)
                    <x-form-components::inputs.tree-select-option
                        :level="$level + 1"
                        :value="$optionValue($child, $valueField)"
                        :label="$optionLabel($child, $labelField, $valueField)"
                        :selected-label="$optionSelectedLabel($child, $selectedLabelField, $labelField, $valueField)"
                        :disabled="$optionIsDisabled($child, $disabledField)"
                        :children="$optionChildren($child, $childrenField)"
                    />
                @endforeach
            </ul>
        </div>
    @endif
</li>
