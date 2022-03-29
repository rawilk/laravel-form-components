<div x-data="{
        onValue: {{ \Illuminate\Support\Js::from($onValue) }},
        offValue: {{ \Illuminate\Support\Js::from($offValue) }},
        @if ($hasWireModel())
            value: @entangle($attributes->wire('model')),
        @elseif ($hasXModel())
            value: {{ $attributes->first('x-model') }},
        @else
            value: {{ \Illuminate\Support\Js::from($value) }},
        @endif
        get isPressed() {
            return this.value === this.onValue;
        },
        toggle() {
            this.value = this.isPressed ? this.offValue : this.onValue;
            $dispatch('input', this.value);
            @if ($hasXModel())
                {{ $attributes->first('x-model') }} = this.value;
            @endif
        },
     }"
     wire:ignore.self
     class="{{ $getContainerClass() }}"
     {{ $extraAttributes }}
>
    @if ($label && $labelPosition === 'left')
        <span x-on:click="$refs.button.click(); $refs.button.focus();"
              class="flex-grow switch-toggle-label form-label block text-sm font-medium leading-5 text-slate-700"
              id="{{ $labelId() }}"
        >
            {{ $label }}
        </span>
    @endif

    <button x-bind:aria-pressed="JSON.stringify(isPressed)"
            x-on:click="toggle()"
            x-ref="button"
            x-cloak
            type="button"
            @if ($id) id="{{ $id }}" @endif
            @if ($label) aria-labelledby="{{ $labelId() }}" @endif
            {{ $attributes->except(['type', 'wire:model', 'wire:model.defer', 'wire:model.lazy', 'x-model'])->merge(['class' => $buttonClass()]) }}
            x-bind:class="{ 'pressed': isPressed }"
            @if ($disabled) disabled @endif
    >
        <span class="sr-only">{{ __($buttonLabel) }}</span>

        @if ($short)
            <span aria-hidden="true"
                  class="switch-toggle-short-bg"
                  x-bind:class="{ 'pressed': isPressed }"
            >
            </span>

            <span aria-hidden="true"
                  class="switch-toggle-short-button"
                  x-bind:class="{ 'pressed': isPressed }"
            >
            </span>
        @else
            <span aria-hidden="true"
                  class="switch-toggle-button"
                  x-bind:class="{ 'pressed': isPressed }"
            >
                @if ($offIcon)
                    <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity"
                          x-bind:class="{ 'opacity-0 ease-out duration-100': isPressed, 'opacity-100 ease-in duration-200': ! isPressed }"
                          aria-hidden="true"
                    >
                        {{ $offIcon }}
                    </span>
                @endif

                @if ($onIcon)
                    <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity"
                          x-bind:class="{ 'opacity-100 ease-in duration-200': isPressed, 'opacity-0 ease-out duration-100': ! isPressed }"
                          aria-hidden="true"
                    >
                        {{ $onIcon }}
                    </span>
                @endif
            </span>
        @endif
    </button>

    @if ($label && $labelPosition === 'right')
        <span x-on:click="$refs.button.click(); $refs.button.focus()"
              class="ml-3 switch-toggle-label form-label block text-sm font-medium leading-5 text-slate-700"
              id="{{ $labelId() }}"
        >
            {{ $label }}
        </span>
    @endif

    @if ($name)
        <input type="hidden" name="{{ $name }}" x-bind:value="value" />
    @endif
</div>
