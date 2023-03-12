export default Alpine => ({
    // Main state.
    searchableText: {},
    disabledKeys: [],
    activeKey: null,
    selectedKeys: [],
    orderedKeys: [],
    elsByKey: {},
    values: {},

    // These keys will be overridden by each select context implementation.
    __config: {},
    __multiple: false,
    __orientation: 'vertical',
    __wire: undefined,
    __wireSearch: undefined,

    /**
     * Initialization.
     */

    initItem(el, value, disabled, isOptGroup = false) {
        let key = (Math.random() + 1).toString(36).substring(7);

        // If the value is already selected, we will replace the key with the exising one.
        // This usually only happens when options are refreshed via ajax.
        const keyFromValue = this.getKeyFromValue(value, this.__config.by);
        if (keyFromValue) {
            key = keyFromValue;
        }

        // We don't need to track "opt groups".
        if (isOptGroup) {
            return key;
        }

        // Register value by key.
        this.values[key] = value;

        // Associate key with element.
        this.elsByKey[key] = el;

        // Register key for ordering.
        this.orderedKeys.push(key);

        // Register key for searching.
        this.searchableText[key] = el.textContent.trim().toLowerCase();

        // Store whether disabled or not.
        disabled && this.disabledKeys.push(key);

        this.__itemBooted(el, value, disabled, key);

        return key;
    },

    /**
     * This provides a way for each select implementation to hook into the initItem process.
     */
    __itemBooted(el, value, disabled, key) {},

    destroyItem(el) {
        let key = keyByValue(this.elsByKey, el);

        // We need to preserve this to keep the display on the button accurate.
        if (! this.selectedKeys.includes(key)) {
            delete this.values[key];
        }

        delete this.elsByKey[key];
        delete this.orderedKeys[this.orderedKeys.indexOf(key)];
        delete this.searchableText[key];
        delete this.disabledKeys[key];

        this.reorderKeys();

        this.__itemDestroyed(el, key);
    },

    /**
     * This provides a way for each select implementation to hook into the destroyItem process.
     */
    __itemDestroyed(el, key) {},

    resetOptions() {
        this.activeKey = null;

        this.reorderKeys();
    },

    /**
     * Handle elements.
     */

    reorderKeys() {
        // Filter out elements removed from the DOM.
        this.orderedKeys.forEach(key => {
            const el = this.elsByKey[key];

            if (el?.isConnected) {
                return;
            }

            this.destroyItem(el);
        });

        this.orderedKeys = this.orderedKeys.slice().sort((a, z) => {
            if (a === null || z === null) {
                return 0;
            }

            const aEl = this.elsByKey[a];
            const zEl = this.elsByKey[z];

            const position = aEl.compareDocumentPosition(zEl);

            if (position & Node.DOCUMENT_POSITION_FOLLOWING) {
                return -1;
            }

            if (position & Node.DOCUMENT_POSITION_PRECEDING) {
                return 1;
            }

            return 0;
        });
    },

    activeEl() {
        if (! this.activeKey) {
            return;
        }

        return this.elsByKey[this.activeKey];
    },

    isActiveEl(el) {
        const key = keyByValue(this.elsByKey, el);

        if (! key) {
            return;
        }

        return this.activeKey === key;
    },

    activateEl(el) {
        const key = keyByValue(this.elsByKey, el);

        if (! key) {
            return;
        }

        this.activateKey(key);
    },

    selectEl(el) {
        const key = keyByValue(this.elsByKey, el);

        if (! key) {
            return;
        }

        this.selectKey(key);
    },

    isSelectedEl(el) {
        const key = keyByValue(this.elsByKey, el);

        if (! key) {
            return;
        }

        return this.isSelected(key);
    },

    isDisabledEl(el) {
        const key = keyByValue(this.elsByKey, el);

        if (! key) {
            return;
        }

        return this.isDisabled(key);
    },

    hideEl(el) {
        el.style.display = 'none';
        el.setAttribute('data-hidden', 'true');
    },

    showEl(el) {
        el.style.display = '';
        el.removeAttribute('data-hidden');
    },

    isHiddenEl(el) {
        if (el.style.display === 'none') {
            return true;
        }

        return ! el.offsetParent;
    },

    scrollingCount: 0,

    activateAndScrollToKey(key) {
        // This addresses the following problem:
        // If deactivate is hooked up to mouseleave,
        // scrolling to an element will trigger deactivation.
        // This "isScrollingTo" is exposed to prevent that.
        this.scrollingCount++;

        this.activateKey(key);

        const targetEl = this.elsByKey[key];

        targetEl && targetEl.scrollIntoView({ block: 'nearest' });

        setTimeout(() => {
            this.scrollingCount--;
        }, 25);
    },

    /**
     * Handle values.
     */

    selectedBasicValueOrValues(by) {
        if (this.__multiple) {
            return this.selectedBasicValues(by);
        }

        return this.selectedBasicValue(by);
    },

    selectedBasicValues(by) {
        return this.selectedKeys.map(i => {
            const value = this.values[i];

            if (value?.hasOwnProperty(by)) {
                return value[by];
            }

            return value;
        });
    },

    selectedBasicValue(by) {
        const value = this.selectedKeys[0]
            ? this.values[this.selectedKeys[0]]
            : null;

        if (value?.hasOwnProperty(by)) {
            return value[by];
        }

        return value;
    },

    selectedValueOrValues() {
        if (this.__multiple) {
            return this.selectedValues();
        }

        return this.selectedValue();
    },

    selectedValues() {
        return this.selectedKeys.map(i => this.values[i]);
    },

    selectedValue() {
        return this.selectedKeys[0] ? this.values[this.selectedKeys[0]] : null;
    },

    selectValue(value, by) {
        value = normalizeValue(value, this.__multiple);
        by = mapByToCallback(by);

        if (this.__multiple) {
            let keys = [];

            value.forEach(i => {
                for (let key in this.values) {
                    if (by(this.values[key], i)) {
                        if (! keys.includes(key)) {
                            keys.push(key);
                        }
                    }
                }
            });

            this.selectExclusive(keys);

            return;
        }

        for (let key in this.values) {
            if (value && by(this.values[key], value)) {
                this.selectKey(key);
            }
        }

        // Handle edge cases where value is updated externally to null.
        if (value === null) {
            this.selectedKeys = [];
        }
    },

    getKeyFromValue(value, by) {
        if (! value) {
            return;
        }

        by = mapByToCallback(by);

        for (let key in this.values) {
            if (by(this.values[key], value)) {
                return key;
            }
        }
    },

    getKeyFromSimpleValue(value, by) {
        if (! value) {
            return;
        }

        by = mapByToSimpleCompareCallback(by);

        for (let key in this.values) {
            if (by(this.values[key], value)) {
                return key;
            }
        }
    },

    getObjectFromValue(value, by) {
        if (! value) {
            return;
        }

        by = mapByToSimpleCompareCallback(by);

        for (let key in this.values) {
            if (by(this.values[key], value)) {
                return this.values[key];
            }
        }
    },

    toggleValue(value, by) {
        if (! value) {
            return;
        }

        by = mapByToCallback(by);

        if (this.__multiple) {
            for (let key in this.values) {
                if (by(this.values[key], value)) {
                    this.toggleSelected(key);

                    break;
                }
            }
        }
    },

    /**
     * Handle disabled keys.
     */

    isDisabled(key) {
        return this.disabledKeys.includes(key);
    },

    /**
     * Handle selected keys.
     */

    selectKey(key) {
        if (this.isDisabled(key)) {
            return;
        }

        if (this.__multiple) {
            this.toggleSelected(key);
        } else {
            this.selectOnly(key);
        }
    },

    toggleSelected(key) {
        if (this.selectedKeys.includes(key)) {
            // If we have a minimum amount of options that must be selected, and we're greater than or equal
            // to that amount, we can't deselect this option.
            if (! this.canRemoveOptions()) {
                return;
            }

            this.selectedKeys.splice(this.selectedKeys.indexOf(key), 1);
        } else {
            this.selectedKeys.push(key);
        }
    },

    selectOnly(key) {
        this.selectedKeys = [];
        this.selectedKeys.push(key);
    },

    selectExclusive(keys) {
        // We can't just do this.selectedKeys = keys
        // because we need to preserve reactivity...
        let toAdd = [...keys];

        for (let i = 0; i < this.selectedKeys.length; i++) {
            if (keys.includes(this.selectedKeys[i])) {
                delete toAdd[toAdd.indexOf(this.selectedKeys[i])];
                continue;
            }

            if (! keys.includes(this.selectedKeys[i])) {
                delete this.selectedKeys[i];
            }
        }

        toAdd.forEach(i => {
            this.selectedKeys.push(i);
        });
    },

    clearSelected() {
        if (this.__config.optional === false) {
            return;
        }

        this.selectedKeys = [];
    },

    selectActive() {
        if (! this.activeKey) {
            return;
        }

        this.selectKey(this.activeKey);
    },

    isSelected(key) {
        return this.selectedKeys.includes(key);
    },

    firstSelectedKey() {
        return this.selectedKeys[0];
    },

    /**
     * Handle activated keys.
     */

    hasActive() {
        return !! this.activeKey;
    },

    isActiveKey(key) {
        return this.activeKey === key;
    },

    get active() {
        return this.hasActive() && this.values[this.activeKey];
    },

    activateSelectedOrFirst() {
        setTimeout(() => {
            let firstSelected = this.firstSelectedKey();

            if (firstSelected) {
                return this.activateAndScrollToKey(firstSelected);
            }

            let firstKey = this.firstKey();

            if (firstKey) {
                this.activateAndScrollToKey(firstKey);
            }
        }, 25);
    },

    activateKey(key) {
        if (this.isDisabled(key)) {
            return;
        }

        this.activeKey = key;
    },

    deactivate() {
        if (! this.activeKey) {
            return;
        }

        if (this.isScrollingTo) {
            return;
        }

        this.activeKey = null;
    },

    /**
     * Handle active key traversal.
     */

    nextKey() {
        if (! this.activeKey) {
            return;
        }

        let index = this.nonDisabledOrderedKeys.findIndex(i => i === this.activeKey)
        let targetKey = this.nonDisabledOrderedKeys[index + 1];

        if (targetKey && this.isHiddenEl(this.elsByKey[targetKey])) {
            // If the next key is hidden, we need to skip to the next visible non-disabled key.
            targetKey = this.getNextVisibleKey(index);
        }

        return targetKey || this.firstKey();
    },

    prevKey() {
        if (! this.activeKey) {
            return;
        }

        let index = this.nonDisabledOrderedKeys.findIndex(i => i === this.activeKey);
        let targetKey = this.nonDisabledOrderedKeys[index - 1];

        if (targetKey && this.isHiddenEl(this.elsByKey[targetKey])) {
            // If the previous key is hidden, we need to skip to the previous visible non-disabled key.
            targetKey = this.getPrevVisibleKey(index);
        }

        return targetKey || this.lastKey();
    },

    firstKey() {
        let targetKey = this.nonDisabledOrderedKeys[0];

        if (targetKey && this.isHiddenEl(this.elsByKey[targetKey])) {
            // If the first key is hidden, we need to skip to the next visible non-disabled key.
            targetKey = this.getNextVisibleKey(-1);
        }

        return targetKey;
    },

    lastKey() {
        let targetKey = this.nonDisabledOrderedKeys[this.nonDisabledOrderedKeys.length - 1];

        if (targetKey && this.isHiddenEl(this.elsByKey[targetKey])) {
            // If the last key is hidden, we need to skip to the previous visible non-disabled key.
            targetKey = this.getPrevVisibleKey(this.nonDisabledOrderedKeys.length);
        }

        return targetKey;
    },

    getNextVisibleKey(index) {
        let targetKey;
        let currentIndex = index + 2;
        let visibleKeyFound = false;

        while (currentIndex < this.nonDisabledOrderedKeys.length && ! visibleKeyFound) {
            targetKey = this.nonDisabledOrderedKeys[currentIndex];

            visibleKeyFound = ! this.isHiddenEl(this.elsByKey[targetKey]);

            currentIndex++;
        }

        if (! visibleKeyFound) {
            targetKey = null;
        }

        return targetKey;
    },

    getPrevVisibleKey(index) {
        let targetKey;
        let currentIndex = index - 2;
        let visibleKeyFound = false;

        while (currentIndex >= 0 && ! visibleKeyFound) {
            targetKey = this.nonDisabledOrderedKeys[currentIndex];

            visibleKeyFound = ! this.isHiddenEl(this.elsByKey[targetKey]);

            currentIndex--;
        }

        if (! visibleKeyFound) {
            targetKey = null;
        }

        return targetKey;
    },

    /**
     * Handle simple search when menu is focused.
     */

    searchQuery: '',

    clearSearch: Alpine.debounce(function () { this.searchQuery = '' }, 350),

    searchKey(query) {
        this.clearSearch();

        this.searchQuery += query;

        let foundKey;

        for (let key in this.searchableText) {
            let content = this.searchableText[key];

            if (content.startsWith(this.searchQuery)) {
                foundKey = key;
                break;
            }
        }

        if (! this.nonDisabledOrderedKeys.includes(foundKey)) {
            return;
        }

        return foundKey;
    },

    /**
     * Handle full text search from the search input.
     */

    searchableQuery: '',

    handleSearchableQuery(query) {
        if (query === this.searchableQuery) {
            return;
        }

        this.searchableQuery = query;

        if (this.__wire && this.__wireSearch) {
            this.__wire[this.__wireSearch](this.searchableQuery);

            return;
        }

        for (let key in this.searchableText) {
            const content = this.searchableText[key];
            const el = this.elsByKey[key];

            const match = this.searchableQuery
                ? content.toLowerCase().includes(this.searchableQuery.toLowerCase())
                : true;

            match
                ? this.showEl(el)
                : this.hideEl(el);
        }
    },

    /**
     * Other utils.
     */

    canRemoveOptions() {
        if (! this.__multiple && this.selectedKeys.length === 1) {
            return this.__config.optional;
        }

        const minSelected = this.__config.minSelected;

        if (Number.isNaN(minSelected) || minSelected < 1) {
            return true;
        }

        return this.selectedKeys.length > minSelected;
    },

    /**
     * Handle events.
     */

    activateByKeyEvent(e) {
        this.reorderKeys();

        if (this.__activateByKeyEvent(e) === false) {
            return;
        }

        let hasActive = this.hasActive();
        let targetKey;

        switch (e.key) {
            case 'Tab':
            case 'Backspace':
            case 'Delete':
            case 'Meta':
                break;
            case ['ArrowDown', 'ArrowRight'][this.__orientation === 'vertical' ? 0 : 1]:
                e.preventDefault();
                e.stopPropagation();
                targetKey = hasActive ? this.nextKey() : this.firstKey();
                break;
            case ['ArrowUp', 'ArrowLeft'][this.__orientation === 'vertical' ? 0 : 1]:
                e.preventDefault();
                e.stopPropagation();
                targetKey = hasActive ? this.prevKey() : this.lastKey();
                break;
            case 'Home':
            case 'PageUp':
                e.preventDefault();
                e.stopPropagation();
                targetKey = this.firstKey();
                break;
            case 'End':
            case 'PageDown':
                e.preventDefault();
                e.stopPropagation();
                targetKey = this.lastKey();
                break;
            default:
                if (e.key.length === 1) {
                    targetKey = this.searchKey(e.key);
                }

                break;
        }

        if (targetKey) {
            this.activateAndScrollToKey(targetKey);
        }
    },

    // This is a way to allow each select implementation to add their own logic to keyboard events on the options menu.
    __activateByKeyEvent(e) {},
});

export const keyByValue = (object, value) => Object.keys(object).find(key => object[key] === value);

export const isObjectOrArray = subject => typeof subject === 'object' && subject !== null;

export const renderHiddenInputs = (el, name, value) => {
    // Create input elements.
    let newInputs = generateInputs(name, value);

    // Mark them for later tracking.
    newInputs.forEach(i => i._x_hiddenInput = true);

    // Mark them for Alpine ignoring.
    newInputs.forEach(i => i._x_ignore = true);

    // Gather old elements for removal.
    let children = el.children;
    let oldInputs = [];

    for (let i = 0; i < children.length; i++) {
        let child = children[i];

        if (child._x_hiddenInput) {
            oldInputs.push(child);
        } else {
            break;
        }
    }

    // Remove old, and insert new ones into the DOM.
    window.Alpine.mutateDom(() => {
        oldInputs.forEach(i => i.remove());

        newInputs.reverse().forEach(i => el.prepend(i));
    });
};

const mapByToCallback = by => {
    if (! by) {
        by = (a, b) => a === b;
    }

    if (typeof by === 'string') {
        const property = by;
        by = (a, b) => a[property] === b[property];
    }

    return by;
};

const mapByToSimpleCompareCallback = by => {
    if (! by) {
        by = (a, b) => a === b;
    }

    if (typeof by === 'string') {
        const property = by;
        by = (a, b) => a[property] === b;
    }

    return by;
};

const normalizeValue = (value, multiple) => {
    if (! value) {
        value = (multiple ? [] : null);
    }

    if (multiple && ! Array.isArray(value)) {
        value = [value];
    }

    return value;
};

const generateInputs = (name, value, carry = []) => {
    if (isObjectOrArray(value)) {
        for (let key in value) {
            carry = carry.concat(
                generateInputs(`${name}[${key}]`, value[key])
            );
        }
    } else if (value !== null && value !== false) {
        let el = document.createElement('input');
        el.setAttribute('type', 'hidden');
        el.setAttribute('name', name);
        el.setAttribute('value', '' + value);

        return [el];
    }

    return carry;
};
