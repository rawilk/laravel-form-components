<input
    type="file"
    @if ($multiple) multiple @endif
    @if ($name) name="{{ $name }}" @endif
    @if ($id) id="{{ $id }}" @endif
    @if ($accepts()) accept="{{ $accepts()}}" @endif

    @if ($hasErrorsAndShow($name))
        aria-invalid="true"
    @endif
    {!! $ariaDescribedBy() !!}

    {{ $attributes->except('aria-describedby')->class($inputClass()) }}

    {{ $extraAttributes ?? '' }}
/>
