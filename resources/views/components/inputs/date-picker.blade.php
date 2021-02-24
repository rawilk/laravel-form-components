<div x-data="{
        fp: null,
        @if ($value && ! $attributes->whereStartsWith('wire:model')->first())
            value: '{{ $value }}',
        @elseif ($attributes->whereStartsWith('wire:model')->first())
            value: @entangle($attributes->wire('model')),
        @else
            value: null,
        @endif
     }"
     x-init="fp = flatpickr($refs.input, {
        defaultDate: value,
        {{ $jsonOptions() }}
        {{ $optionsSlot ?? '' }}
     })"
     x-on:change="value = $event.target.value; fp.setDate(value)"
     class="{{ $getContainerClass() }}"
     {{ $extraAttributes }}
>
    @if ($toggleIcon !== false)
        <span x-on:click="fp.open()"
              class="leading-addon cursor-pointer"
              role="button"
              title="{{ __('Select a date') }}"
        >
            {{ svg($toggleIcon) }}
        </span>
    @else
        @include('form-components::partials.leading-addons')
    @endif

    <input
        {{ $attributes->merge(['class' => $inputClass()])->except('type')->whereDoesntStartWith('wire:model') }}

        wire:ignore
        @if ($name) name="{{ $name }}" @endif
        @if ($id) id="{{ $id }}" @endif
        x-ref="input"
        x-bind:value="value"
        placeholder="{{ $placeholder }}"

        @if ($value && ! $attributes->whereStartsWith('wire:model')->first()) value="{{ $value }}" @endif

        @if ($hasErrorsAndShow($name))
            aria-invalid="true"

            @if (! $attributes->offsetExists('aria-describedby'))
                aria-describedby="{{ $id }}-error"
            @endif
        @endif
    />

    @if ($clearable)
        <div class="trailing-icon">
            <button x-show.transition.opacity.150ms="Boolean(value)"
                    x-on:click="value = null; fp.setDate(value)"
                    x-cloak
                    class="form-input-clear"
                    type="button"
            >
                <span class="sr-only">{{ __('Clear selected') }}</span>
                {{ svg($clearIcon) }}
            </button>
        </div>
    @else
        @include('form-components::partials.trailing-addons')
    @endif
</div>
