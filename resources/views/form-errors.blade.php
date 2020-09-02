@error($name)
    <p {!! $attributes->merge(['class' => 'form-error', 'id' => "{$name}-error"]) !!}>
        {{ $message }}
    </p>
@enderror
