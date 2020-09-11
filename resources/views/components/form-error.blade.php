@error($name, $bag)
    <{{ $tag }} {{ $attributes->merge(['class' => 'form-error', 'id' => "{$inputId}-error"]) }}>
        @if ($slot->isEmpty())
            {{ $message }}
        @else
            {{ $slot }}
        @endif
    </{{ $tag }}>
@enderror
