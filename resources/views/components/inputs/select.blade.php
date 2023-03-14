<div class="{{ $containerClass() }}">
    @include('form-components::partials.leading-addons')

    <select
        @include('form-components::components.inputs.partials.attributes')
        @if ($multiple) multiple @endif
    >
        {{ $slot }}

        @foreach ($options as $option)
            @include('form-components::components.inputs.partials.select-option', ['option' => $option])
        @endforeach

        {{ $append ?? '' }}
    </select>

    @include('form-components::partials.trailing-addons')
</div>
