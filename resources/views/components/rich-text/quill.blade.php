<div
    x-data="{{ $initFunctionName() }}({
        @if ($hasWireModel())
            value: @entangle($attributes->wire('model')),
        @elseif ($hasXModel())
            value: {{ $attributes->first('x-model') }},
        @else
            value: {{ \Illuminate\Support\Js::from($value) }},
        @endif
        options: {{ $options() }},
    })"
    x-cloak
    @if ($id) id="{{ $id }}" @endif
    {{ $attributes->class($containerClass()) }}

    @if ($hasXModel())
        x-modelable="content"
        {{ $attributes->whereStartsWith('x-model') }}
    @endif
>
    @if ($name)
        <input type="hidden" name="{{ $name }}" x-bind:value="value">
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

<script>
    window.{{ $initFunctionName() }} = function ({ value, options }) {
        let quill;

        function quillOptions() {
            const quillOptions = {
                theme: options.theme,
                readOnly: options.readOnly,
                placeholder: options.placeholder,
                modules: {
                    toolbar: {
                        container: options.toolbar,
                        handlers: {},
                    },
                },
            };

            {{ $config ?? '' }}

            return quillOptions;
        }

        return {
            value,

            init() {
                if (typeof Quill !== 'function') {
                    throw new TypeError(`Quill Editor requires Quill (https://quilljs.com)`);
                }

                quill = new Quill(this.$refs.quill, quillOptions());

                quill.root.innerHTML = this.value;

                quill.on('text-change', () => {
                    {{ $onTextChange ?? '' }}

                    this.value = quill.root.innerHTML;

                    this.$dispatch('input', this.value);
                });

                if (options.autofocus) {
                    this.$nextTick(() => quill.focus());
                }

                {{ $init ?? '' }}
            },
        };
    };
</script>
