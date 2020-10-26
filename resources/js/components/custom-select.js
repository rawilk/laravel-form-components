/*
 * Custom Select Component Definition.
 *
 * Note: Not using polyfills for functions such as Array.from()
 * since I use Livewire, and Livewire already includes polyfills
 * for those functions. If you don't use Livewire, you should
 * make sure are pulling in those polyfills.
 */

import findLastIndex from '../util/findLastIndex';

export default function customSelect(state) {
    return {
        ...state,

        display: '',
        options: [],
        currentIndex: -1,
        query: '',

        get activeDescendant() {
            return this.currentIndex > -1
                ? `listbox-${this.selectId}-item-${this.currentIndex}`
                : null;
        },

        get hasValue() {
            return this.multiple
                ? this.value.length > 0
                : Boolean(this.value);
        },

        get enabledLength() {
            return this.options.filter(o => ! o.disabled && ! o.hidden).length;
        },

        get placeholderMarkup() {
            return `<span class="custom-select--placeholder">${this.placeholder}</span>`;
        },

        init($watch) {
            this.options = this.parseOptions();

            if (this.value && this.multiple && ! Array.isArray(this.value)) {
                this.value = [this.value];
            }

            this.updateDisplay(this.value);

            $watch('value', value => {
                this.updateDisplay(value);

                if (this.filterable) {
                    this.refreshOptionsIfNeeded();
                }
            });
            $watch('query', value => this.filter(value));
            $watch('wireFilter', () => {
                this.$nextTick(() => {
                    this.options = this.parseOptions();
                });
            });

            $watch('selected', value => this.onSelectedChanged(value));
        },

        filter(value) {
            const optionsToHide = this.options
                .filter(o => {
                    o.hidden = false;

                    return ! String(o.value).toLowerCase().includes(value) && ! String(o.text).toLowerCase().includes(value);
                })
                .map(o => {
                    o.hidden = true;

                    return this.optionIndex(o.value);
                });

            if (! optionsToHide.length) {
                Array.from(this.$refs.menu.children).forEach(child => child.classList.remove('hidden'));

                return;
            }

            Array.from(this.$refs.menu.children)
                .forEach(child => {
                    const index = Number(child.dataset.index);

                    if (optionsToHide.includes(index)) {
                        child.classList.add('hidden');
                    } else {
                        child.classList.remove('hidden');
                    }
                });
        },

        parseOptions() {
            return Array.from(this.$refs.menu.children)
                .filter(child => child.classList.contains('custom-select--option'))
                .map((child, index) => {
                    child.setAttribute('data-index', index);
                    child.setAttribute('id', `listbox-${this.selectId}-item-${index}`);

                    return JSON.parse(child.dataset.option)
                });
        },

        isChosen(value) {
            if (this.multiple) {
                if (! Array.isArray(this.value)) {
                    this.value = [this.value];
                }

                return this.value.includes(value);
            }

            return value === this.value;
        },

        chooseForMultiple(value) {
            if (! this.isChosen(value)) {
                this.value.push(value);
            } else if (this.optional || this.value.length > 1) {
                this.value.splice(this.value.indexOf(value), 1);
                this.updateDisplay(this.value);
            }

            if (this.value.length === 0) {
                this.closeMenu();
            }
        },

        clear() {
            this.value = this.multiple ? [] : null;
        },

        choose(value) {
            if (this.multiple) {
                return this.chooseForMultiple(value);
            }

            this.value = (this.optional && this.value === value)
                ? null
                : value;

            this.closeMenu();
        },

        closeMenu() {
            this.open = false;
            this.focusButton();
        },

        onOptionSelect() {
            if (this.currentIndex < 0) {
                return;
            }

            const option = this.options[this.currentIndex];

            if (option && ! option.disabled) {
                this.choose(option.value);
            }
        },

        // Excludes any "optgroup" elements
        optionChildren() {
            if (! this.$refs.menu) {
                return [];
            }

            return Array.from(this.$refs.menu.children)
                .filter(child => child.classList.contains('custom-select--option'));
        },

        updateDisplay(value) {
            if (! value) {
                return this.display = this.placeholderMarkup;
            }

            this.$nextTick(() => {
                if (this.multiple) {
                    return this.updateDisplayForMultiple(value);
                }

                const $li = this.optionChildren()[this.optionIndex(value)];
                this.display = $li
                    ? $li.children[0].innerHTML
                    : this.placeholderMarkup;
            });
        },

        updateDisplayForMultiple(value) {
            const length = value.length;
            if (length === 0) {
                return this.display = this.placeholderMarkup;
            }

            const $li = this.optionChildren()[this.optionIndex(value[0])];

            if (! $li) {
                return this.display = `${length} Selected`;
            }

            let display = $li.children[0].innerHTML;
            if ((length - 1) > 0) {
                display += `<span class="text-xs text-cool-gray-500">+ ${length - 1}</span>`;
            }

            this.display = display;
        },

        optionIndex(value) {
            return this.options.findIndex(o => o.value === value);
        },

        onMouseEnter(value) {
            this.selected = value;
            this.currentIndex = this.optionIndex(value);
        },

        onSelectedChanged(value) {
            if (! this.open) {
                return;
            }

            const index = this.optionIndex(value);

            if (index < 0) {
                return;
            }

            this.$nextTick(() => {
                const $li = this.optionChildren()[index];

                if (! $li) {
                    return;
                }

                const filterHasFocus = this.filterable
                    && document.activeElement === this.$refs.filter;

                $li.focus();

                if (filterHasFocus) {
                    this.focusFilter();
                }
            });
        },

        onArrowUp() {
            // If no enabled options, just return...
            if (this.enabledLength === 0) {
                this.currentIndex = -1;
                this.selected = null;

                return;
            }

            let prevIndex = findLastIndex(this.options, (o, index) => ! o.disabled && ! o.hidden && index < this.currentIndex);
            if (prevIndex < 0) {
                prevIndex = findLastIndex(this.options, o => ! o.disabled && ! o.hidden);
            }

            this.currentIndex = prevIndex;
            this.selected = this.options[this.currentIndex].value;
        },

        onArrowDown() {
            // If no enabled options, just return...
            if (this.enabledLength === 0) {
                this.currentIndex = -1;
                this.selected = null;

                return;
            }

            let nextIndex = this.options.findIndex((o, index) => index > this.currentIndex && ! o.disabled && ! o.hidden);
            if (nextIndex === -1 || (nextIndex + 1) > this.options.length) {
                nextIndex = this.options.findIndex(o => ! o.disabled && ! o.hidden);
            }

            this.currentIndex = nextIndex;
            this.selected = this.options[this.currentIndex].value;
        },

        onHome() {
            // If no enabled options, just return...
            if (this.enabledLength === 0) {
                this.currentIndex = -1;
                this.selected = null;

                return;
            }

            this.currentIndex = this.options.findIndex(o => ! o.disabled && ! o.hidden);
            this.selected = this.options[this.currentIndex].value;
        },

        onEnd() {
            // If no enabled options, just return...
            if (this.enabledLength === 0) {
                this.currentIndex = -1;
                this.selected = null;

                return;
            }

            this.currentIndex = findLastIndex(this.options, o => ! o.disabled && ! o.hidden);
            this.selected = this.options[this.currentIndex].value;
        },

        focusButton() {
            this.$nextTick(() => this.$refs.button.focus());
        },

        focusFilter() {
            this.$nextTick(() => this.$refs.filter.focus());
        },

        focusMenu() {
            this.$nextTick(() => this.$refs.menu.focus());
        },

        onShiftTab() {
            if (this.filterable) {
                this.focusFilter();
            } else {
                this.closeMenu();
            }
        },

        highlightSelectedOption() {
            if (this.multiple) {
                this.currentIndex = this.optionIndex(this.value[0]);
            } else {
                this.currentIndex = this.value
                    ? this.optionIndex(this.value)
                    : 0;
            }

            // Let's focus the first option if none of them are selected.
            if (this.currentIndex < 0 && this.enabledLength > 0) {
                this.currentIndex = 0;
            }

            this.selected = this.currentIndex > -1
                ? this.options[this.currentIndex].value
                : null;
        },

        toggle() {
            this.open = ! this.open;

            if (this.open) {
                this.$nextTick(() => {
                    this.positionMenu();
                    this.refreshOptionsIfNeeded();
                });

                this.highlightSelectedOption();
                this[this.filterable ? 'focusFilter' : 'focusMenu']();
            }
        },

        // Note: this seems like a dirty hack for when wire:model is used on the select
        // and probably should be revisited in the future to see how we can
        // prevent each option from losing its id and data-index attributes.
        refreshOptionsIfNeeded() {
            const children = this.optionChildren();

            if (! children.length || ! children[0].getAttribute('id')) {
                this.options = this.parseOptions();
            }
        },

        positionMenu() {
            this.$refs.container.classList.remove('custom-menu-top');

            // give a little bit of breathing room at the bottom of the screen.
            const tolerance = 10;
            const menuHeight = this.$refs.menu.offsetHeight;
            const largestHeight = window.innerHeight - menuHeight - tolerance;

            const { top } = this.$refs.menu.getBoundingClientRect();

            if (top > largestHeight) {
                this.$refs.container.classList.add('custom-menu-top');
            }
        },
    };
}
