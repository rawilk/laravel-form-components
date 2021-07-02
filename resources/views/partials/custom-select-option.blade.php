<li :key="index"
    x-bind:id="`${selectId}_option_${index}`"
    x-on:mouseover="onMouseover(option, index)"
    x-on:mouseout="focusedOptionIndex = null"
    x-on:click="selectOption(option)"
    x-bind:class="optionClasses(option, index)"
    x-bind:role="isOptgroup(option) ? null : 'option'"
    x-bind:aria-selected="isOptgroup(option) ? false : (index === focusedOptionIndex)"
    class="custom-select__option group relative py-2 pl-3 pr-2 cursor-default select-none focus:outline-blue-gray"
>
    {{-- "optgroup" --}}
    <template x-if="isOptgroup(option)">
        <span x-text="option.label"></span>
    </template>

    {{-- regular option --}}
    <template x-if="! isOptgroup(option)">
        <div class="flex justify-between items-center">
            <div class="custom-select__option-display">
                @if ($optionDisplay)
                    {{-- user has opted to define their own option display --}}
                    {!! $optionDisplay !!}
                @else
                    <span x-text="option.text"></span>
                @endif
            </div>

            @if ($selectedIcon || $uncheckIcon)
                <span x-show="isSelected(option.value)"
                      x-cloak
                      x-bind:class="{ 'text-white': focusedOptionIndex === index, 'text-blue-gray-600': focusedOptionIndex !== index }"
                      class="absolute inset-y-0 right-0 flex items-center"
                >
                    @if ($selectedIcon)
                    <x-dynamic-component :component="$selectedIcon"
                                         x-show="! optional || focusedOptionIndex !== index"
                                         class="h-5 w-5"
                    />
                    @endif

                    @if ($uncheckIcon)
                    <x-dynamic-component :component="$uncheckIcon"
                                         x-show="optional && focusedOptionIndex === index"
                                         class="h-5 w-5"
                    />
                    @endif
                </span>
            @endif
        </div>
    </template>
</li>
