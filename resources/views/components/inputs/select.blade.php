<div class="form-text-container">
    @include('form-components::partials.leading-addons')

    <select name="{{ $name }}"
            id="{{ $id }}"
            @if ($multiple) multiple @endif

            @if ($hasErrorsAndShow($name))
                aria-invalid="true"

                @if (! $attributes->offsetExists('aria-describedby'))
                    aria-describedby="{{ $id }}-error"
                @endif
            @endif

            {{ $attributes->merge(['class' => $inputClass()]) }}
    >
        {{ $slot }}

        @foreach ($options as $key => $label)
            <option value="{{ $key }}" @if ($isSelected($key)) selected @endif>
                {{ $label }}
            </option>
        @endforeach

        {{ $append ?? '' }}
    </select>

    @include('form-components::partials.trailing-addons')
</div>
