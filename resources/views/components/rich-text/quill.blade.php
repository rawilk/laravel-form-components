<div
    x-data="quill({
        @if ($hasWireModel())
            __value: @entangle($attributes->wire('model')),
        @elseif ($hasXModel())
            __value: {{ $attributes->first('x-model') }},
        @else
            __value: {{ \Illuminate\Support\Js::from($value) }},
        @endif

        options: {{ $options() }},

        __config(instance, quillOptions) {
            return { {{ $config ?? '' }} };
        },

        @isset($onTextChange)
            onTextChange(instance) {
                {{ $onTextChange }}
            },
        @endisset

        @isset($onInit)
            onInit(instance) {
                {{ $onInit }}
            },
        @endisset
    })"
    x-cloak
    @if ($id) id="{{ $id }}" @endif
    {{ $attributes->class($containerClass()) }}

    @if ($hasXModel())
        x-modelable="__value"
        {{ $attributes->whereStartsWith('x-model') }}
    @endif
>
    @if ($name)
        <input type="hidden" name="{{ $name }}" x-bind:value="__value">
    @endif

    <div
        @if ($hasWireModel()) wire:ignore @endif
        {{-- stop quills input event from bubbling up and conflicting with ours --}}
        {{-- our input event won't be stopped since it's dispatched from the root element --}}
        x-on:input.stop="() => {}"
    >
        <div x-ref="quill"></div>
    </div>
</div>
