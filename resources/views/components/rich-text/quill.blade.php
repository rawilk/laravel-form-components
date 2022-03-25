<div x-data="quill({
         @if ($hasWireModel())
            value: @entangle($attributes->wire('model')),
         @elseif ($hasXModel())
            value: {{ $attributes->first('x-model') }},
         @else
            value: {{ \Illuminate\Support\Js::from($value) }},
         @endif
         ...{{ $options() }}
     })"
     x-cloak
     id="{{ $id }}"
     @class([
        'quill-wrapper',
        'has-error' => $hasErrorsAndShow($name),
     ])
>
    <input type="hidden" name="{{ $name }}" x-bind:value="value">
    <div @if ($hasWireModel()) wire:ignore @endif>
        <div x-ref="quill"></div>
    </div>
</div>
