<div @if ($showToggle)
        x-data="{ show: false }"
     @endif
     class="{{ $containerClass() }}"
>
    @include('form-components::partials.leading-addons')

    <input
        {{ $attributes->merge(['class' => $inputClass()]) }}
        {{ $extraAttributes }}

        @if ($name) name="{{ $name }}" @endif
        @if ($id) id="{{ $id }}" @endif

        @if ($showToggle)
            x-bind:type="show ? 'text' : 'password'"
        @else
            type="password"
        @endif

        @if ($value && ! $attributes->whereStartsWith('wire:model')->first()) value="{{ $value }}" @endif

        @if ($hasErrorsAndShow($name))
            aria-invalid="true"

            @if (! $attributes->offsetExists('aria-describedby'))
                aria-describedby="{{ $id }}-error"
            @endif
        @endif
    />

    @if ($showToggle)
        <div x-on:click="show = ! show"
             x-bind:title="show ? '{{ __('Hide') }}' : '{{ __('Show') }}'"
             class="trailing-icon password-toggle clickable pr-3 flex items-center bg-white border rounded-md rounded-l-none border-l-0 {{ $hasErrorsAndShow($name) ? 'border-red-300' : 'border-blue-gray-300 group-focus:border-blue-300' }}"
             x-cloak
        >
            <span x-show="! show" class="h-5 w-5 text-blue-gray-400">
                {{ svg($showPasswordIcon) }}
            </span>

            <span x-show="show" class="h-5 w-5 text-blue-gray-400">
                {{ svg($hidePasswordIcon) }}
            </span>
        </div>
    @endif
</div>
