<div
    x-data="{
        @if ($defer)
            __wireValue: @entangle('value').defer,
        @else
            __wireValue: @entangle('value'),
        @endif
    }"
    wire:ignore.self
>
    <x-form-components::inputs.custom-select
        x-model="__wireValue"
        :name="$name"
        :id="$selectId"
        :show-errors="$showErrors"
        :multiple="$multiple"
        :size="$size"
        :value-field="$valueField"
        :label-field="$labelField"
        :selected-label-field="$selectedLabelField"
        :disabled-field="$disabledField"
        :children-field="$childrenField"
        :min-selected="$minSelected"
        :max-selected="$maxSelected"
        :optional="$optional"
        :button-icon="$buttonIcon"
        :searchable="$searchable"
        :livewire-search="$searchable ? 'handleSearch' : null"
        :clearable="$clearable"
        :clear-icon="$clearIcon"
        :option-selected-icon="$optionSelectedIcon"
        :placeholder="$placeholder"
        :no-results-text="$noResultsText"
        :no-options-text="$noOptionsText"
        :always-open="$alwaysOpen"
        :container-class="$containerClass"
        :extra-attributes="$extraAttributes"
        :leading-addon="$leadingAddon"
        :leading-icon="$leadingIcon"
        :inline-addon="$inlineAddon"
        :trailing-addon="$trailingAddon"
        :options="$options"
    />
</div>
