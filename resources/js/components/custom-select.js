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
        previousDisplay: '',
        needsHiddenInput: false,

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
            if (! this.$refs.container || ! this.$refs.menu) {
                // Keep trying to init until we see them...
                setTimeout(() => this.init($watch), 250);

                return;
            }

            this.options = this.parseOptions();

            if (this.value && this.multiple && ! Array.isArray(this.value)) {
                this.value = [this.value];
            }

            this.updateDisplay(this.value);

            $watch('value', value => {
                this.updateDisplay(value);
            });
            $watch('query', value => this.filter(value));
            $watch('wireFilter', () => {
                this.$nextTick(() => {
                    this.options = this.parseOptions();
                });
            });

            $watch('selected', value => this.onSelectedChanged(value));

            this.needsHiddenInput = this.multiple && this.wireFilter !== undefined;
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
                this.value.splice(this.value.indexOf(String(value)), 1);
                this.updateDisplay(this.value);
            }

            this.setHiddenInputSelection(this.value);

            if (this.value.length === 0) {
                this.closeMenu();
            }
        },

        setHiddenInputSelection(value) {
            if (! this.needsHiddenInput) {
                return;
            }

            window.sessionStorage.setItem(`cs-${this.selectId}-selected`, JSON.stringify(value));
        },

        clear() {
            if (! this.needsHiddenInput) {
                return this.value = this.multiple ? [] : null;
            }

            this.value.forEach(v => this.choose(v));

            window.sessionStorage.removeItem(`cs-${this.selectId}-selected`);
            window.sessionStorage.setItem(`cs-${this.selectId}-cleared`, '1');
        },

        choose(value, $event) {
            if (! this.shouldChoose(value, $event)) {
                return;
            }

            if (this.multiple) {
                return this.chooseForMultiple(value);
            }

            this.value = (this.optional && this.value === value)
                ? null
                : value;

            this.closeMenu();
        },

        // This feels really hacky, and should probably be re-visited at some point...
        shouldChoose(value, $event = null) {
            if (! this.needsHiddenInput || ! $event) {
                return true;
            }

            const lastEvent = window.sessionStorage.getItem(`cs-${this.selectId}-last-event`);

            if (window.sessionStorage.getItem(`cs-${this.selectId}-cleared`) !== null) {
                window.sessionStorage.removeItem(`cs-${this.selectId}-cleared`);
                window.sessionStorage.setItem(`cs-${this.selectId}-temp-selected`, JSON.stringify([]));
            }

            if (lastEvent !== String($event.timeStamp)) {
                window.sessionStorage.setItem(`cs-${this.selectId}-last-event`, String($event.timeStamp));

                return true;
            }

            let selected = JSON.parse(
                window.sessionStorage.getItem(`cs-${this.selectId}-selected`) || JSON.stringify([])
            );

            if (window.sessionStorage.getItem(`cs-${this.selectId}-temp-selected`) !== null) {
                selected = selected.filter(o => o === value);

                window.sessionStorage.removeItem(`cs-${this.selectId}-temp-selected`);
                window.sessionStorage.setItem(`cs-${this.selectId}-selected`, JSON.stringify(selected));
            }

            this.value = [];
            this.value = selected;

            return false;
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
                this.previousDisplay = '';

                return this.display = this.placeholderMarkup;
            }

            const $li = this.optionChildren()[this.optionIndex(value[0])];

            if (! $li && ! this.previousDisplay) {
                return this.display = `${length} Selected`;
            }

            let display = $li ? $li.children[0].innerHTML : this.previousDisplay;
            this.previousDisplay = display;
            if ((length - 1) > 0) {
                display += `<span class="text-xs text-cool-gray-500 flex items-center">+ ${length - 1}</span>`;
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
            this.$nextTick(() => this.$refs.filter && this.$refs.filter.focus());
        },

        focusMenu() {
            this.$nextTick(() => this.$refs.menu && this.$refs.menu.focus());
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

            this.open && this.openMenu();
        },

        openMenu() {
            if (! this.$refs.container || ! this.$refs.menu) {
                // Keep trying to perform these steps until the element appears...
                setTimeout(() => this.openMenu(), 250);

                return;
            }

            this.$nextTick(() => {
                this.positionMenu();
                this.refreshOptionsIfNeeded();
            });

            this.highlightSelectedOption();
            this[this.filterable ? 'focusFilter' : 'focusMenu']();
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
            if (! this.$refs.container) {
                // Try again later...
                setTimeout(() => this.positionMenu(), 250);

                return;
            }

            if (this.fixedPosition) {
                this.positionFixedMenu();

                return;
            }

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

        positionFixedMenu() {
            // So we can accurately determine where it should be placed...
            this.$refs.container.style.position = 'absolute';
            this.$refs.container.style.top = null;

            const { width, left: buttonLeft, top: buttonTop } = this.$refs.button.getBoundingClientRect();

            // give a little bit of breathing room at the bottom of the screen.
            const tolerance = 10;
            const menuHeight = this.$refs.menu.offsetHeight;
            const largestHeight = window.innerHeight - menuHeight - tolerance;

            const { top } = this.$refs.menu.getBoundingClientRect();

            if (top > largestHeight) {
                const menuTop = buttonTop - menuHeight - tolerance;
                this.$refs.container.style.top = `${menuTop}px`;
            } else {
                this.$refs.container.style.top = `${top}px`;
            }

            this.$refs.container.style.position = 'fixed';
            this.$refs.container.style.width = `${width}px`;
            this.$refs.container.style.left = `${buttonLeft}px`;
        },
    };
}
