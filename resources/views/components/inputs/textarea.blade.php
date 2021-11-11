<div class="{{ $getContainerClass() }}">
    @include('form-components::partials.leading-addons')

    <textarea @if ($name) name="{{ $name }}" @endif
              @if ($id) id="{{ $id }}" @endif
              {!! $ariaDescribedBy() !!}
              {{ $extraAttributes }}
              @if ($hasErrorsAndShow($name))
                  aria-invalid="true"
              @endif

              {!! $attributes->merge(['class' => $inputClass(), 'rows' => 3]) !!}
    >@if (! is_null($value) && ! $hasBoundModel()){!! $value !!}@elseif ($slot->isNotEmpty()){!! $slot !!}@endif</textarea>

    @include('form-components::partials.trailing-addons')
</div>
