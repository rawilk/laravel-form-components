<div {{ $attributes->class($groupClass()) }}>
    @include('form-components::partials.form-group-label')

    <div @class([
        'form-group__content mt-1',
        'form-group__content--inline sm:mt-0 sm:col-span-2' => $inline,
    ])
    >
        {{ $slot }}

        @if ($hasErrorsAndShow($name))
            <x-form-components::form-error :name="$name" :input-id="$inputId" />
        @endif

        @if ($inline && $hint)
            <span class="text-sm mt-1 text-slate-500 hidden sm:block"
                  @if ($inputId) id="{{ $inputId }}-hint-inline" @endif
            >
                {{ $hint }}
            </span>
        @endif

        @if ($helpText)
            <p class="form-help mt-2 text-sm text-slate-500" id="{{ $inputId }}-description">{{ $helpText }}</p>
        @endif
    </div>
</div>
