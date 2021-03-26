@error($name, $bag)
    <{{ $tag }} {{ $attributes->merge(['class' => 'form-error mt-1 text-red-500 text-sm', 'id' => "{$inputId}-error"]) }}>
        @if ($slot->isEmpty())
            {{ $message }}
        @else
            {{ $slot }}
        @endif
    </{{ $tag }}>
@enderror
