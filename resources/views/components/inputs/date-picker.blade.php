<div
    x-data="datePicker({
        @if ($hasWireModel())
            value: @entangle($attributes->wire('model')),
        @elseif ($hasXModel())
            value: {{ $attributes->first('x-model' ) }},
        @else
            value: {{ \Illuminate\Support\Js::from($value) }},
        @endif

        options: {{ \Illuminate\Support\Js::from($options()) }},

        config: { {{ $config ?? '' }} },
    })"
    wire:ignore.self

    @if ($hasXModel())
        {{ $attributes->whereStartsWith('x-model') }}
        x-modelable="__value"
    @endif

    class="date-picker-root"
>
    <div
        class="{{ $containerClass() }}"
        x-date-picker:container

        {{-- we are going to use a MutationObserver on this element to clone these attributes to the input since it is being wire:ignored --}}
        @if ($hasErrorsAndShow($name))
            aria-invalid="true"
        @endif
        {!! $ariaDescribedBy() !!}
    >
        @if ($toggleIcon)
            {{ $before ?? '' }}
            <span
                x-date-picker:toggle
                class="leading-addon"
                title="{{ __('form-components::messages.date_picker_toggle_icon_title') }}"
            >
                <x-dynamic-component :component="$toggleIcon" />
            </span>
        @endif
        @includeWhen(! $toggleIcon, 'form-components::partials.leading-addons')

        <input
            @if ($name) name="{{ $name }}" @endif
            @if ($id) id="{{ $id }}" @endif
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            {{ $attributes->except(['type', 'aria-describedby'])->whereDoesntStartWith(['wire:model', 'x-model'])->class($inputClass()) }}
            x-date-picker:input
            wire:ignore

            {{ $extraAttributes ?? '' }}
        />

        @if ($isClearable())
            <div class="trailing-icon">
                <div class="trailing-icon-container">
                    <button
                        x-date-picker:clear
                        class="clear-button"
                        x-cloak
                        x-transition
                    >
                        <span class="sr-only">{{ __('form-components::messages.date_picker_clear_button') }}</span>
                        <x-dynamic-component :component="$clearIcon" />
                    </button>
                </div>
            </div>
            {{ $after ?? '' }}
        @endif
        @includeWhen(! $isClearable(), 'form-components::partials.trailing-addons')
    </div>

    {{ $end ?? '' }}
</div>
