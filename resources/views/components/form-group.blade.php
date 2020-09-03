<div {{ $attributes->merge(['class' => $groupClass()]) }}>
    <x-label :for="$inputId"
             class="{{ $inline && ! $isCheckboxGroup ? 'sm:mt-px sm:pt-2' : '' }}"
    >
        {{ $label }}
    </x-label>

    <div class="mt-1 {{ $inline ? 'sm:mt-0 sm:col-span-2' : '' }}">
        {{ $slot }}

        @if ($hasErrorsAndShow($name))
            <x-form-error :name="$name" :input-id="$inputId" />
        @endif

        @if ($helpText)
            <p class="form-help" id="{{ $inputId }}-description">{{ $helpText }}</p>
        @endif
    </div>
</div>
