<x-form-components::inputs.custom-select
    :name="$name"
    :id="$id"
    :options="$options"
    :value="$value"
    :show-errors="$showErrors"
    :multiple="$multiple"
    :min-selected="$minSelected"
    :max-selected="$maxSelected"
    :optional="$optional"
    :searchable="$searchable"
    :clearable="$clearable"
    :leading-addon="$leadingAddon"
    :leading-icon="$leadingIcon"
    :inline-addon="$inlineAddon"
    :trailing-addon="$trailingAddon"
    :extra-attributes="$extraAttributes"
    :always-open="$alwaysOpen"
    :clear-icon="$clearIcon"
    :option-selected-icon="$optionSelectedIcon"
    :placeholder="$placeholder"
    :button-icon="$buttonIcon"
    value-field="id"
    label-field="name"
    {{ $attributes }}
>
    {{-- slot is meant for passing in slotted addons --}}
    {{ $slot }}
</x-form-components::inputs.custom-select>
