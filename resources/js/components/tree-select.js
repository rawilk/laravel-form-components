import selectMixins from '../mixins/select';

export default options => ({
    ...selectMixins,
    ...options,
    _componentName: 'tree-select',
    _focusableElementSelector: '.tree-select-option:not(.disabled)',
    _optionElementSelector: '.tree-select-option',
    _wireToggleMethod: 'toggleOption',
    _focusedOptionId: null,

    get searchPlaceholder() {
        if (this.multiple) {
            if (! Array.isArray(this.value)) {
                return this.placeholder;
            }

            return this.value.length
                ? null
                : this.placeholder;
        }

        return this.value !== '' && this.value !== null
            ? this.valuePlaceholder
            : this.placeholder;
    },

    get showSearchInput() {
        if (this.multiple) {
            return true;
        }

        return this.open;
    },

    get ariaActiveDescendant() {
        if (this.focusedOptionIndex < 0 || ! this._focusedOptionId) {
            return null;
        }

        const elements = this._getAllOptionElements();
        if (! elements.length) {
            return null;
        }

        const option = elements.find(o => {
            try {
                return o._x_dataStack[0]._id === this._focusedOptionId;
            } catch (e) {}
        });

        return option ? option._x_dataStack[0]._optionIndex : null;
    },

    init() {
        this._initSelect();

        if (this.searchable && this._wire) {
            this.$watch('search', newValue => {
                try {
                    this._wire.handleSearch(newValue);
                } catch (e) {}
            });
        }
    },

    closeMenu(options = { focusRoot: true }) {
        if (! this.open) {
            return;
        }

        this._closeMenu();

        const focusRoot = options.focusRoot !== false;

        if (focusRoot) {
            this._focusRoot();
        }
    },

    onArrowRight(event) {
        if (! this.open || this.focusedOptionIndex < 0) {
            return;
        }

        const option = this._getFocusableElements()[this.focusedOptionIndex];

        try {
            const wasExpanded = option._x_dataStack[0].expand();

            if (wasExpanded) {
                event.preventDefault();
            }
        } catch (e) {}
    },

    onArrowLeft(event) {
        if (! this.open || this.focusedOptionIndex < 0) {
            return;
        }

        const option = this._getFocusableElements()[this.focusedOptionIndex];

        try {
            const wasCollapsed = option._x_dataStack[0].collapse({ parent: this });

            if (wasCollapsed === true) {
                event.preventDefault();
            }
        } catch (e) {}
    },

    selectOption(option) {
        if (this.disabled) {
            return;
        }

        try {
            option._x_dataStack[0].toggle({ parentMenu: this });
        } catch (e) {}
    },
});
