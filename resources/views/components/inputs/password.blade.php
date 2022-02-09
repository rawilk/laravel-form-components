<div @if ($showToggle)
        x-data="{ show: false }"
     @endif
     class="{{ $containerClass() }}"
>
    @include('form-components::partials.leading-addons')

    <input
        {{ $attributes->merge(['class' => $inputClass()]) }}
        {!! $ariaDescribedBy() !!}
        {{ $extraAttributes }}

        @if ($name) name="{{ $name }}" @endif
        @if ($id) id="{{ $id }}" @endif

        @if ($showToggle)
            x-bind:type="show ? 'text' : 'password'"
        @else
            type="password"
        @endif

        @if ($value && ! $hasBoundModel()) value="{{ $value }}" @endif

        @if ($hasErrorsAndShow($name))
            aria-invalid="true"
        @endif
    />

    @if ($showToggle)
        <div x-on:click="show = ! show"
             x-bind:title="show ? '{{ __('form-components::messages.password_hide_toggle_title') }}' : '{{ __('form-components::messages.password_show_toggle_title') }}'"
             @class([
                'trailing-icon password-toggle clickable',
                'pr-3 flex items-center bg-white border rounded-md rounded-l-none border-l-0',
                'border-red-300' => $hasErrorsAndShow($name),
                'border-slate-300 group-focus:border-blue-300' => ! $hasErrorsAndShow($name),
             ])
             x-cloak
        >
            <span x-show="! show" class="h-5 w-5 text-slate-400">
                <x-dynamic-component :component="$showPasswordIcon" />
            </span>

            <span x-show="show" class="h-5 w-5 text-slate-400">
                <x-dynamic-component :component="$hidePasswordIcon" />
            </span>
        </div>
    @endif
</div>
