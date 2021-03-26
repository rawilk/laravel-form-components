<div class="{{ $getContainerClass() }}">
    @include('form-components::partials.leading-addons')

    <textarea @if ($name) name="{{ $name }}" @endif
              @if ($id) id="{{ $id }}" @endif
              {{ $extraAttributes }}
              @if ($hasErrorsAndShow($name))
                  aria-invalid="true"

                  @if (! $attributes->offsetExists('aria-describedby'))
                     aria-describedby="{{ $id }}-error"
                  @endif
              @endif

              {!! $attributes->merge(['class' => $inputClass(), 'rows' => 3]) !!}
    >@if (! is_null($value) && ! $attributes->whereStartsWith('wire:model')->first()){!! $value !!}@elseif ($slot->isNotEmpty()){!! $slot !!}@endif</textarea>

    @include('form-components::partials.trailing-addons')
</div>
