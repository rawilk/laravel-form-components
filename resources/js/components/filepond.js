export default function (Alpine) {
    Alpine.data('filepond', ({ __value, __this, __wireModel, options, __config, id }) => {
        return {
            __ready: false,
            __pond: null,
            __processingFiles: false,
            __value,

            init() {
                if (typeof window.FilePond?.create !== 'function') {
                    throw new Error(`filepond requires FilePond to be loaded. See https://pqina.nl/filepond/docs/getting-started/installation/javascript/`);
                }

                queueMicrotask(() => {
                    this.__ready = true;

                    let pondOptions = { ...options };

                    if (__this && __wireModel) {
                        pondOptions.server = {
                            process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                                __this.upload(__wireModel, file, load, error, progress);
                            },
                            revert: (filename, load) => {
                                __this.removeUpload(__wireModel, filename, load);
                            },
                        };

                        // To prevent our wire:model watcher from pre-maturely removing files from
                        // filepond, we need to tell our component we are still processing.
                        pondOptions.onaddfilestart = () => this.__processingFiles = true;

                        pondOptions.onprocessfiles = () => this.__processingFiles = false;
                    }

                    if (__this) {
                        // Listen for livewire components to emit a file-pond-clear event.
                        __this.on('file-pond-clear', (desiredId) => this.__clear(desiredId));
                    }

                    pondOptions = { ...pondOptions, ...__config(this, options, pondOptions) };

                    this.__pond = window.FilePond.create(this.$refs.input, pondOptions);
                });

                this.$watch('__value', newValue => {
                    if (! this.__ready) {
                        return;
                    }

                    if (options.allowMultiple) {
                        // If filepond is processing files, we shouldn't do anything.
                        if (this.__processingFiles) {
                            return;
                        }

                        // If the new value is null or undefined, we'll just remove everything from filepond.
                        if (! newValue) {
                            return this.__clear();
                        }

                        // Remove files from filepond that are not present in the new value.
                        const serverIds = Array.isArray(newValue) ? newValue : JSON.parse(String(newValue).split('livewire-files:')[1]);

                        this.__pond.getFiles().forEach(f => {
                            if (! serverIds.includes(f.serverId)) {
                                this.__pond.removeFile(f.id);
                            }
                        });

                        return;
                    }

                    if (! newValue) {
                        this.__clear();
                    }
                });
            },

            __clear(eventId) {
                if (! eventId || (eventId === id)) {
                    clearFilepond(this.__pond, options.allowMultiple);
                }
            },
        };
    });
}

function clearFilepond(instance, allowMultiple) {
    if (allowMultiple) {
        instance.getFiles().forEach(file => instance.removeFile(file.id));
    } else {
        instance.removeFile();
    }
}
