<div class="form-text-container {{ $maxWidth }}">
    @include('form-components::partials.leading-addons')

    <textarea name="{{ $name }}"
              id="{{ $id }}"
              @if ($hasErrorsAndShow($name))
                  aria-invalid="true"

                  @if (! $attributes->offsetExists('aria-describedby'))
                     aria-describedby="{{ $id }}-error"
                  @endif
              @endif

              {!! $attributes->merge(['class' => $inputClass(), 'rows' => 3]) !!}
    >@if (($slot || $value) && ! $attributes->whereStartsWith('wire:model')->first()){!! $value ?? old($name, $slot) !!}@endif</textarea>

    @include('form-components::partials.trailing-addons')
</div>
