<li @unless ($disabled || $isGroup)
        x-on:mouseenter="onMouseEnter($event.currentTarget.dataset.value)"
        x-on:mouseleave="selected = null; currentIndex = -1"
        x-on:click="choose($event.currentTarget.dataset.value, $event)"
    @endunless

    @unless ($isGroup)
        role="option"
        x-bind:class="{ 'focused': selected === {{ $optionValue() }}, 'selected': isChosen({{ $optionValue() }}) }"
        data-option="{{ json_encode($option) }}"
        data-value="{{ $option['value'] }}"
        x-bind:aria-selected="JSON.stringify(isChosen({{ $optionValue() }}))"
    @endunless

    tabindex="-1"
    {{ $attributes->merge(['class' => $optionClass()]) }}
>
    @unless ($isGroup)
        <span class="custom-select--option__content">
            <span class="custom-select--option__text">
                @unless ($slot->isEmpty())
                    {{ $slot }}
                @else
                    {{ $option['text'] ?? '' }}
                @endunless
            </span>
        </span>

        @if ($selectedIcon || $uncheckIcon)
            <span x-show="isChosen({{ $optionValue() }})"
                  x-cloak
                  class="absolute inset-y-0 right-0 flex items-center pr-4 text-cool-gray-600"
                  x-bind:class="{ 'text-white': selected === {{ $optionValue() }}, 'text-cool-gray-600': ! (selected === {{ $optionValue() }}) }"
            >
                @if ($selectedIcon)
                <x-dynamic-component :component="$selectedIcon"
                                     class="h-5 w-5"
                                     x-show="! optional || ! (selected === {{ $optionValue() }})"
                />
                @endif

                @if ($uncheckIcon)
                <x-dynamic-component :component="$uncheckIcon"
                                     class="h-5 w-5 cursor-pointer"
                                     x-show="optional && selected === {{ $optionValue() }}"
                />
                @endif
            </span>
        @endif
    @else
        <span>
            @unless ($slot->isEmpty())
                {{ $slot }}
            @else
                {{ $option['text'] ?? '' }}
            @endif
        </span>
    @endunless
</li>
