@if ($optionIsOptGroup($option))
    <optgroup label="{{ $optionLabel($option) }}">
        @foreach ($optionChildren($option) as $child)
            @include('form-components::components.inputs.partials.select-option', ['option' => $child])
        @endforeach
    </optgroup>
@else
    <option
        value="{{ $optionValue($option) }}"
        @selected($isSelected($optionValue($option)))
        @disabled($optionIsDisabled($option))
    >
        {{ $optionLabel($option) }}
    </option>
@endif
