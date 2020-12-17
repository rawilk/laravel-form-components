<x-custom-select :filterable="$filterable"
                 :optional="$optional"
                 :placeholder="$placeholder"
                 :multiple="$multiple"
                 :fixed-position="$fixedPosition"
                 :max-width="$maxWidth"
                 :options="$optionsForCustomSelect()"
                 :container-class="$containerClass"
                 {{ $attributes }}
/>
