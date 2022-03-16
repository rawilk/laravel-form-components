// Common functionality needed across custom selects.
import { isArray, isObject } from '../util/inspect';

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
    valueLabel: null,
    initialLabel: null,
    focusedOptionIndex: -1,
    focusableElements: null,
    autofocus: false,
    minSelected: 1,
    maxSelected: null,
    selectedOptions: [],
    livewireSearch: null,
    _wire: null,
    _root: null,
    _popper: null,
    _componentName: '',
    _focusableElementSelector: '',
    _optionElementSelector: '',
    _wireToggleMethod: '',
    _focusedOptionId: null,
    _noCloseOnSelect: false, // flag we can set for certain actions that shouldn't close the menu
    _wireModelName: null,

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
        if (! this.open || this.disabled || this.search) {
            return;
        }

        const value = this.multiple
            ? this.value[this.value.length - 1]
            : this.value;

        if (value) {
            this._noCloseOnSelect = true;
            this.toggleOptionByValue(value);
        }
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

            try {
                this._focusedOptionId = el._x_dataStack[0]._id;
            } catch (e) {}
        }
    },

    canToggleOption(value) {
        if (this.disabled) {
            return false;
        }

        const isSelected = this._isValueSelected(value);

        if (this.multiple) {
            if (isSelected && this.value.length <= this.minSelected) {
                return this.optional;
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

    clearValue() {
        if (this.disabled) {
            return;
        }

        if (! this.optional) {
            return;
        }

        this.value = this.multiple ? [] : null;
        this.valueLabel = null;
    },

    toggleOption(option) {
        if (this.disabled) {
            return;
        }

        if (this.multiple) {
            this._toggleMultiSelectOption(option);
        } else {
            this._toggleSingleSelectOption(option);
        }
    },

    toggleOptionByValue(value) {
        let option = this._getOptionByValue(value);
        if (option) {
            option = option._x_dataStack[0];
        } else {
            option = { optionValue: value };
        }

        return this.toggleOption(option);
    },

    setNewValue(newValue) {
        if (this.multiple) {
            this.value = [];
            this.selectedOptions = [];

            newValue.forEach(value => this.toggleOptionByValue(value));

            return;
        }

        // When emitting `null` values from php, sometimes it comes through as an object,
        // so we'll "fix" it here.
        if (isObject(newValue)) {
            newValue = null;
        }

        this.value = newValue;
    },

    handleValueChange() {
        if (! this.closeOnSelect && this.open) {
            this._initPopper();
            this._focusSearch();

            return;
        }

        if (this.closeOnSelect && this.open) {
            this._handleCloseOnSelect();
        }
    },

    labelForValue(value) {
        const option = this.selectedOptions.find(o => String(o.optionValue) === String(value));

        if (! option) {
            return value;
        }

        return option.optionSelectedLabel ? option.optionSelectedLabel : option.optionLabel;
    },

    _toggleMultiSelectOption(option) {
        const value = option.optionValue;
        let newValue = [...this.value];

        if (this._isValueSelected(value) && this._canDeSelectAnOption()) {
            newValue.splice(newValue.indexOf(value), 1);
            this.selectedOptions.splice(
                this.selectedOptions.findIndex(o => String(o.optionValue) === String(value)),
                1
            );
        } else if (! this._isValueSelected(value) && this._canSelectAnotherOption()) {
            newValue.push(value);
            this.selectedOptions.push(option);
        }

        this.value = newValue;
    },

    _toggleSingleSelectOption(option) {
        const optionValue = typeof option === 'object' ? option.optionValue : option;
        this.value = this._isValueSelected(optionValue)
            ? null
            : optionValue;
    },

    _canDeSelectAnOption() {
        if (this.optional) {
            return true;
        }

        return this.value.length > this.minSelected;
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
            // In certain edge cases, `this.value` may not be an array, so
            // we'll force it to be one if it's not here.
            const value = isArray(this.value) ? this.value : [];

            return value.some(v => String(v) === stringValue);
        }

        return stringValue === String(this.value);
    },

    _focusOption(option, options = {}) {
        try {
            option._x_dataStack[0].focus({ parent: this, ...options });
            this.updateFocusedOptionIndexFromElement(option);
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

        const option = this._getOptionByValue(firstValue);

        if (option && ! option.optionDisabled) {
            setTimeout(() => this._focusOption(option), 50);
        }
    },

    _getOptionByValue(value) {
        const focusableElements = this._getAllOptionElements();
        if (! focusableElements.length) {
            return null;
        }

        return focusableElements.find(o => {
            try {
                return String(o._x_dataStack[0].optionValue) === String(value);
            } catch (e) {}
        });
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
        if (this._shouldCloseOnSelect()) {
            this.closeMenu();
        }
    },

    _handleSearch() {
        this.focusableElements = null;

        if (this.livewireSearch && this._wire) {
            try {
                this._wire[this.livewireSearch](this.search);
            } catch (e) {}

            return;
        }

        this._doLocalSearch();
    },

    _doLocalSearch() {
        const options = this._getAllOptionElements();
        const lowercaseSearch = this.search ? this.search.toLowerCase() : null;
        let matchCount = 0;
        options.forEach(o => {
            let matches = true;
            if (lowercaseSearch) {
                try {
                    const optionValue = o._x_dataStack[0].optionValue;
                    const label = o._x_dataStack[0].optionLabel;

                    matches = String(optionValue).toLowerCase().includes(lowercaseSearch)
                        || String(label).toLowerCase().includes(lowercaseSearch);
                } catch (e) {}
            }

            if (matches) {
                matchCount++;
            }

            o.style.display = matches ? null : 'none';
        });

        const noResults = this.$refs.noResults;
        if (noResults) {
            noResults.style.display = matchCount === 0 ? null : 'none';
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
            this.$watch('search', () => this._handleSearch());
        }

        if (! this.multiple && this.value && ! this.initialLabel) {
            this._determineInitialLabel();
        }

        if (this.initialLabel) {
            this.valueLabel = this.initialLabel;
            this.valuePlaceholder = this.initialLabel;
        }

        if (this.multiple) {
            this.$nextTick(() => {
                this.selectedOptions = [...this.value].map(v => this._getOptionByValue(v)._x_dataStack[0]);
            });
        }

        this.$watch('value', (newValue, oldValue) => {
            // Possible bug: When livewire components are updated, the watcher
            // gets triggered again, even if the new and old values are the same,
            // so we want to prevent our handlers from running in those cases...
            if (JSON.stringify(newValue) === JSON.stringify(oldValue)) {
                return;
            }

            this._updateSelectedOption(newValue);
            this.handleValueChange();

            this.$dispatch('input', newValue);

            // For some reason when using a wire:model.defer, livewire is not
            // sending null values back to the server for updates, so we will
            // force it to here...
            if (newValue === null && this._wire && this._wireModelName) {
                this._wire.set(this._wireModelName, null, true);
            }
        });
    },

    _updateSelectedOption(newValue) {
        if (this.multiple) {
            return;
        }

        if (! newValue) {
            this.valueLabel = this.placeholder;
        }

        const option = this._getOptionByValue(newValue);

        if (option) {
            try {
                this.valueLabel = option._x_dataStack[0].optionSelectedLabel;
                this.valuePlaceholder = option._x_dataStack[0].optionLabel;
            } catch (e) {}
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

    _determineInitialLabel() {
        this.$nextTick(() => {
            const option = this._getOptionByValue(this.value);

            if (option) {
                try {
                    this.initialLabel = option._x_dataStack[0].optionSelectedLabel;

                    this.valueLabel = this.initialLabel;
                    this.valuePlaceholder = this.initialLabel;

                    return;
                } catch (e) {}
            }

            this.initialLabel = this.value;
            this.valueLabel = this.initialLabel;
            this.valuePlaceholder = this.initialLabel;
        });
    },

    _shouldCloseOnSelect() {
        if (this._noCloseOnSelect) {
            this._noCloseOnSelect = false;

            return false;
        }

        if (! this.closeOnSelect) {
            return false;
        }

        if (this.multiple) {
            return this.maxSelected === null
                ? this.value.length >= this.minSelected
                : this.value.length >= this.maxSelected;
        }

        return true;
    },
};
