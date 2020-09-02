<div class="flex rounded-md shadow-sm relative">
    @include('form-components::partials.leading-addons')

    <textarea name="{{ $name }}"
              {!! $attributes->merge(['id' => $name, 'rows' => 3, 'class' => $inputClass()]) !!}
    >{!! $slot !!}</textarea>

    @include('form-components::partials.trailing-addons')
</div>
