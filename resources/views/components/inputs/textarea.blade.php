{{-- we add an x-data directive to the container to ensure our resize directive is in an alpine scope so it will run --}}
<div class="{{ $containerClass() }}" @if ($autoResize) x-data @endif>
    @include('form-components::partials.leading-addons')

    <textarea
        @if ($name) name="{{ $name }}" @endif
        @if ($id) id="{{ $id }}" @endif
        @if ($hasErrorsAndShow($name))
            aria-invalid="true"
        @endif
        {!! $ariaDescribedBy() !!}

        {{ $attributes->except('aria-describedby')->merge(['class' => $inputClass(), 'rows' => config('form-components.defaults.textarea.rows', 3)]) }}

        {{ $extraAttributes ?? '' }}

        @if ($autoResize) x-textarea-resize @endif
    >@if (! is_null($value) && ! $hasBoundModel()){!! $value !!}@elseif ($slot->isNotEmpty()){!! $slot !!}@endif</textarea>

    @include('form-components::partials.trailing-addons')
</div>
