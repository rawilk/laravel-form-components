<div @class([
    'form-group',
    'form-group--mb' => $marginBottom,
    'form-group--border' => $border && $inline,
])>
    <div wire:ignore.self x-data x-form-group>
        <div {{ $attributes->class($groupClass()) }}>
            @include('form-components::partials.form-group-label')

            <div @class([
                'form-group__content',
                'form-group__content--inline' => $inline,
                config('form-components.defaults.form_group.content_class'),
            ])>
                {{ $slot }}

                @if ($hasErrorsAndShow($name))
                    <x-form-components::form-error :name="$name" :input-id="$inputId" />
                @endif

                @if ($inline && $hint)
                    <span class="form-group__hint form-group__hint--inline"
                          @if ($inputId) id="{{ $inputId }}-hint-inline" @endif
                    >
                        {{ $hint }}
                    </span>
                @endif

                @if ($helpText)
                    <p class="form-help" @if ($inputId) id="{{ $inputId }}-description" @endif>{{ $helpText }}</p>
                @endif

                {{ $after ?? '' }}
            </div>
        </div>
    </div>
</div>
