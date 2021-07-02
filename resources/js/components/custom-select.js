/*
 * Custom Select Component Definition.
 *
 * Note: Not using polyfills for functions such as Array.from()
 * since I use Livewire, and Livewire already includes polyfills
 * for those functions. If you don't use Livewire, you should
 * make sure are pulling in those polyfills.
 */

import findLastIndex from '../util/findLastIndex';
import { normalizeOptions } from '../util/options';
import { isArray } from '../util/inspect';

let createPopper;

export default (config) => ({
    focusedOptionIndex: null,
    filterable: false,
    data: [],
    disabled: false,
    options: [],
    open: false,
    search: '',
    wireFilter: false,
    wireListeners: [],
    value: '',
    selectedOption: null, // for storing a selected option in case a "wire:filter" removes the option from the list...
    max: false,
    selectId: '',
    valueField: 'value',
    textField: 'text',
    disabledField: 'disabled',
    labelField: 'label', // used for an "optgroup"'s label
    optionsField: 'options', // used when creating "optgroups"
    popper: null,
    ...config,

    get buttonDisplay() {
        if (this.multiple) {
            let optionDisplay = this.optionDisplay(this.value[0]);

            if (this.value.length > 1) {
                optionDisplay += ` <span class="custom-select__select-count">+ ${this.value.length - 1}</span>`;
            }

            return optionDisplay;
        }

        return this.optionDisplay(this.value);
    },

    get fieldNames() {
        return {
            valueField: this.valueField,
            textField: this.textField,
            disabledField: this.disabledField,
            labelField: this.labelField,
            optionsField: this.optionsField,
        };
    },

    close() {
        this.open = false;
        this.focusedOptionIndex = null;
        this.search = '';

        if (this.popper) {
            this.popper.destroy();
            this.popper = null;
        }
    },

    clear() {
        this.value = this.multiple ? [] : null;

        if (this.open) {
            this.close();
            this.focusButton();
        }
    },

    focusButton() {
        this.$nextTick(() => this.$refs.button.focus());
    },

    focusNextOption() {
        if (this.focusedOptionIndex === null) {
            this.focusedOptionIndex = -1;
        }

        let nextIndex = this.options.findIndex((o, index) => index > this.focusedOptionIndex && ! o.disabled && ! this.isOptgroup(o));
        if (nextIndex === -1 || (nextIndex + 1) > this.options.length) {
            nextIndex = this.options.findIndex(o => ! o.disabled && ! this.isOptgroup(o));
        }

        this.focusedOptionIndex = nextIndex;

        this.scrollToOption(this.focusedOptionIndex);
    },

    focusPreviousOption() {
        if (this.focusedOptionIndex === null) {
            this.focusedOptionIndex = this.options.length - 1;
        }

        let previousIndex = findLastIndex(this.options, (o, index) => index < this.focusedOptionIndex && ! o.disabled && ! this.isOptgroup(o));
        if (previousIndex < 0) {
            previousIndex = findLastIndex(this.options, o => ! o.disabled && ! this.isOptgroup(o));
        }

        this.focusedOptionIndex = previousIndex;

        this.scrollToOption(this.focusedOptionIndex);
    },

    onHome() {
        if (! this.open) {
            return;
        }

        const firstIndex = this.options.findIndex(o => ! o.disabled && ! this.isOptgroup(o));

        if (firstIndex > -1) {
            this.focusedOptionIndex = firstIndex;

            this.scrollToOption(this.focusedOptionIndex);
        }
    },

    onEnd() {
        if (! this.open) {
            return;
        }

        const lastIndex = findLastIndex(this.options, o => ! o.disabled && ! this.isOptgroup(o));

        if (lastIndex > -1) {
            this.focusedOptionIndex = lastIndex;

            this.scrollToOption(this.focusedOptionIndex);
        }
    },

    isOptgroup(option) {
        return (option || {}).hasOwnProperty('label');
    },

    isSelected(value) {
        if (this.multiple) {
            return this.value.includes(value);
        }

        return this.value === value;
    },

    /*
     * Calling initialize now so Alpine doesn't call the function twice.
     */
    initialize($wire = null, $dispatch = null) {
        createPopper = window.Popper ? window.Popper.createPopper : window.createPopper;

        if (typeof createPopper !== 'function') {
            throw new TypeError(`<x-custom-select> requires Popper (https://popper.js.org)`);
        }

        this.data = [...normalizeOptions(this.data, this.fieldNames)];
        this.options = this.data;

        if (this.multiple) {
            this.selectedOption = [];
        }

        if (this.multiple && ! isArray(this.value)) {
            this.value = [];
        }

        if (this.multiple && this.value.length > 0) {
            this.selectedOption = this.options.find(o => ! this.isOptgroup(o) && o.value === this.value[0]);
        } else if (! this.multiple && this.value) {
            this.selectedOption = this.options.find(o => ! this.isOptgroup(o) && o.value === this.value);
        }

        this.$watch('value', value => {
            $dispatch && $dispatch('custom-select-value-changed', { id: this.selectId, value });
        });

        // Allow local filtering if user has not specified wire:filter on the custom select component.
        this.$watch('search', value => {
            if (! this.open) {
                return this.options = this.data;
            }

            // If the user specifies a "wire:filter" method, attempt to call that method,
            // otherwise just perform local search.
            if (this.wireFilter && $wire) {
                $wire[this.wireFilter](value)
                    .then(data => {
                        this.data = normalizeOptions(data, this.fieldNames);
                        this.options = this.data;
                    });

                return;
            }

            if (! value) {
                return this.options = this.data;
            }

            const lowerCasedSearch = value.toLowerCase();

            this.options = this.data
                .filter(o => ! this.isOptgroup(o) && (String(o.value).toLowerCase().includes(lowerCasedSearch) || o.text.toLowerCase().includes(lowerCasedSearch)));
        });

        if ($wire) {
            // Wire listeners are useful for selects whose options depend on other selects. On the livewire component,
            // user can emit an event with the options that should be shown in the dependant select based on some
            // criteria.
            this.wireListeners.forEach(listener => {
                $wire.on(listener, data => {
                    this.data = normalizeOptions(data, this.fieldNames);
                    this.options = this.data;
                });
            });
        }

        // Emit our value changed event right away for any listeners...
        $dispatch && $dispatch('custom-select-value-changed', { id: this.selectId, value: this.value });
    },

    onMouseover(option, index) {
        if (this.isOptgroup(option) || option.disabled) {
            return;
        }

        this.focusedOptionIndex = index;
    },

    optionClasses(option, index) {
        const classes = [];

        if (this.isOptgroup(option)) {
            classes.push('custom-select__opt-group');
        } else if (index === this.focusedOptionIndex) {
            classes.push('custom-select__option--hovered');
        }

        if (this.isSelected((option || {}).value)) {
            classes.push('custom-select__option--selected');
        }

        if (option.disabled) {
            classes.push('custom-select__option--disabled');
        }

        return classes.join(' ');
    },

    openMenu() {
        if (this.disabled) {
            return;
        }

        const firstValue = this.multiple ? this.value[0] : this.value;
        this.focusedOptionIndex = this.options.findIndex(o => o.value === firstValue && ! this.isOptgroup(o));
        if (this.focusedOptionIndex < 0) {
            this.focusedOptionIndex = this.options.findIndex(o => ! o.disabled && ! this.isOptgroup(o));
        }

        this.popper = createPopper(this.$refs.button, this.$refs.container, {
            placement: 'bottom-start',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 4],
                    },
                },
                {
                    name: 'preventOverflow',
                    options: {
                        boundary: 'clippingParents',
                    },
                },
                {
                    name: 'flip',
                    options: {
                        padding: 30,
                    },
                },
            ],
        });

        this.open = true;

        this.$nextTick(() => {
            if (this.filterable) {
                this.$refs.search.focus({
                    preventScroll: true,
                });
            }

            this.scrollToOption(this.focusedOptionIndex);
        });
    },

    optionDisplay(value) {
        if (! value) {
            return null;
        }

        let option = this.options.find(o => o.value === value);

        if (! option && this.multiple && this.selectedOption.length > 0) {
            option = this.selectedOption[0];
        } else if (! option && this.selectedOption && this.selectedOption.value === value) {
            option = this.selectedOption;
        }

        return (option || { text: null }).text;
    },

    onEnter() {
        if (! this.open) {
            return this.openMenu();
        }

        const option = this.options[this.focusedOptionIndex];

        if (option) {
            this.selectOption(option);
        }
    },

    selectOption(option) {
        if (! option) {
            return;
        }

        if (option.disabled) {
            return;
        }

        if (this.multiple) {
            return this.selectOptionForMultiple(option);
        }

        if (this.value === option.value && this.optional) {
            this.value = null;
            this.selectedOption = null;
        } else {
            this.value = option.value;
            this.selectedOption = option;
        }

        this.close();
        this.focusButton();
    },

    selectOptionForMultiple(option) {
        if (! option) {
            return;
        }

        if (this.value.includes(option.value)) {
            if (this.optional || this.value.length > 1) {
                this.value.splice(this.value.indexOf(option.value), 1);
                this.selectedOption = [...this.value];
            }

            if (this.value.length === 0) {
                this.selectedOption = [];
                this.close();
                this.focusButton();
            }

            return;
        }

        if (! this.max || Number(this.max) > this.value.length) {
            this.value.push(option.value);
            this.selectedOption = [...this.value];
        }
    },

    hasSelection() {
        if (this.multiple) {
            return this.value.length > 0;
        }

        return Boolean(this.value);
    },

    scrollToOption(index) {
        if (index === 0 && this.options.length > 1) {
            index = 1;
        }

        try {
            const child = this.$refs.listbox.children[index];
            const offsetTop = child.offsetTop;
            this.$refs.listbox.scrollTop = offsetTop || 0;

            this.$refs.listbox.children[index].focus();
        } catch (e) {}
    },

    toggle() {
        if (this.open) {
            return this.close();
        }

        this.openMenu();
    },
});
