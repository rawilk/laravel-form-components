<div wire:ignore
     {{ $extraAttributes }}
     x-data="{ pond: null, wireId: null, @if ($shouldWatch($attributes)) value: @entangle($attributes->wire('model')), oldValue: undefined @endif }"
     x-cloak
     x-on:file-pond-clear.window="
         if (! this.wireId || $event.detail.id !== this.wireId) {
             return;
         }

         @if ($multiple)
            pond.getFiles().forEach(file => pond.removeFile(file.id));
         @else
            pond.removeFile();
         @endif
     "
     x-init="
     {{ $plugins ?? '' }}

    @if ($shouldWatch($attributes))
        $watch('value', value => {
            @if ($multiple)
                const removeOldFiles = (newValue, oldValue) => {
                    if (newValue.length < oldValue.length) {
                        const difference = oldValue.filter(i => ! newValue.includes(i));

                        difference.forEach(serverId => {
                            const file = pond.getFiles().find(f => f.serverId === serverId);

                            file && pond.removeFile(file.id);
                        });
                    }
                };

                if (this.oldValue !== undefined) {
                    try {
                        const files = Array.isArray(value) ? value : JSON.parse(String(value).split('livewire-files:')[1]);
                        const oldFiles = Array.isArray(this.oldValue) ? this.oldValue : JSON.parse(String(this.oldValue).split('livewire-files:')[1]);

                        if (Array.isArray(files) && Array.isArray(oldFiles)) {
                            removeOldFiles(files, oldFiles);
                        }
                    } catch (e) {}
                }

                this.oldValue = value;
            @else
                ! value && pond.removeFile();
            @endif
        });
    @endif

    $nextTick(function () {
        pond = FilePond.create($refs.input, {
            {{ $jsonOptions() }}
            @if ($attributes->hasStartsWith('wire:model'))
                server: {
                    process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                        @this.upload('{{ $attributes->wire('model')->value() }}', file, load, error, progress);
                    },
                    revert: (filename, load) => {
                        @this.removeUpload('{{ $attributes->wire('model')->value() }}', filename, load);
                    },
                },
            @endif
            {{ $optionsSlot ?? '' }}
        });
    });
    "
>
    <input x-ref="input"
           type="file"
           style="display: none;"
           @if ($accepts()) accept="{{ $accepts() }}" @endif

            @if ($hasErrorsAndShow($name))
               aria-invalid="true"
            @endif
           {{ $attributes->except('wire:model') }}
    />
</div>
