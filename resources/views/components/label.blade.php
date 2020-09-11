@if ($hasLabel($slot))
<label @if ($for) for="{{ $for }}" @endif {{ $attributes->merge(['class' => 'form-label']) }}>
    @if ($slot->isEmpty())
        {{ $fallback }}
    @else
        {{ $slot }}
    @endif
</label>
@endif
