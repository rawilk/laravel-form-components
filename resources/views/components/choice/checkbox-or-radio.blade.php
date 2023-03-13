@aware(['inputSize' => null])

<div class="{{ $containerClass($inputSize) }}">
    @includeWhen($labelLeft, 'form-components::components.choice.partials.label')

    <div @class([
        'choice-input',
        'choice-input--right' => $labelLeft,
    ])>
        <input
            {{ $attributes->except(['aria-describedby', 'type'])->class($inputClass()) }}
            type="{{ $type }}"
            @if ($name) name="{{ $name }}" @endif
            @if ($id) id="{{ $id }}" @endif
            @if ($hasErrorsAndShow($name))
                aria-invalid="true"
            @endif
            {!! $ariaDescribedBy() !!}
            {{ $extraAttributes ?? '' }}
            @if ($value && ! $hasBoundModel()) value="{{ $value }}" @endif
            @checked($checked && ! $hasBoundModel())
        />
    </div>

    @includeWhen(! $labelLeft, 'form-components::components.choice.partials.label')
</div>
