import selectMixins from '../mixins/select';

export default options => ({
    ...selectMixins,
    ...options,
    _componentName: 'custom-select',
    _focusableElementSelector: '.custom-select-option:not(.disabled):not(.select-no-results):not(.custom-select-option--opt-group)',
    _optionElementSelector: '.custom-select-option:not(.select-no-results):not(.custom-select-option--opt-group)',

    get hasValue() {
        return this.multiple
            ? this.value.length > 0
            : this.value !== '' && this.value !== null;
    },

    get hasValueAndCanClear() {
        if (! this.optional) {
            return false;
        }

        if (this.disabled) {
            return false;
        }

        return this.hasValue;
    },

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

    init() {
        this._initSelect();
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

    selectOption(option) {
        if (this.disabled) {
            return;
        }

        try {
            option._x_dataStack[0].toggle({ parentMenu: this });
        } catch (e) {}
    },
});
