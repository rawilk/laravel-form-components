@if ($hasLabel($slot))
<label @if ($for) for="{{ $for }}" @endif {{ $attributes->class('form-label block text-sm font-medium leading-5 text-blue-gray-700') }}>
    @if ($slot->isEmpty())
        {{ $fallback }}
    @else
        {{ $slot }}
    @endif
</label>
@endif
