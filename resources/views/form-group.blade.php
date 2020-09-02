<div {!! $attributes->merge(['class' => $groupClass()]) !!}>
    <x-form-label :label="$label"
                  :for="$labelFor"
                  class="{{ $inline && ! $isCheckbox ? 'sm:mt-px sm:pt-2' : '' }}"
    />

    <div class="mt-1 {{ $inline ? 'sm:mt-0 sm:col-span-2' : '' }}">
        {!! $slot !!}

        @if ($hasErrorAndShow($name))
            <x-form-errors :name="$name" />
        @endif

        @if ($helpText)
            <p class="form-help" id="{{ $name }}-description">{!! $helpText !!}</p>
        @endif
    </div>
</div>
