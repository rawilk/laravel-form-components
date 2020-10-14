<div class="form-text-container {{ $maxWidth }}">
    @include('form-components::partials.leading-addons')

    <select name="{{ $name }}"
            @if ($id) id="{{ $id }}" @endif
            @if ($multiple) multiple @endif

            @if ($hasErrorsAndShow($name))
                aria-invalid="true"

                @if (! $attributes->offsetExists('aria-describedby'))
                    aria-describedby="{{ $id }}-error"
                @endif
            @endif

        {{ $attributes->merge(['class' => $inputClass()]) }}
    >
        {{ $slot }}

        @foreach (app('fc-timezone')->only($only)->all() as $region => $regionTimezones)
            <optgroup label="{{ $region }}">
                @foreach ($regionTimezones as $key => $display)
                    <option value="{{ $key }}"@if ($isSelected($key)) selected @endif>{{ $display }}</option>
                @endforeach
            </optgroup>
        @endforeach
    </select>

    @include('form-components::partials.trailing-addons')
</div>
