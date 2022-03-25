export default options => ({
    autofocus: false,
    value: '',
    theme: 'snow',
    readOnly: false,
    placeholder: null,
    toolbar: {},
    toolbarHandlers: {},
    ...options,
    _quill: null,

    init() {
        if (typeof Quill !== 'function') {
            throw new TypeError(`Quill Editor requires Quill (https://quilljs.com)`);
        }

        this._quill = new Quill(this.$refs.quill, this._quillOptions());

        this._quill.root.innerHTML = this.value;

        this._quill.on('text-change', () => {
            this.value = this._quill.root.innerHTML;

            this.$dispatch('quill-input', this.value);
        });

        if (this.autofocus) {
            this.$nextTick(() => this._quill.focus());
        }
    },

    _quillOptions() {
        const toolbarHandlers = this.toolbarHandlers;
        if (toolbarHandlers !== null) {
            Object.keys(toolbarHandlers).forEach(key => {
                toolbarHandlers[key] = new Function('value', toolbarHandlers[key]);
            });
        }

        return {
            theme: this.theme,
            readOnly: this.readOnly,
            placeholder: this.placeholder,
            modules: {
                toolbar: {
                    container: this.toolbar,
                    handlers: toolbarHandlers || {},
                },
            },
        };
    }
});
