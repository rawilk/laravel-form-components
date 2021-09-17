@if ($label !== false || ! is_null($hint))
    <div class="{{ is_null($hint) ? '' : 'flex justify-between' }}">
        @unless ($label === false)
            <x-form-components::label
                :for="$inputId"
                :id="$labelId"
                class="{{ $inline && ! $isCheckboxGroup ? 'form-group__inline-label sm:mt-px sm:pt-2' : '' }}"
            >
                {{ $label }}
            </x-form-components::label>
        @endunless

        @unless (is_null($hint))
            <span class="text-sm text-blue-gray-500 {{ $inline ? 'inline-block sm:hidden' : '' }}"
                  @if ($inputId) id="{{ $inputId }}-hint" @endif
            >
                {{ $hint }}
            </span>
        @endunless
    </div>
@endif
