<x-form-components::inputs.custom-select
    :name="$name"
    :id="$id"
    :value="$value"
    :show-errors="$showErrors"
    :searchable="$searchable"
    :optional="$optional"
    :placeholder="$placeholder"
    :multiple="$multiple"
    :disabled="$disabled"
    :autofocus="$autofocus"
    :min-selected="$minSelected"
    :max-selected="$maxSelected"
    :show-checkbox="$showCheckbox"
    :clear-icon="$clearIcon"
    :extra-attributes="$extraAttributes"
    {{ $attributes }}
>
    @foreach (app('fc-timezone')->only($only)->all() as $region => $regionTimezones)
        <x-form-components::inputs.custom-select-option
            label="{{ $region }}"
            is-opt-group
        />

        @foreach ($regionTimezones as $id => $name)
            <x-form-components::inputs.custom-select-option
                value="{{ $id }}"
                label="{{ $name }}"
            />
        @endforeach
    @endforeach
</x-form-components::inputs.custom-select>
