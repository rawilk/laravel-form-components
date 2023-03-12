@if ($hasLabel($slot))
<label
    @if ($for) for="{{ $for }}" @endif
    {{ $attributes->except('id')->class('form-label') }}
   :id="$id('fc-label')"
>
    @if ($slot->isEmpty())
        {{ $fallback }}
    @else
        {{ $slot }}
    @endif
</label>
@endif
