<span class="inline-block w-full rounded-md shadow-sm z-1 custom-select__button-container">
    <button x-ref="button"
            x-cloak
            x-on:click="toggle()"
            x-bind:aria-expanded="JSON.stringify(open)"
            aria-haspopup="listbox"
            type="button"
            class="{{ $buttonClass() }}"
            @if (isset($attributes['labelledby'])) aria-labelledby="{{ $attributes['labelledby'] }}" @endif
            @if ($disabled) disabled @endif
    >
        <template x-if="! hasSelection()">
            <span class="custom-select__placeholder text-blue-gray-500 block truncate" x-text="placeholder"></span>
        </template>

        <div class="custom-select__display flex truncate items-center" x-show="hasSelection()" wire:ignore>
            @if ($buttonDisplay)
                {{-- user has opted to customize the "selected text" on the button --}}
                {!! $buttonDisplay !!}
            @else
                <span x-html="buttonDisplay"></span>
            @endif
        </div>

        @if ($optional && $clearIcon)
            <button x-on:click="clear()"
                    x-show.transition.opacity.150ms="hasSelection()"
                    type="button"
                    class="custom-select-clear absolute right-8 flex items-center justify-center h-6 w-6 rounded-full text-blue-gray-500 transition-colors hover:bg-blue-gray-300 focus:outline-blue-gray"
            >
                <span class="sr-only">{{ __('form-components::messages.custom_select_clear_button') }}</span>
                <x-dynamic-component :component="$clearIcon" class="h-4 w-4" />
            </button>
        @endif

        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
            <svg class="w-5 h-5 text-blue-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round"
                      stroke-linejoin="round"></path>
            </svg>
        </span>
    </button>
</span>
