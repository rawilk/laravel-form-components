<div class="{{ $containerClass() }}"
     @if ($showToggle)
         x-data="{ show: {{ Js::from($initiallyShowPassword) }} }"
     @endif
>
    @include('form-components::partials.leading-addons')

    <input
        @include('form-components::components.inputs.partials.attributes')

        @if (! is_null($value) && ! $hasBoundModel()) value="{{ $value }}" @endif

        @if ($showToggle)
            x-bind:type="show ? 'text' : 'password'"
        @else
            type="password"
        @endif
    />

    @includeWhen($showToggle, 'form-components::components.inputs.partials.password-toggle')

    @includeWhen(! $showToggle, 'form-components::partials.trailing-addons')
</div>
