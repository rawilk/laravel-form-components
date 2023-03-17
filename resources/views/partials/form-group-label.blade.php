@if ($label !== false || ! is_null($hint))
    <div @class([
        'form-group__label-container',
        'form-group__label-container--checkbox-group' => $isCheckboxGroup,
        'form-group__label-container--inline' => $inline,
        config('form-components.defaults.form_group.label_container_class'),
    ])>
        @unless ($label === false)
            <x-form-components::label
                :for="$inputId"
                x-form-group:label=""
            >
                {{ $label }}
            </x-form-components::label>
        @endunless

        @unless (is_null($hint))
            <span
                class="form-group__hint"
                @if ($inputId) id="{{ $inputId }}-hint" @endif
            >
                {{ $hint }}
            </span>
        @endunless
    </div>
@endif
