<div x-data="customSelect({
        {{ $configToJson() }}
        @if ($attributes->hasStartsWith('wire:model'))
            value: @entangle($attributes->wire('model')),
            _wire: $wire,
        @else
            value: {{ $selectedKeyToJS() }},
        @endif
        @if ($attributes->hasStartsWith('wire:filter'))
            wireFilter: '{{ $attributes->wire('filter')->value() }}',
        @endif
     })"
     x-on:click.outside="close"
     x-on:keydown.escape="close"
     x-on:keydown.enter.stop.prevent="onEnter"
     x-on:keydown.arrow-up.prevent="focusPreviousOption"
     x-on:keydown.arrow-down.prevent="focusNextOption"
     x-on:keydown.home.prevent="onHome"
     x-on:keydown.end.prevent="onEnd"
     x-on:keydown.tab="close"
     wire:ignore.self
     class="{{ $getContainerClass() }}"
     {{ $extraAttributes }}
>
    <div x-cloak
         x-ref="container"
         x-bind:class="{ 'custom-select__menu-container--open ring-blue-400 ring-opacity-50 ring-2': open, 'invisible': ! open }"
         class="custom-select__menu-container absolute w-full rounded-md bg-white shadow-lg z-10"
    >
        @if ($filterable)
            <div class="custom-select__filter relative py-2 px-2 border-b border-blue-gray-200">
                <input x-ref="search"
                       x-show="open"
                       @if ($attributes->hasStartsWith('wire:filter'))
                           wire:loading.class="busy"
                           wire:target="{{ $attributes->wire('filter')->value() }}"
                       @endif
                       x-model.debounce.300ms="search"
                       type="search"
                       placeholder="{{ __('form-components::messages.custom_select_filter_placeholder') }}"
                       class="custom-select__filter-input py-1 h-full w-full border-blue-gray-300 rounded-md bg-white focus:border-blue-gray-400 focus:ring-0 text-sm focus:outline-none"
                />

                @if ($attributes->hasStartsWith('wire:filter'))
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
            class="custom-select__menu py-1 overflow-auto text-base leading-6 rounded-md shadow-sm max-h-60 focus:outline-none sm:text-sm sm:leading-5 @if ($filterable) rounded-t-none @endif"
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
                <li class="custom-select__option custom-select__option-no-results relative py-2 pl-3 pr-9 cursor-default select-none focus:outline-blue-gray italic text-blue-gray-600">
                    {{ $emptyText }}
                </li>
            </template>
        </ul>
    </div>

    @include('form-components::partials.leading-addons')
    @include('form-components::partials.custom-select-button')

    @unless ($attributes->hasStartsWith('wire:model'))
        @if ($multiple)
            <template x-for="item in value">
                <input type="hidden" x-bind:value="item" name="{{ $name }}[]">
            </template>
        @else
            <input type="hidden" x-bind:value="value" name="{{ $name }}">
        @endif
    @endif
</div>
