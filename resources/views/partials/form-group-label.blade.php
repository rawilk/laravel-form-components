@if ($label !== false || ! is_null($hint))
    <div @class(['flex justify-between' => ! is_null($hint)])>
        @unless ($label === false)
            <x-form-components::label
                :for="$inputId"
                :id="$labelId"
                :custom-select-label="$customSelectLabel"
                class="{{ $inline && ! $isCheckboxGroup ? 'form-group__inline-label sm:mt-px sm:pt-2' : '' }}"
            >
                {{ $label }}
            </x-form-components::label>
        @endunless

        @unless (is_null($hint))
            <span @class([
                'text-sm text-slate-500',
                'inline-block sm:hidden' => $inline,
            ])
            @if ($inputId) id="{{ $inputId }}-hint" @endif
            >
                {{ $hint }}
            </span>
        @endunless
    </div>
@endif
