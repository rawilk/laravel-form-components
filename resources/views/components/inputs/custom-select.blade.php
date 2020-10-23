<div x-data="customSelect({
        {{ $configToJson() }}
        @if ($attributes->whereStartsWith('wire:model')->first())
            value: @entangle($attributes->wire('model')),
        @else
            value: {{ $selectedKeyToJS() }},
        @endif
        @if ($hasWireFilter = $attributes->whereStartsWith('wire:filter')->first())
            wireFilter: @entangle($attributes->wire('filter')),
        @endif
     })"
     x-init="init($watch)"
     wire:ignore.self
     class="custom-select-container form-text-container {{ $maxWidth }}"
>
    @include('form-components::partials.leading-addons')

    <div class="relative flex-1" {{ $attributes->except(['labelledby'])->whereDoesntStartWith('wire:') }}>
        {{-- trigger --}}
        <span class="inline-block w-full rounded-md shadow-sm z-1">
            <button x-on:click="toggle()"
                    x-on:keydown.arrow-up.stop.prevent="toggle()"
                    x-on:keydown.arrow-down.stop.prevent="toggle()"
                    x-on:keydown.tab.prevent="toggle()"
                    x-bind:aria-expanded="JSON.stringify(open)"
                    x-ref="button"
                    x-cloak
                    type="button"
                    aria-haspopup="listbox"
                    class="{{ $buttonClass() }}"
                    @if (isset($attributes['labelledby']))
                        aria-labelledby="{{ $attributes->get('labelledby') }}"
                    @endif
                    @if ($disabled)
                        disabled
                    @endif
            >
                <span class="custom-select--display space-x-2" x-html="display"></span>
                @if ($optional && $clearIcon)
                    <button x-on:click="clear()"
                            x-show.transition.opacity.150ms="hasValue"
                            type="button"
                            class="absolute top-2 right-8 flex justify-center items-center h-6 w-6 rounded-full text-cool-gray-500 transition duration-150 ease-in-out hover:bg-cool-gray-300 focus:outline-black"
                    >
                        <span class="sr-only">{{ __('Clear selected') }}</span>
                        <x-dynamic-component :component="$clearIcon" class="h-4 w-4" />
                    </button>
                @endif
                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                        <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </button>
        </span>

        {{-- options --}}
        <div x-show="open"
             x-cloak
             x-ref="container"
             x-on:click.away="open = false"
             x-on:keydown.escape.window="open = false"
             x-on:keydown.arrow-up.prevent="onArrowUp()"
             x-on:keydown.arrow-down.prevent="onArrowDown()"
             x-on:keydown.enter.stop.prevent="onOptionSelect()"
             x-on:keydown.home.stop.prevent="onHome()"
             x-on:keydown.end.stop.prevent="onEnd()"
             x-transition:enter="transition ease-in duration-100"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="custom-select--menu-container focus-within:shadow-outline-blue"
        >
            {{-- filter --}}
            @if ($filterable)
                <div class="custom-select--filter">
                    <input x-on:keydown.tab.prevent="focusMenu()"
                           x-on:keydown.shift.tab.prevent="closeMenu()"
                           x-ref="filter"
                           @unless ($hasWireFilter)
                               x-model.debounce.300ms="query"
                           @else
                                wire:model{{ $attributes->wire('filter')->modifiers()->count() ? '.' : '' }}{{ $attributes->wire('filter')->modifiers()->implode('.') }}="{{ $attributes->wire('filter')->value() }}"
                           @endunless
                           type="search"
                           class="form-input form-text"
                           wire:loading.class="busy"
                           placeholder="{{ __('Search...') }}"
                    />

                    @if ($hasWireFilter)
                        <span class="absolute top-5 -mt-0.5 right-6 animate-spin hidden" wire:loading.class.remove="hidden">
                            <x-heroicon-o-refresh class="h-5 w-5 text-cool-gray-400" />
                        </span>
                    @endif
                </div>
            @endif

            <ul x-ref="menu"
                x-on:keydown.space.stop.prevent="onOptionSelect()"
                x-on:keydown.tab.prevent="closeMenu()"
                x-on:keydown.shift.tab.prevent="onShiftTab()"
                x-bind:aria-activedescendant="activeDescendant"
                role="listbox"
                tabindex="-1"
                class="custom-select--menu"
                @if ($multiple)
                    aria-multiselectable="true"
                @endif
            >
                {{ $slot }}

                @foreach ($options as $option)
                    <x-custom-select-option :option="$option" :value-key="$valueKey" :text-key="$textKey" />
                @endforeach

                {{ $append ?? '' }}
            </ul>
        </div>
    </div>
</div>
