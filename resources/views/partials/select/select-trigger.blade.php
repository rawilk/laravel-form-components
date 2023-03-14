<div class="custom-select__button-container" wire:ignore>
    @include('form-components::partials.leading-addons')

    <button
        x-{{ $type }}-select:button
        {{ $attributes->only('class')->class($buttonClass()) }}
        x-bind:class="{ 'open': ${{ $type }}Select.isOpen }"
    >
        <div class="custom-select__button-content">
            @if ($multiple)
                <span class="custom-select__button-tokens" x-cloak x-show="${{ $type }}Select.hasValue">
                    <template x-for="selectedObject in ${{ $type }}Select.selectedObject" :key="selectedObject.{{ $valueField }}">
                        <span
                            x-{{ $type }}-select:token
                            class="custom-select__button-token group"
                            :class="{ 'custom-select__button-token--deleteable': ${{ $type }}Select.canDeselectOptions, 'disabled': ${{ $type }}Select.isDisabled }"
                            :value="selectedObject"
                        >
                            <span
                                class="truncate"
                                @unless (isset($selectedTemplate)) x-text="selectedObject.{{ $selectedLabelField }}" @endunless
                            >
                                {{ $selectedTemplate ?? '' }}
                            </span>

                            @if ($clearIcon)
                                <span
                                    class="custom-select__button-token-delete"
                                    x-show="${{ $type }}Select.canDeselectOptions"
                                >
                                    <x-dynamic-component :component="$clearIcon" />
                                </span>
                            @endif
                        </span>
                    </template>
                </span>
            @else
                <span class="truncate"
                      x-show="${{ $type }}Select.hasValue"
                      x-cloak
                      @unless (isset($selectedTemplate)) x-text="${{ $type }}Select.selectedObject?.{{ $selectedLabelField }}" @endunless
                >
                    {{ $selectedTemplate ?? '' }}
                </span>
            @endif

            <span x-show="! ${{ $type }}Select.hasValue" x-cloak>{{ $placeholder }}</span>
        </div>

        @if ($clearIcon && $clearable)
            <span
                x-{{ $type }}-select:clear
                class="clear-button"
            >
                <span class="sr-only">{{ __('form-components::messages.custom_select_clear_button') }}</span>
                <x-dynamic-component :component="$clearIcon" />
            </span>
        @endif

        @if ($buttonIcon)
            <x-dynamic-component :component="$buttonIcon" class="custom-select__button-icon" />
        @endif
    </button>

    @include('form-components::partials.trailing-addons')
</div>
