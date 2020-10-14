<div wire:ignore
     x-data
     x-cloak
     x-init="
        {{ $plugins ?? '' }}
        FilePond.setOptions({
            {{ $jsonOptions() }}
            {{-- Enhance for livewire support --}}
            @if ($attributes->whereStartsWith('wire:model')->first())
                server: {
                    process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                        @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress);
                    },
                    revert: (filename, load) => {
                        @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load);
                    },
                },
            @endif
            {{ $optionsSlot ?? '' }}
        });
        FilePond.create($refs.input);
    "
>
    <input x-ref="input"
           type="file"
           style="display:none;"
           @if ($accepts()) accept="{{ $accepts() }}" @endif
           {{ $attributes->except('wire:model') }}
    />
</div>
