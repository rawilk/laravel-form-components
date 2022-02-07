<div x-data="{
        value: {{ \Illuminate\Support\Js::from($value) }},
        updateValue(newValue) {
            @this.set('value', newValue, {{ \Illuminate\Support\Js::from($defer) }});
            $dispatch('{{ \Illuminate\Support\Str::slug($name) }}-value-updated', newValue);
        },
    }"
     x-on:input.stop="updateValue($event.detail)"
     wire:ignore.self
>
    <x-form-components::inputs.custom-select
        x-model="value"
        :name="$name"
        :id="$selectId"
        :multiple="$multiple"
        :min-selected="$minSelected"
        :max-selected="$maxSelected"
        :disabled="$disabled"
        :searchable="$searchable"
        :close-on-select="$closeOnSelect"
        :autofocus="$autofocus"
        :optional="$optional"
        :clear-icon="$clearIcon"
        :placeholder="$placeholder"
        :no-options-text="$noOptionsText"
        :no-results-text="$noResultsText"
        :show-checkbox="$showCheckbox"
        :value-field="$valueField"
        :label-field="$labelField"
        :selected-label-field="$selectedLabelField"
        :disabled-field="$disabledField"
        :is-opt-group-field="$isOptGroupField"
        :extra-attributes="$extraAttributes"
        :show-errors="$showErrors"
        :livewire-search="$searchable ? 'handleSearch' : null"
    >
        @foreach ($options as $option)
            <x-form-components::inputs.custom-select-option
                :value="$this->optionValue($option)"
                :label="$this->optionLabel($option)"
                :selected-label="$this->optionSelectedLabel($option)"
                :disabled="$this->optionIsDisabled($option)"
                :is-opt-group="$this->optionIsOptGroup($option)"
            />
        @endforeach
    </x-form-components::inputs.custom-select>
</div>
