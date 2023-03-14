{{ $attributes->except('aria-describedby')->class($inputClass()) }}
@if ($name) name="{{ $name }}" @endif
@if ($id) id="{{ $id }}" @endif
@if ($hasErrorsAndShow($name))
    aria-invalid="true"
@endif
{!! $ariaDescribedBy() !!}
{{ $extraAttributes ?? '' }}
