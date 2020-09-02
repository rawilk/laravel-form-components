@if ($label)
    <label @if($for)for="{{ $for }}"@endif
           {!! $attributes->merge(['class' => 'form-label']) !!}
    >
        {{ $label }}
    </label>
@endif
