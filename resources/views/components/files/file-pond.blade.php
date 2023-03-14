<div @class(['input-error' => $hasErrorsAndShow($name), 'cursor-not-allowed' => $disabled])>
    <div
        wire:ignore
        {{ $extraAttributes ?? '' }}
        x-data="filepond({
            @if ($hasWireModel())
                __this: @this,
                __wireModel: '{{ $attributes->wire('model')->value() }}',
                __value: @entangle($attributes->wire('model')),
            @elseif ($hasXModel())
                __value: {{ $attributes->first('x-model') }},
            @endif

            options: {{ \Illuminate\Support\Js::from($options()) }},

            __config(instance, options, pondOptions) {
                return { {{ $config ?? '' }} };
            },

            id: {{ \Illuminate\Support\Js::from($id) }},
        })"
        x-cloak
        x-on:file-pond-clear.window="__clear($event.detail.id)"

        @if ($hasXModel())
            {{ $attributes->whereStartsWith('x-model') }}
            x-modelable="__value"
        @endif
    >
        {{-- this input will be completely wiped away once we initialize filepond --}}
        <input
            x-ref="input"
            type="file"
            style="display: none;"
            @if ($name) name="{{ $name }}" @endif
            @if ($id) id="{{ $id }}" @endif

            {{ $attributes }}
        />
    </div>
</div>
