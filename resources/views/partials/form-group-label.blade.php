@if ($label !== false || ! is_null($hint))
    <div class="{{ is_null($hint) ? '' : 'flex justify-between' }}">
        @unless ($label === false)
            <x-dynamic-component :component="formComponentName('label')"
                                 :for="$inputId"
                                 class="{{ $inline && ! $isCheckboxGroup ? 'form-group__inline-label sm:mt-px sm:pt-2' : '' }}"
                                 :id="$labelId"
            >
                {{ $label }}
            </x-dynamic-component>
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
