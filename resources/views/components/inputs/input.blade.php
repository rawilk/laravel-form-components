<div class="{{ $containerClass() }}">
    @include('form-components::partials.leading-addons')

    <input
        @include('form-components::components.inputs.partials.attributes')
        type="{{ $type }}"

        @if (! is_null($value) && ! $hasBoundModel()) value="{{ $value }}" @endif
    />

    @include('form-components::partials.trailing-addons')
</div>
