export default {
    __createPopper: undefined,
    __popper: undefined,

    __resetPopper() {
        if (this.__popper) {
            this.__popper.destroy();
            this.__popper = null;
        }
    },

    __popperConfig() {
        return {
            placement: 'bottom-start',
            strategy: this.__fixed ? 'fixed' : 'absolute',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 10],
                    },
                },
                {
                    name: 'preventOverflow',
                    options: {
                        boundariesElement: this.$root,
                    },
                },
            ],
        };
    },

    __initPopper() {
        this.__resetPopper();
        this.__popper = this.__createPopper(this.$root, this.$refs.__options, this.__popperConfig());
    },
};
