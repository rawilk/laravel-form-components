<x-form-components::inputs.custom-select
    :filterable="$filterable"
    :optional="$optional"
    :placeholder="$placeholder"
    :multiple="$multiple"
    :max-width="$maxWidth"
    :options="$optionsForCustomSelect()"
    :container-class="$containerClass"
    :extra-attributes="$extraAttributes"
    {{ $attributes }}
/>
