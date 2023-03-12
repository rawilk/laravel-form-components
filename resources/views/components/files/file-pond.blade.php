<div @class(['input-error' => $hasErrorsAndShow($name), 'cursor-not-allowed' => $disabled])>
    <div
        wire:ignore
        {{ $extraAttributes ?? '' }}
        x-data="{{ $initFunctionName() }}({
            @if ($hasWireModel())
                _this: @this,
                wireModel: '{{ $attributes->wire('model')->value() }}',
                value: @entangle($attributes->wire('model')),
            @endif
            options: {{ \Illuminate\Support\Js::from($options()) }},
            id: {{ \Illuminate\Support\Js::from($id) }},
        })"
        x-cloak
        x-on:file-pond-clear.window="clear($event.detail.id)"
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

<script>
    window.{{ $initFunctionName() }} = function({ _this, wireModel, options, value, id }) {
        let pond;

        function clearFilepond(instance, allowMultiple) {
            if (allowMultiple) {
                instance.getFiles().forEach(file => instance.removeFile(file.id));
            } else {
                instance.removeFile();
            }
        }

        if (_this) {
            _this.on('file-pond-clear', () => {
                clearFilepond(pond, options.allowMultiple);
            });
        }

        return {
            files: value,

            processingFiles: false,

            clear(eventId) {
                if (! id || (eventId === id)) {
                    clearFilepond(pond, options.allowMultiple);
                }
            },

            init() {
                this.$nextTick(() => {
                    const pondOptions = { ...options };

                    if (_this && wireModel) {
                        pondOptions.server = {
                            process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                                _this.upload(wireModel, file, load, error, progress);
                            },
                            revert: (filename, load) => {
                                _this.removeUpload(wireModel, filename, load);
                            },
                        };

                        // To prevent our wire:model watcher from pre-maturely removing files from
                        // filepond, we need to tell our component we are still processing.
                        pondOptions.onaddfilestart = () => this.processingFiles = true;

                        pondOptions.onprocessfiles = () => this.processingFiles = false;
                    }

                    {{ $optionsSlot ?? '' }}

                    pond = FilePond.create(this.$refs.input, pondOptions);
                });

                if (_this && wireModel) {
                    this.$watch('files', newValue => {
                        if (options.allowMultiple) {
                            // If filepond is processing files, we shouldn't do anything.
                            if (this.processingFiles) {
                                return;
                            }

                            // If the new value is null or undefined, we'll just remove everything from filepond.
                            if (! newValue) {
                                clearFilepond(pond, true);

                                return;
                            }

                            // Remove files from filepond that are not present in the new value.
                            const serverIds = Array.isArray(newValue) ? newValue : JSON.parse(String(newValue).split('livewire-files:')[1]);

                            pond.getFiles().forEach(f => {
                                if (! serverIds.includes(f.serverId)) {
                                    pond.removeFile(f.id);
                                }
                            });

                            return;
                        }

                        if (! newValue) {
                            clearFilepond(pond, false);
                        }
                    });
                }
            }
        };
    };
</script>
