<div class="{{ $getContainerClass() }}">
    @include('form-components::partials.leading-addons')

    <input
        {{ $attributes->except('aria-describedby')->class($inputClass()) }}
        {!! $ariaDescribedBy() !!}
        {{ $extraAttributes }}

        @if ($name) name="{{ $name }}" @endif
        @if ($id) id="{{ $id }}" @endif
        type="{{ $type }}"

        @if (! is_null($value) && ! $hasBoundModel()) value="{{ $value }}" @endif

        @if ($hasErrorsAndShow($name))
            aria-invalid="true"
        @endif
    />

    @include('form-components::partials.trailing-addons')
</div>
