<div class="{{ $getContainerClass() }}">
    @include('form-components::partials.leading-addons')

    <select @if ($name) name="{{ $name }}" @endif
            @if ($id) id="{{ $id }}" @endif
            @if ($multiple) multiple @endif
            {!! $ariaDescribedBy() !!}
            {{ $extraAttributes }}

            @if ($hasErrorsAndShow($name))
                aria-invalid="true"
            @endif

            {{ $attributes->class($inputClass()) }}
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
