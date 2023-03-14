export default function (Alpine) {
    Alpine.data('quill', ({ __value, options, __config, onTextChange, onInit }) => {
        return {
            __ready: false,
            __value,
            __quill: undefined,

            init() {
                if (typeof window.Quill !== 'function') {
                    throw new Error(`quill requires Quill to be loaded. See https://quilljs.com/docs/installation/`);
                }

                queueMicrotask(() => {
                    this.__ready = true;

                    this.__quill = new window.Quill(this.$refs.quill, this.__quillOptions());

                    this.__quill.root.innerHTML = this.__value;

                    this.__quill.on('text-change', () => {
                        if (typeof onTextChange === 'function') {
                            const result = onTextChange(this);

                            if (result === false) {
                                return;
                            }
                        }

                        this.__value = this.__quill.root.innerHTML;

                        this.$dispatch('input', this.__value);
                    });

                    if (options.autofocus) {
                        this.$nextTick(() => {
                            this.focus();
                        });
                    }

                    if (typeof onInit === 'function') {
                        onInit(this);
                    }
                });
            },

            focus() {
                if (! this.__ready) {
                    return;
                }

                this.__quill.focus();
            },

            __quillOptions() {
                let config = __config(this, options);
                let toolbarHandlers = {};
                let modules = {};

                if (config.hasOwnProperty('toolbarHandlers')) {
                    toolbarHandlers = config.toolbarHandlers;
                    delete config.toolbarHandlers;
                }

                if (config.hasOwnProperty('modules')) {
                    modules = config.modules;
                    delete config.modules;
                }

                return {
                    theme: options.theme,
                    readOnly: options.readOnly,
                    placeholder: options.placeholder,
                    modules: {
                        toolbar: {
                            container: options.toolbar,
                            handlers: toolbarHandlers,
                        },
                        ...modules,
                    },
                    ...config,
                };
            },
        };
    });
}
