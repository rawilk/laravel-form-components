// Common functionality needed across custom selects.
let createPopper;

export default {
    open: false,
    disabled: false,
    fixed: false,
    optional: false,
    searchable: true,
    closeOnSelect: false,
    multiple: false,
    placeholder: null,
    valuePlaceholder: null,
    search: '',
    value: null,
    focusedOptionIndex: -1,
    focusableElements: null,
    autofocus: false,
    minSelected: 1,
    maxSelected: null,
    _wire: null,
    _root: null,
    _popper: null,
    _componentName: '',
    _focusableElementSelector: '',
    _optionElementSelector: '',
    _wireToggleMethod: '',

    menu() {
        if (! this.$refs.menu) {
            return this._root.querySelector('[x-ref="menu"]');
        }

        return this.$refs.menu;
    },

    searchInput() {
        if (! this.$refs.search) {
            return this._root.querySelector('[x-ref="search"]');
        }

        return this.$refs.search;
    },

    _closeMenu() {
        this.search = '';
        this.focusableElements = null;
        this.open = false;
        this._resetPopper();
    },

    openMenu() {
        if (this.disabled) {
            return;
        }

        this._initPopper();
        this.open = true;
        this._focusSearch();
        this._focusSelectedOption();
    },

    onBackspace() {
        if (this.disabled || this.search || ! this._wire) {
            return;
        }

        try {
            this._wire.handleBackspace();
        } catch (e) {}
    },

    onEnter() {
        if (! this.open) {
            return this.openMenu();
        }

        if (this.focusedOptionIndex < 0) {
            return;
        }

        const elements = this._getFocusableElements();

        if (elements.length) {
            this.selectOption(elements[this.focusedOptionIndex]);
        }
    },

    onTab() {
        if (this.disabled || ! this.open) {
            return;
        }

        this.closeMenu({ focusRoot: false });
    },

    onValueChanged(event) {
        try {
            this.valuePlaceholder = event.detail.label;
        } catch (e) {}

        if (! this.closeOnSelect && this.open) {
            this._initPopper();
            this._focusSearch();

            return;
        }

        if (this.closeOnSelect) {
            this._handleCloseOnSelect();
        }
    },

    focusNextOption() {
        if (this.disabled) {
            return;
        }

        if (! this.open) {
            return this.openMenu();
        }

        const elements = this._getFocusableElements();
        if (! elements.length) {
            return this.focusedOptionIndex = -1;
        }

        this.focusedOptionIndex++;
        if (this.focusedOptionIndex + 1 > elements.length) {
            this.focusedOptionIndex = 0;
        }

        this._focusOption(elements[this.focusedOptionIndex]);
    },

    focusPreviousOption() {
        if (this.disabled) {
            return;
        }

        if (! this.open) {
            return this.openMenu();
        }

        const elements = this._getFocusableElements();
        if (! elements.length) {
            return this.focusedOptionIndex = -1;
        }

        this.focusedOptionIndex--;
        if (this.focusedOptionIndex < 0) {
            this.focusedOptionIndex = elements.length - 1;
        }

        this._focusOption(elements[this.focusedOptionIndex], { block: 'start' });
    },

    focusFirstOption() {
        if (this.disabled) {
            return;
        }

        const elements = this._getFocusableElements();
        if (! elements.length) {
            return this.focusedOptionIndex = -1;
        }

        this.focusedOptionIndex = 0;

        this._focusOption(elements[this.focusedOptionIndex], { block: 'start' });
    },

    focusLastOption() {
        if (this.disabled) {
            return;
        }

        const elements = this._getFocusableElements();
        if (! elements.length) {
            return this.focusedOptionIndex = -1;
        }

        this.focusedOptionIndex = elements.length - 1;

        this._focusOption(elements[this.focusedOptionIndex], { block: 'end' });
    },

    updateFocusedOptionIndexFromElement(el) {
        const elements = this._getFocusableElements();

        if (elements.length) {
            this.focusedOptionIndex = elements.findIndex(other => other.isEqualNode(el));
        }
    },

    canToggleOption(value) {
        if (this.disabled) {
            return false;
        }

        const isSelected = this._isValueSelected(value);

        if (this.multiple) {
            if (isSelected && this.value.length <= this.minSelected) {
                return false;
            }

            if (! isSelected && ! this._canSelectAnotherOption()) {
                return false;
            }

            return true;
        }

        if (isSelected && ! this.optional) {
            return false;
        }

        return true;
    },

    _canSelectAnotherOption() {
        if (this.maxSelected === null) {
            return true;
        }

        return this.value.length < this.maxSelected;
    },

    _isValueSelected(value) {
        const stringValue = String(value);

        if (this.multiple) {
            return this.value.some(v => String(v) === stringValue);
        }

        return stringValue === String(this.value);
    },

    _focusOption(option, options = {}) {
        try {
            option._x_dataStack[0].focus({ parent: this, ...options });
        } catch (e) {}
    },

    _focusRoot() {
        if (! this.disabled) {
            setTimeout(() => this._root.focus(), 50);
        }
    },

    _focusSearch() {
        if (! this.searchable) {
            return;
        }

        try {
            setTimeout(() => this.searchInput().focus(), 50);
        } catch (e) {}
    },

    _focusSelectedOption() {
        const firstValue = this.multiple ? String(this.value[0]) : String(this.value);
        if (! firstValue) {
            return;
        }

        const focusableElements = this._getFocusableElements();
        if (! focusableElements.length) {
            return;
        }

        const option = focusableElements.find(o => {
            try {
                return String(o._x_dataStack[0].optionValue) === firstValue;
            } catch (e) {}
        });

        if (option) {
            setTimeout(() => this._focusOption(option), 50);
        }
    },

    _getAllOptionElements() {
        return [...this.menu().querySelectorAll(this._optionElementSelector)];
    },

    _getFocusableElements() {
        if (this.focusableElements !== null) {
            return this.focusableElements;
        }

        return this.focusableElements = [...this.menu().querySelectorAll(this._focusableElementSelector)]
            .filter(el => el.offsetParent !== null); // Ensure option is visible
    },

    _handleCloseOnSelect() {
        if (! this.multiple || this.maxSelected === null) {
            return this.closeMenu();
        }

        if (this.value.length >= this.maxSelected) {
            this.closeMenu();
        }
    },

    _initPopper() {
        this._resetPopper();

        this._popper = createPopper(this._root, this.menu(), this._popperConfig());
    },

    _initSelect() {
        this._root = this.$root;

        createPopper = window.Popper ? window.Popper.createPopper : window.createPopper;

        if (typeof createPopper !== 'function') {
            throw new TypeError(`<${this._componentName}> requires Popper (https://popper.js.org)`);
        }

        if (this.autofocus) {
            this._focusRoot();
        }

        if (this.searchable) {
            this.$watch('search', () => this.focusableElements = null);
        }
    },

    _popperConfig() {
        return {
            placement: 'bottom-start',
            strategy: this.fixed ? 'fixed' : 'absolute',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 0],
                    },
                },
                {
                    name: 'preventOverflow',
                    options: {
                        boundariesElement: this._root,
                    },
                },
            ],
        };
    },

    _resetPopper() {
        if (this._popper) {
            this._popper.destroy();
            this._popper = null;
        }
    },
};
