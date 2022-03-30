@aware(['name' => '', 'multiple' => false, 'showCheckbox' => false])

<li wire:key="customSelect{{ $name }}Option-{{ $value }}"
    @unless ($isOptGroup)
        x-data="customSelectOption({{ $configToJs() }})"
        x-bind:data-disabled="optionDisabled ? '1' : '0'"
        x-on:mouseover.stop="focus({ updateParentIndex: true, scroll: false })"
        x-on:mouseout.stop="hasFocus = false"
        x-on:custom-select-{{ \Illuminate\Support\Str::slug($name) }}-option-focused.window="onReceivedFocus"
        role="option"
    @endunless

    @class([
        'custom-select-option',
        'custom-select-option--opt-group' => $isOptGroup,
        'relative group',
        'disabled' => $disabled,
    ])

    @unless ($isOptGroup)
        x-bind:class="{ 'has-focus': hasFocus, 'selected': optionSelected() }"
        x-bind:aria-selected="optionSelected() ? 'true' : 'false'"
    @endunless
    tabindex="-1"
    id="customSelect{{ $name }}Option-{{ $value }}"
>
    <div class="custom-select-option__container">
        <div
            @unless ($isOptGroup)
                x-on:click.stop="toggle"
            @endunless
            @class([
                'custom-select-option__label',
                'flex-1 flex',
                'cursor-pointer' => ! $disabled && ! $isOptGroup,
            ])
        >
            {{-- checkbox --}}
            @if ($showCheckbox && ! $isOptGroup)
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
</li>
