<div x-data="customSelect({
        {{ $configToJson() }}
        @if ($hasWireModel = $attributes->whereStartsWith('wire:model')->first())
            value: @entangle($attributes->wire('model')),
        @else
            value: {{ $selectedKeyToJS() }},
        @endif
        @if ($hasWireFilter = $attributes->whereStartsWith('wire:filter')->first())
            wireFilter: '{{ $attributes->wire('filter')->value() }}',
        @endif
     })"
     x-init="init($wire || null, $dispatch)"
     x-on:click.away="close()"
     x-on:keydown.escape="close()"
     x-on:keydown.enter.stop.prevent="onEnter()"
     x-on:keydown.arrow-up.prevent="focusPreviousOption()"
     x-on:keydown.arrow-down.prevent="focusNextOption()"
     x-on:keydown.home.prevent="onHome()"
     x-on:keydown.end.prevent="onEnd()"
     x-on:keydown.tab="close()"
     wire:ignore.self
     class="custom-select-container form-text-container {{ $maxWidth }}"
>
    @include('form-components::partials.leading-addons')
    @include('form-components::partials.custom-select-button')

    <div x-show="open"
         x-cloak
         x-ref="container"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-bind:class="{ 'custom-select__menu-container--open': open, 'custom-menu-top': positionOnTop }"
         class="custom-select__menu-container"
    >
        @if ($filterable)
            <div class="custom-select__filter">
                <input x-ref="search"
                       x-show="open"
                       @if ($hasWireFilter)
                           wire:loading.class="busy"
                           wire:target="{{ $attributes->wire('filter')->value() }}"
                       @endif
                       x-model.debounce.300ms="search"
                       type="search"
                       placeholder="{{ __('Search...') }}"
                       class="custom-select__filter-input"
                />

                @if ($hasWireFilter)
                    <span wire:loading.class.remove="hidden"
                          class="absolute top-4 -mt-0.5 right-4 animate-spin hidden"
                    >
                        <x-heroicon-o-refresh class="h-4 w-4 text-primary-400" />
                    </span>
                @endif
            </div>
        @endif

        <ul x-ref="listbox"
            x-bind:aria-activedescendant="focusedOptionIndex !== null ? selectId + '_option_' + focusedOptionIndex : null"
            role="listbox"
            tabindex="-1"
            class="custom-select__menu"
            @if ($multiple)
                aria-multiselectable="true"
            @endif
        >
            <template x-for="(option, index) in options"
                      :key="index"
            >
                @include('form-components::partials.custom-select-option')
            </template>

            <template x-if="! options.length">
                <li class="custom-select__option custom-select__option-no-results">
                    {{ $emptyText }}
                </li>
            </template>
        </ul>
    </div>

    @unless ($hasWireModel)
        <input type="hidden" x-bind:value="JSON.stringify(value)" name="{{ $name }}">
    @endif
</div>
