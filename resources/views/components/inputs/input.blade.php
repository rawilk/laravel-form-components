<div class="form-text-container {{ $maxWidth }}">
    @include('form-components::partials.leading-addons')

    <input
        {{ $attributes->merge(['class' => $inputClass()]) }}

        name="{{ $name }}"
        @if ($id) id="{{ $id }}" @endif
        type="{{ $type }}"

        @if ($value && ! $attributes->whereStartsWith('wire:model')->first()) value="{{ $value }}" @endif

        @if ($hasErrorsAndShow($name))
            aria-invalid="true"

            @if (! $attributes->offsetExists('aria-describedby'))
                aria-describedby="{{ $id }}-error"
            @endif
        @endif
    />

    @include('form-components::partials.trailing-addons')
</div>
