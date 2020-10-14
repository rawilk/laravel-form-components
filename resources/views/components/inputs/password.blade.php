<div @if ($showToggle)
        x-data="{ show: false }"
    @endif
    class="form-text-container {{ $maxWidth }}"
>
    @include('form-components::partials.leading-addons')

    <input
        {{ $attributes->merge(['class' => $inputClass()]) }}

        name="{{ $name }}"
        @if ($id) id="{{ $id }}" @endif

        @if ($showToggle)
            :type="show ? 'text' : 'password'"
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
        <div @click="show = ! show"
             :title="show ? '{{ __('Hide') }}' : '{{ __('Show') }}'"
             class="trailing-icon clickable"
             x-cloak
        >
            <span x-show="! show">
                {{ svg($showPasswordIcon) }}
            </span>

            <span x-show="show">
                {{ svg($hidePasswordIcon) }}
            </span>
        </div>
    @endif
</div>
