@aware([
    'valueField' => 'value',
    'labelField' => 'label',
    'disabledField' => 'disabled',
    'childrenField' => 'children',
    'optionSelectedIcon' => null,
])

@if ($level === 0 && $hasChildren($childrenField))
    <li x-custom-select:option
        is-opt-group
        :value="{{ $optionValue() }}"
        {{ $attributes->class('custom-select__option custom-select__opt-group') }}
    >
        <span class="truncate">
            @isset($optionTemplate)
                <span class="truncate" x-data="{ option: {{ \Illuminate\Support\Js::from($value) }} }">{{ $optionTemplate }}</span>
            @else
                {{ $optionLabel($labelField) }}
            @endisset
        </span>
    </li>

    @foreach ($optionChildren($childrenField) as $child)
        <x-form-components::inputs.custom-select-option :value="$child" :level="$level + 1" {{ $attributes }}>
            @isset($optionTemplate)
                <x-slot:option-template>{{ $optionTemplate }}</x-slot:option-template>
            @endisset
        </x-form-components::inputs.custom-select-option>
    @endforeach
@else
    <li x-custom-select:option
        :value="{{ $optionValue() }}"
        :disabled="{{ \Illuminate\Support\Js::from($optionIsDisabled($disabledField)) }}"
        {{ $attributes->class('custom-select__option') }}
        x-bind:class="{
            {{-- $customSelectOption magic doesn't play nicely with class binding on ajax refresh for some reason, we just use __context for now... --}}
            'custom-select__option--active': __context.isActiveEl($el),
            'custom-select__option--selected': __context.isSelectedEl($el),
            'custom-select__option--disabled': __context.isDisabledEl($el) || (! $customSelect.canSelectMore && ! __context.isSelectedEl($el)),
        }"
    >
        <span class="truncate flex-1">
            @isset($optionTemplate)
                <span class="truncate" x-data="{ option: {{ \Illuminate\Support\Js::from($value) }} }">{{ $optionTemplate }}</span>
            @else
                {{ $optionLabel($labelField) }}
            @endisset
        </span>

        @if ($optionSelectedIcon)
            {{-- if we don't render this in a conditional that checks if the element is connected to the DOM, Alpine will throw an error from x-show... --}}
            <template x-if="$el.isConnected">
                <span x-show="$customSelectOption.isSelected"
                      class="shrink-0 custom-select__selected-icon"
                >
                    <x-dynamic-component :component="$optionSelectedIcon" />
                </span>
            </template>
        @endif
    </li>
@endif
