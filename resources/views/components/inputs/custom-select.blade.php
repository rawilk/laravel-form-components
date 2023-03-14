<div
    class="{{ $containerClass() }}"
    x-data="customSelect({
        __el: $root,

        @if ($livewireSearch)
            __wire: @this,
        @endif

        @if ($hasWireModel())
            __value: @entangle($attributes->wire('model')),
        @elseif ($hasXModel())
            __value: {{ $attributes->first('x-model') }},
        @else
            __value: {{ \Illuminate\Support\Js::from($value) }},
        @endif

        __config: {{ $config() }},
    })"
    x-id="() => ['fc-custom-select-button', 'fc-custom-select-options', 'fc-custom-select-label', 'fc-custom-select-search']"
    wire:ignore.self

    @if ($name) name="{{ $name }}" @endif
    @if ($multiple) data-multiple @endif
    @if ($searchable) searchable @endif
    @if ($clearable) clearable @endif
    @if ($livewireSearch) livewire-search="{{ $livewireSearch }}" @endif
    by="{{ $valueField }}"

    {{ $attributes->except(['class'])->whereDoesntStartWith(['x-model', 'wire:model']) }}
    {{ $extraAttributes ?? '' }}

    @if ($hasXModel())
        {{ $attributes->whereStartsWith('x-model') }}
        x-modelable="__value"
    @endif
>
    {{-- trigger --}}
    @include('form-components::partials.select.select-trigger', ['type' => 'custom'])

    {{-- menu --}}
    <div
        x-custom-select:options
        class="{{ $menuClass() }}"
        x-cloak
        @if ($alwaysOpen) static @endif
        wire:ignore.self
    >
        @if ($searchable)
            <div class="custom-select__search" wire:ignore>
                <input
                    x-custom-select:search
                    placeholder="{{ __('form-components::messages.custom_select_filter_placeholder') }}"
                />
            </div>
        @endif

        <ul class="custom-select__menu-content"
            wire:ignore.self
            @if ($livewireSearch)
                wire:loading.class.delay="hidden"
                wire:target="{{ $livewireSearch }}"
            @endif

            {{-- attaching an x-data to this so the options can find it when they are destroyed, as for some reason --}}
            {{-- we can't find any parents higher than the x-custom-select:options directive el when searching for them... --}}
            x-data
        >
            @foreach ($options as $option)
                <x-form-components::inputs.custom-select-option :value="$option">
                    @isset($optionTemplate)
                        <x-slot:option-template>{{ $optionTemplate }}</x-slot:option-template>
                    @endisset
                </x-form-components::inputs.custom-select-option>
            @endforeach

            <template x-if="! $customSelect.hasOptions">
                <x-form-components::inputs.partials.no-options>
                    <span x-text="$customSelect.hasSearch ? '{{ $noResultsText }}' : '{{ $noOptionsText }}'"></span>
                </x-form-components::inputs.partials.no-options>
            </template>

            {{ $slot }}
        </ul>

        @if ($livewireSearch)
            <x-form-components::inputs.partials.select-loader target="{{ $livewireSearch }}" />
        @endif
    </div>
</div>
