<x-custom-select :filterable="$filterable"
                 :optional="$optional"
                 :placeholder="$placeholder"
                 :multiple="$multiple"
                 :fixed-position="$fixedPosition"
                 :max-width="$maxWidth"
                 {{ $attributes }}
>
    {{ $slot }}

    @foreach (app('fc-timezone')->only($only)->all() as $region => $regionTimezones)
        <x-custom-select-option is-group>{{ $region }}</x-custom-select-option>

        @foreach ($regionTimezones as $key => $display)
            <x-custom-select-option wire:key="tz-{{ $key }}" :option="['value' => $key, 'text' => $display]" />
        @endforeach
    @endforeach
</x-custom-select>
