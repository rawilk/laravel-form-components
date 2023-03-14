@aware([
    'valueField' => 'value',
    'labelField' => 'label',
    'disabledField' => 'disabled',
    'childrenField' => 'children',
    'optionSelectedIcon' => null,
    'hasChildIcon' => false,
])

<li class="tree-select__option-li">
    <div
        x-tree-select:option
        level="{{ $level }}"
        :value="{{ $optionValue() }}"
        {{ $attributes->class('custom-select__option tree-select__option') }}
        style="--level: {{ $level }};"
        :disabled="{{ \Illuminate\Support\Js::from($optionIsDisabled($disabledField)) }}"
        x-bind:class="{
            {{-- $treeSelectOption magic doesn't play nicely with class binding on ajax refresh for some reason, we just use __context for now... --}}
            'custom-select__option--active': __context.isActiveEl($el),
            'custom-select__option--selected': __context.isSelectedEl($el),
            'custom-select__option--disabled': __context.isDisabledEl($el) || (! $treeSelect.canSelectMore && ! __context.isSelectedEl($el)),
        }"
    >
        <div class="truncate flex-1 flex gap-1 items-center">
            @if ($hasChildIcon)
                <template x-if="$treeSelect.hasExpandableOptions">
                    <span class="tree-select__has-child-icon"
                          x-bind:class="{ 'expanded': $treeSelectOption.isExpanded }"
                    >
                        @if ($hasChildren($childrenField))
                            <span x-tree-select:child-toggle>
                                <x-dynamic-component :component="$hasChildIcon" />
                            </span>
                        @endif
                    </span>
                </template>
            @endif

            <span class="truncate">
                @isset($optionTemplate)
                    <span class="truncate" x-data="{ option: {{ \Illuminate\Support\Js::from($value) }} }">{{ $optionTemplate }}</span>
                @else
                    {{ $optionLabel($labelField) }}
                @endisset
            </span>
        </div>

        @if ($optionSelectedIcon)
            {{-- if we don't render this in a conditional that checks if the element is connected to the DOM, Alpine will throw an error from x-show... --}}
            <template x-if="$el.isConnected">
                <span x-show="$treeSelectOption.isSelected"
                      class="shrink-0 custom-select__selected-icon"
                >
                    <x-dynamic-component :component="$optionSelectedIcon" />
                </span>
            </template>
        @endif
    </div>

    @if ($hasChildren($childrenField))
        <ul class="tree-select__children group"
            style="--level: {{ $level }};"
            x-tree-select:children
        >
            @foreach ($optionChildren($childrenField) as $child)
                <x-form-components::inputs.tree-select-option :value="$child" :level="$level + 1" {{ $attributes }}>
                    @isset($optionTemplate)
                        <x-slot:option-template>{{ $optionTemplate }}</x-slot:option-template>
                    @endisset
                </x-form-components::inputs.tree-select-option>
            @endforeach
        </ul>
    @endif
</li>
