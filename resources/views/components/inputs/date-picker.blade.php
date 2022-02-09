<div x-data="{
        fp: null,
        @if ($hasWireModel())
            value: @entangle($attributes->wire('model')),
        @elseif ($hasXModel())
            value: {{ $attributes->first('x-model') }},
        @else
            value: {{ $value ? "'{$value}'" : 'null' }},
        @endif
        updateValue(newValue) {
            this.value = newValue;
            $dispatch('input', newValue);

            try {
                this.fp.setDate(newValue);
            } catch {}

            @if ($hasXModel())
                {{ $attributes->first('x-model') }} = newValue;
            @endif
        },
     }"
     x-init="fp = flatpickr($refs.input, {
        defaultDate: value,
        onOpen: [
            function (selectedDates, dateStr, instance) {
                instance.setDate(value);
            },
            {{ $onOpen ?? '' }}
        ],
        {{ $jsonOptions() }}
        {{ $optionsSlot ?? '' }}
     })"
     x-on:change="updateValue($event.target.value)"
     class="{{ $getContainerClass() }}"
     {{ $extraAttributes }}
>
    @if ($toggleIcon !== false)
        <span x-on:click="fp.open()"
              class="leading-addon cursor-pointer inline-flex items-center px-3 rounded-l-md border border-r-0 border-slate-300 bg-slate-50 text-slate-500 sm:text-sm"
              role="button"
              title="{{ __('form-components::messages.date_picker_toggle_icon_title') }}"
        >
            <span class="h-5 w-5 text-slate-400">
                <x-dynamic-component :component="$toggleIcon" />
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

        @unless ($hasXModel())
            x-bind:value="value"
        @endunless

        placeholder="{{ $placeholder }}"

        @if ($value && ! $hasBoundModel()) value="{{ $value }}" @endif

        {!! $ariaDescribedBy() !!}
        @if ($hasErrorsAndShow($name))
            aria-invalid="true"
        @endif
    />

    @if ($clearable)
        <div class="trailing-icon pr-3 flex items-center absolute inset-y-0 right-0">
            <button x-show="Boolean(value)"
                    x-transition
                    x-cloak
                    x-on:click="updateValue(null)"
                    class="form-input-clear h-6 w-6 group rounded-full p-1 hover:bg-slate-200 focus:outline-slate transition-colors"
                    type="button"
            >
                <span class="sr-only">{{ __('form-components::messages.date_picker_clear_button') }}</span>
                <span class="h-4 w-4 text-slate-400 group-hover:text-slate-600"><x-dynamic-component :component="$clearIcon" /></span>
            </button>
        </div>
    @else
        @include('form-components::partials.trailing-addons')
    @endif
</div>
