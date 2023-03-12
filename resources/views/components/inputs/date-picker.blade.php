<div
    x-data="{{ $initFunctionName() }}({
        @if ($hasWireModel())
            value: @entangle($attributes->wire('model')),
        @elseif ($hasXModel())
            value: {{ $attributes->first('x-model') }},
        @else
            value: {{ \Illuminate\Support\Js::from($value) }},
        @endif
        options: {{ \Illuminate\Support\Js::from($options()) }},
    })"

    @if ($hasXModel())
        {{ $attributes->whereStartsWith('x-model') }}
        x-modelable="value"
    @endif

    x-on:change="updateValue($event.target.value)"
    class="{{ $containerClass() }}"
>
    @if ($toggleIcon)
        {{ $before ?? '' }}
        <span
            class="leading-addon"
            role="button"
            x-on:click="open"
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
        @if ($hasErrorsAndShow($name))
            aria-invalid="true"
        @endif
        {!! $ariaDescribedBy() !!}
        {{ $attributes->except(['type', 'aria-describedby'])->whereDoesntStartWith(['wire:model', 'x-model'])->class($inputClass()) }}
        x-ref="input"
        type="text"
        x-bind:value="value"

        {{ $extraAttributes ?? '' }}
    />

    @if ($isClearable())
        <div class="trailing-icon">
            <span class="trailing-icon-container">
                <button
                    type="button"
                    class="clear-button"
                    x-on:click="updateValue('')"
                    x-transition
                    x-cloak
                    x-show="Boolean(value) && ! isDisabled"
                >
                    <span class="sr-only">{{ __('form-components::messages.date_picker_clear_button') }}</span>
                    <x-dynamic-component :component="$clearIcon" />
                </button>
            </span>
        </div>
        {{ $after ?? '' }}
    @endif
    @includeWhen(! $isClearable(), 'form-components::partials.trailing-addons')
</div>

<script>
    window.{{ $initFunctionName() }} = function({ value, options }) {
        let fp;

        // Having issues accessing `this.value` in the open listener,
        // so using this variable instead.
        let currentValue = value;

        if (currentValue?.hasOwnProperty('initialValue')) {
            currentValue = value.initialValue;
        }

        return {
            value,

            init() {
                if (! this.isDisabled) {
                    fp = flatpickr(this.$refs.input, this.config());
                }
            },

            get isDisabled() {
                return this.$refs.input.hasAttribute('disabled')
                    || this.$refs.input.hasAttribute('readonly');
            },

            updateValue(newValue) {
                if (this.isDisabled) {
                    return;
                }

                this.value = newValue;
                currentValue = newValue;
                this.$dispatch('input', newValue);

                try {
                    fp.setDate(newValue);
                } catch {}
            },

            open() {
                ! this.isDisabled && fp.open();
            },

            config() {
                const config = {
                    defaultValue: currentValue,
                    ...options,
                    onOpen: [
                        function (selectedDates, dateStr, instance) {
                            instance.setDate(currentValue);
                        },
                    ],
                };

                {{ $config ?? '' }}

                return config;
            },
        };
    };
</script>
