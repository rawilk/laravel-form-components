<div class="{{ $getContainerClass() }}">
    @include('form-components::partials.leading-addons')

    <input
        {{ $attributes->merge(['class' => $inputClass()]) }}
        {{ $extraAttributes }}

        @if ($name) name="{{ $name }}" @endif
        @if ($id) id="{{ $id }}" @endif
        type="{{ $type }}"

        @if (! is_null($value) && ! $attributes->hasStartsWith('wire:model')) value="{{ $value }}" @endif

        @if ($hasErrorsAndShow($name))
            aria-invalid="true"

            @if (! $attributes->offsetExists('aria-describedby'))
                aria-describedby="{{ $id }}-error"
            @endif
        @endif
    />

    @include('form-components::partials.trailing-addons')
</div>
