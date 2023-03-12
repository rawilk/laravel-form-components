import { renderHiddenInputs } from './selectContext';

export function selectData(el, Alpine, config) {
    return {
        __ready: false,
        __value: config.__value ?? false,
        __richValue: false,
        __isOpen: false,
        __context: undefined,
        __isMultiple: false,
        __isStatic: false,
        __isClearable: undefined,
        __isDisabled: false,
        __compareBy: null,
        __inputName: undefined,
        __fixed: false,
        __searchable: undefined,
        __hasCustomSelectLabel: false,
        __orientation: 'vertical',
        __externalChanged: false,
        __config: config.__config,
        __wireSearch: undefined,
        __type: 'custom',

        init() {
            this.__createPopper = window.Popper ? window.Popper.createPopper : window.createPopper;

            if (typeof this.__createPopper !== 'function') {
                throw new TypeError(`${this.__type}-select requires Popper.js (https://popper.js.org)`);
            }

            this.__isMultiple = Alpine.bound(el, 'data-multiple', false);
            this.__isDisabled = Alpine.bound(el, 'disabled', false) || Alpine.bound(el, 'readonly', false);
            this.__inputName = Alpine.bound(el, 'name', null);
            this.__compareBy = Alpine.bound(el, 'by');
            this.__orientation = Alpine.bound(el, 'horizontal') ? 'horizontal' : 'vertical';
            this.__searchable = Alpine.bound(el, 'searchable', false);
            this.__isClearable = Alpine.bound(el, 'clearable', false);
            this.__wireSearch = Alpine.bound(el, 'livewire-search');
            this.__fixed = Alpine.bound(el, 'fixed', false);

            const autoFocus = Alpine.bound(el, 'autofocus');

            this.__context = this.__generateContext(el, Alpine, config);

            const defaultValue = Alpine.bound(el, 'default-value', null);
            if (defaultValue && ! this.__value) {
                this.__value = defaultValue;
            }

            // We have to wait for the rest of the HTML to initialize in Alpine before
            // we can mark this component as "ready".
            queueMicrotask(() => {
                this.__ready = true;

                // We have to wait again after the "ready" processes are finished
                // to settle up currently selected values (this prevents this next bit
                // of code from running multiple times on startup).
                queueMicrotask(() => {
                    // This "fingerprint" acts as a checksum of the last-known "value"
                    // passed into x-model. We need to track this so that we can determine
                    // from the reactive effect if it was the value that changed externally
                    // or an option was selected internally.
                    let lastValueFingerprint = false;

                    Alpine.effect(() => {
                        // Accessing the selected keys, so a change in it always triggers this effect.
                        this.__context.selectedKeys;

                        if (lastValueFingerprint === false || lastValueFingerprint !== JSON.stringify(this.__value)) {
                            // Here we know that the value changed externally, and we can add the selection.
                            this.__externalChanged = true;

                            if (this.__isMultiple) {
                                this.__context.clearSelected();

                                const keys = [];

                                for (let value of this.__value) {
                                    const object = this.__context.getObjectFromValue(value, this.__compareBy);
                                    object && keys.push(object);
                                }

                                this.__context.selectValue(keys, this.__compareBy);
                                this.__richValue = this.__context.selectedValueOrValues();
                            } else {
                                if (typeof this.__value !== 'object' && ! Array.isArray(this.__value) && this.__value !== null) {
                                    const key = this.__context.getKeyFromSimpleValue(this.__value, this.__compareBy);
                                    key && this.__context.selectKey(key);
                                } else {
                                    this.__context.selectValue(this.__value, this.__compareBy);
                                }

                                this.__richValue = this.__context.selectedValueOrValues();
                            }
                        } else {
                            // Here we know that an option was selected, and we can change the value.
                            this.__value = this.__context.selectedBasicValueOrValues(this.__compareBy);
                            this.__richValue = this.__context.selectedValueOrValues();
                        }

                        // Generate the "value" checksum for comparison next time.
                        lastValueFingerprint = JSON.stringify(this.__value);

                        // Everytime the value changes, we need to re-render the hidden inputs
                        // if a user passed the "name" prop.
                        this.__inputName && renderHiddenInputs(this.$el, this.__inputName, this.__value);
                    });

                    // If select is searchable, we want to hide any opt groups when a query is present.
                    if (this.__searchable) {
                        Alpine.effect(() => {
                            const query = this.__context.searchableQuery;

                            this.$refs.__options && this.$refs.__options.querySelectorAll('[role="presentation"]:not([data-placeholder="true"])').forEach(el => {
                                if (query) {
                                    this.__context.hideEl(el);
                                } else {
                                    this.__context.showEl(el);
                                }
                            });
                        });
                    }

                    (autoFocus && this.$refs.__button) && this.$refs.__button.focus({ preventScroll: true });
                });
            });

            this.$watch('__value', newValue => {
                this.$dispatch('input', newValue);
            });

            this.__componentBooted(el, Alpine, config);
        },

        __open() {
            if (this.__isDisabled) {
                return;
            }

            this.__isOpen = true;

            this.__context.activateSelectedOrFirst();

            // Safari needs more of a "tick" for focusing after x-show for some reason.
            // Probably because Alpine adds an extra tick when x-showing for @click.outside.
            let nextTick = callback => requestAnimationFrame(() => requestAnimationFrame(callback));

            nextTick(() => {
                if (this.__searchable && this.$refs.__search) {
                    this.$refs.__search.focus({ preventScroll: true });
                } else {
                    this.$refs.__options.focus({ preventScroll: true });
                }

                this.__initPopper();
            });
        },

        __close() {
            this.__isOpen = false;
            this.__resetPopper();

            this.$nextTick(() => this.$refs.__button.focus({ preventScroll: true }));
        },

        __generateContext(el, Alpine, config) {},

        __componentBooted(el, Alpine, config) {},
    };
}

export function buttonDirective(el, Alpine) {
    return {
        'x-ref': '__button',
        ':id'() { return this.$id(`fc-${this.__type}-select-button`) },
        'aria-haspopup': 'true',
        'data-custom-select-button': 'true',
        ':aria-labelledby'() { return this.$data.__hasCustomSelectLabel ? this.$id(`fc-${this.__type}-select-label`) : this.$id('fc-label') },
        ':aria-expanded'() { return this.$data.__isOpen },
        ':aria-controls'() { return this.$data.__isOpen && this.$id(`fc-${this.__type}-select-options`) },
        ':tabindex'() { return this.$data.__isDisabled ? '-1' : '0' },
        'x-init'() {
            if (this.$el.tagName.toLowerCase() === 'button' && ! this.$el.hasAttribute('type')) {
                this.$el.type = 'button';
            }

            if (this.$el.tagName.toLowerCase() !== 'button') {
                this.$el.setAttribute('role', 'button');
            }
        },
        '@click'() { this.$data.__open() },
        '@focus'() { this.$data.__isDisabled && this.$el.blur() },
        '@keydown'(e) {
            if (['ArrowDown', 'ArrowUp', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
                e.stopPropagation();
                e.preventDefault();

                this.$data.__open();
            }

            const $magic = this.__type === 'tree' ? this.$treeSelect : this.$customSelect;

            if (e.key === 'Backspace') {
                e.stopPropagation();
                e.preventDefault();

                if (this.$data.__isDisabled) {
                    return;
                }

                const lastSelected = this.$data.__isMultiple
                    ? $magic.selectedObject[$magic.selectedObject.length - 1]
                    : $magic.selectedObject;

                lastSelected && this.$data.__context.toggleValue(lastSelected, this.$data.__compareBy);
            }
        },
        '@keydown.space.stop.prevent'() { this.$data.__open() },
        '@keydown.enter.stop.prevent'() { this.$data.__open() },
    };
}

export function labelDirective(el, Alpine) {
    return {
        'x-ref': '__label',
        ':id'() { return this.$id(`fc-${this.__type}-custom-select-label`) },
        'x-init'() {
            this.$data.__hasCustomSelectLabel = true;
        },
        '@click'() { this.$refs.__button.focus({ preventScroll: true }) },
    };
}

export function clearButtonDirective(el, Alpine, type) {
    const magic = type === 'tree' ? '$treeSelect' : '$customSelect';

    return {
        ':tabindex'()  { return (this.$data.__isDisabled || ! this[magic].hasValue) ? false : '0' },
        'x-show'() { return this[magic].shouldShowClear },
        'x-init'() {
            if (this.$el.tagName.toLowerCase() === 'button' && ! this.$el.hasAttribute('type')) {
                this.$el.type = 'button';
            }

            if (this.$el.tagName.toLowerCase !== 'button') {
                this.$el.setAttribute('role', 'button');
            }
        },
        '@click.stop.prevent'() {
            if (this.$data.__isDisabled) {
                return;
            }

            this.$data.__context.clearSelected();
            this.$data.__close();

            // Our value is not reacting to the changes made in context, so we'll set it manually.
            this.$data.__value = this.$data.__isMultiple ? [] : null;
        },
        '@keydown.space.stop.prevent'() {
            if (this.$data.__isDisabled) {
                return;
            }

            this.$data.__context.clearSelected();
            this.$data.__close();

            // Our value is not reacting to the changes made in context, so we'll set it manually.
            this.$data.__value = this.$data.__isMultiple ? [] : null;
        },
    };
}

export function optionsDirective(el, Alpine) {
    return {
        'x-ref': '__options',
        ':id'() { return this.$id(`fc-${this.__type}-select-options`) },
        'x-init'() {
            this.$data.__isStatic = Alpine.bound(this.$el, 'static', false);
        },
        'x-show'() { return this.$data.__isStatic ? true : this.$data.__isOpen },
        '@click.outside'() { this.$data.__close() },
        '@keydown.escape.stop.prevent'() { this.$data.__close() },
        tabindex: '0',
        role: 'listbox',
        ':aria-orientation'() {return this.$data.__orientation },
        ':aria-labelledby'() { return this.$id(`fc-${this.__type}-select-button`) },
        ':aria-activedescendant'() { return this.$data.__context.activeEl() && this.$data.__context.activeEl().id },
        ':aria-multiselectable'() { return this.$data.__isMultiple ? 'true' : 'false' },
        '@focus'() { this.$data.__context.activateSelectedOrFirst() },
        'x-trap'() { return this.$data.__isOpen },
        '@keydown'(e) { this.$data.__context.activateByKeyEvent(e) },
        '@keydown.enter.stop.prevent'() {
            this.$data.__context.selectActive();

            this.$data.__isMultiple || this.$data.__close();
        },
        '@keydown.space.stop.prevent'() {
            this.$data.__context.selectActive();

            this.$data.__isMultiple || this.$data.__close();
        },
    };
}

export function optionDirective(el, Alpine, type) {
    const rootMagic = type === 'tree' ? '$treeSelect' : '$customSelect';
    const magic = type === 'tree' ? '$treeSelectOption' : '$customSelectOption';

    return {
        ':id'() { return this.$id(`fc-${this.__type}-select-option`) },
        ':tabindex'() { return this.$data.__isDisabled ? false : '-1' },
        ':role'() { return this[magic].isOptGroup ? 'presentation' : 'option' },
        'x-init'() {
            const initCallback = () => {
                let value = Alpine.bound(el, 'value');
                let disabled = Alpine.bound(el, 'disabled');
                let isOptGroup = Alpine.bound(el, 'is-opt-group');

                el.__optionKey = this.$data.__context.initItem(el, value, disabled, isOptGroup);
            };

            // Our $customSelectOption magic only seems to work with queueMicrotask on initial page load,
            // so if our component says it's ready, we'll just run the code to initialize the option right away.
            if (this.$data.__ready) {
                initCallback();
            } else {
                queueMicrotask(initCallback);
            }
        },
        ':aria-selected'() { return this[magic].isSelected },
        ':aria-disabled'() { return this[magic].isDisabled },
        '@click'() {
            if (this.$data.__isDisabled || this[magic].isDisabled) {
                return;
            }

            if (! this[magic].isSelected && ! this[rootMagic].canSelectMore) {
                return;
            }

            this.$data.__context.selectEl(el);

            this.$data.__isMultiple || this.$data.__close();
        },
        '@mousemove'() { this.$data.__context.activateEl(el) },
        '@mouseleave'() { this.$data.__context.deactivate() },
    };
}

export function searchDirective(el, Alpine) {
    return {
        'x-ref': '__search',
        ':id'() { return this.$id(`fc-${this.__type}-select-search`) },
        'x-init'() {
            // When using livewire search, the directive re-evaluates even when inside a wire:ignore,
            // so we'll need to re-populate the value of the search query, so we don't lose it...
            const searchableQuery = this.$data.__context.searchableQuery;
            this.$el.value = searchableQuery;

            if (this.$data.__ready && this.$data.__isOpen && searchableQuery.length) {
                this.$nextTick(() => {
                    if (this.$el.createTextRange) {
                        let range = this.$el.createTextRange();
                        range.move('character', searchableQuery.length);
                        range.select();
                    } else {
                        // This sets the cursor position to the end of the input and prevents
                        // the entire text from being highlighted. IMO this creates a better UX.
                        this.$el.focus();
                        this.$el.setSelectionRange && this.$el.setSelectionRange(searchableQuery.length, searchableQuery.length);
                    }
                });
            }
        },
        '@keyup.debounce.250ms'(e) {
            // We don't want our keyboard nav events to trigger this.
            const keysToSkip = [
                'Enter',
                'ArrowDown',
                'ArrowUp',
                'ArrowRight',
                'ArrowLeft',
                'Home',
                'PageUp',
                'End',
                'PageDown',
                'Tab',
                'Meta',
            ];
            if (keysToSkip.includes(e.key)) {
                return;
            }

            this.$data.__context.handleSearchableQuery(e.target.value);
        },
        // Prevent our option handler from firing when we're typing in the search box.
        '@keydown.space.stop'() {},
        '@keydown.tab.prevent.stop'() {
            // Options has x-trap on it, which prevent us from tabbing out of the search box.
            // We'll allow the user to tab to the options, which will allow selecting an option using the space key.
            this.$refs.__options.focus();
        }
    };
}

export function tokenDirective(el, Alpine) {
    return {
        ':tabindex'() { return this.$data.__isDisabled ? false : '0' },
        ':role'() { return this.$el.tagName.toLowerCase() !== 'button' && ! this.$data.__isDisabled ? 'button' : false },
        'x-init'() {
            const initCallback = () => {
                el.__key = this.$data.__context.getKeyFromValue(el.value);
            };

            if (this.$data.__ready) {
                initCallback();
            } else {
                queueMicrotask(initCallback);
            }
        },
        '@click.stop.prevent'() {
            if (this.$data.__isDisabled || ! el.__key) {
                return;
            }

            this.$data.__context.toggleSelected(el.__key);
        },
        '@keydown.space.stop.prevent'() {
            if (this.$data.__isDisabled || ! el.__key) {
                return;
            }

            this.$data.__context.toggleSelected(el.__key);
        },
    };
}
