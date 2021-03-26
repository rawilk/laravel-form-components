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
              class="leading-addon cursor-pointer inline-flex items-center px-3 rounded-l-md border border-r-0 border-blue-gray-300 bg-blue-gray-50 text-blue-gray-500 sm:text-sm"
              role="button"
              title="{{ __('Select a date') }}"
        >
            <span class="h-5 w-5 text-blue-gray-400">
                {{ svg($toggleIcon) }}
            </span>
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
        <div class="trailing-icon pr-3 flex items-center absolute inset-y-0 right-0">
            <button x-show.transition.opacity.150ms="Boolean(value)"
                    x-on:click="value = null; fp.setDate(value)"
                    x-cloak
                    class="form-input-clear h-6 w-6 group rounded-full p-1 hover:bg-blue-gray-200 focus:outline-blue-gray transition-colors"
                    type="button"
            >
                <span class="sr-only">{{ __('Clear selected') }}</span>
                <span class="h-4 w-4 text-blue-gray-400 group-hover:text-blue-gray-600">{{ svg($clearIcon) }}</span>
            </button>
        </div>
    @else
        @include('form-components::partials.trailing-addons')
    @endif
</div>
