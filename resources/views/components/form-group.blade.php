<div {{ $attributes->merge(['class' => $groupClass()]) }}>
    @unless ($label === false)
        <x-dynamic-component :component="formComponentName('label')"
                             :for="$inputId"
                             class="{{ $inline && ! $isCheckboxGroup ? 'form-group__inline-label sm:mt-px sm:pt-2' : '' }}"
                             :id="$labelId"
        >
            {{ $label }}
        </x-dynamic-component>
    @endunless

    <div class="form-group__content mt-1 {{ $inline ? 'form-group__content--inline sm:mt-0 sm:col-span-2' : '' }}">
        {{ $slot }}

        @if ($hasErrorsAndShow($name))
            <x-dynamic-component :component="formComponentName('form-error')" :name="$name" :input-id="$inputId" />
        @endif

        @if ($helpText)
            <p class="form-help mt-2 text-sm text-blue-gray-500" id="{{ $inputId }}-description">{{ $helpText }}</p>
        @endif
    </div>
</div>
