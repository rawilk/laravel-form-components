<div {{ $attributes->merge(['class' => $groupClass()]) }}>
    @unless ($label === false)
        <x-dynamic-component :component="formComponentName('label')"
                             :for="$inputId"
                             class="{{ $inline && ! $isCheckboxGroup ? 'form-group__inline-label' : '' }}"
                             :id="$labelId"
        >
            {{ $label }}
        </x-dynamic-component>
    @endunless

    <div class="form-group__content {{ $inline ? 'form-group__content--inline' : '' }}">
        {{ $slot }}

        @if ($hasErrorsAndShow($name))
            <x-dynamic-component :component="formComponentName('form-error')" :name="$name" :input-id="$inputId" />
        @endif

        @if ($helpText)
            <p class="form-help" id="{{ $inputId }}-description">{{ $helpText }}</p>
        @endif
    </div>
</div>
