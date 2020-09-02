<div class="flex rounded-md shadow-sm relative">
    @include('form-components::partials.leading-addons')

    <input {!! $attributes->merge([
        'class' => $inputClass(),
        'id' => $name,
    ]) !!}
        name="{{ $name }}"
        type="{{ $type }}"

       @if ($hasErrorAndShow($name))
           aria-invalid="true"
           aria-describedby="{{ $name }}-error"
       @endif
    />

    @include('form-components::partials.trailing-addons')
</div>
