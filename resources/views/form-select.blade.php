<div class="flex rounded-md shadow-sm relative">
    @include('form-components::partials.leading-addons')

    <select name="{{ $name }}"

            @if ($multiple)
                multiple
            @endif

    {!! $attributes->merge([
        'id' => $name,
        'class' => $inputClass(),
    ]) !!}
    >
        {!! $slot !!}
        @foreach ($options as $key => $label)
            <option value="{{ $key }}" @if ($isSelected($key)) selected @endif>
                {{ $label }}
            </option>
        @endforeach

        {!! $append ?? '' !!}
    </select>

    @include('form-components::partials.trailing-addons')
</div>
