import selectMixins from '../mixins/select';

export default options => ({
    ...selectMixins,
    ...options,
    _componentName: 'tree-select',
    _focusableElementSelector: '.tree-select-option:not(.disabled):not(.select-no-results)',
    _optionElementSelector: '.tree-select-option:not(.select-no-results)',
    _topLevelOptionElementSelector: '.tree-select-option[data-level=":level"]:not(.select-no-results)',

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

    _doLocalSearch() {
        const options = this._getTopLevelOptionElements();
        const lowercaseSearch = this.search ? this.search.toLowerCase() : null;
        let matchCount = 0;

        const optionMatches = option => {
            let matches = true;
            if (lowercaseSearch) {
                try {
                    const value = option._x_dataStack[0].optionValue;
                    const label = option._x_dataStack[0].optionLabel;

                    matches = String(value).toLowerCase().includes(lowercaseSearch)
                        || String(label).toLowerCase().includes(lowercaseSearch);
                } catch (e) {}
            }

            // Check if any children match
            try {
                const level = option._x_dataStack[0].level;
                const children = [...option.querySelectorAll(this._levelOptionSelector(level + 1))];
                let childMatches = false;
                children.forEach(child => {
                    const childMatch = optionMatches(child);

                    if (childMatch) {
                        childMatches = true;
                    }
                });

                if (childMatches) {
                    matches = true;
                }
            } catch (e) {}

            if (matches) {
                matchCount++;
            }

            option.style.display = matches ? null : 'none';

            return matches;
        };

        options.forEach(o => optionMatches(o));

        const noResults = this.$refs.noResults;
        if (noResults) {
            noResults.style.display = matchCount === 0 ? null : 'none';
        }
    },

    _getTopLevelOptionElements() {
        return [...this.menu().querySelectorAll(this._levelOptionSelector(0))];
    },

    _levelOptionSelector(level) {
        return this._topLevelOptionElementSelector.replace(':level', level);
    }
});
