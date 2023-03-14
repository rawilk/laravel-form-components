export const rootMagic = (el, Alpine, callback, stubCallback) => {
    let data = Alpine.$data(el);

    if (typeof stubCallback !== 'function') {
        stubCallback = () => ({});
    }

    if (typeof callback !== 'function') {
        callback = () => ({});
    }

    if (! data.__ready) {
        return {
            isDisabled: false,
            isOpen: false,
            selected: null,
            active: null,
            selectedObject: null,
            ...stubCallback(data),
        };
    }

    return {
        get isOpen() {
            return data.__isOpen;
        },
        get isDisabled() {
            return data.__isDisabled;
        },
        get isSearchable() {
            return data.__searchable;
        },
        get selected() {
            return data.__value;
        },
        get active() {
            return data.__context.active;
        },
        get selectedObject() {
            return data.__richValue;
        },
        get hasValue() {
            if (data.__isMultiple) {
                return data.__value && data.__value.length > 0;
            }

            return !! data.__value;
        },
        get shouldShowClear() {
            // If the input is disabled or readonly, we can't clear.
            if (data.__isDisabled) {
                return false;
            }

            // If the select is not marked as optional, at least one value is required.
            if (data.__config.optional === false) {
                return false;
            }

            // If multi-select and minSelected is a number and at least 1, then we can't clear.
            if (data.__isMultiple && ! Number.isNaN(data.__config.minSelected) && data.__config.minSelected > 0) {
                return false;
            }

            return data.__isClearable && this.hasValue;
        },
        get canSelectMore() {
            if (! data.__isMultiple) {
                return true;
            }

            // If maxSelected is not a number or less than one, then we can select as many as we want.
            if (Number.isNaN(data.__config.maxSelected) || data.__config.maxSelected < 1) {
                return true;
            }

            return data.__config.maxSelected > data.__value.length;
        },
        get canDeselectOptions() {
            if (data.__isDisabled) {
                return false;
            }

            return data.__context.canRemoveOptions();
        },
        get hasOptions() {
            // We access searchableQuery here, so a change to it will trigger this getter to re-evaluate.
            data.__context.searchableQuery;

            return data.$refs.__options &&
                data.$refs.__options.querySelectorAll('[role="option"]:not([data-hidden])').length > 0;
        },
        get hasSearch() {
            return !! data.__context.searchableQuery;
        },

        ...callback(data),
    };
};

export const optionMagic = (el, Alpine, callback, stubCallback) => {
    if (typeof stubCallback !== 'function') {
        stubCallback = () => ({});
    }

    if (typeof callback !== 'function') {
        callback = () => ({});
    }

    let data = Alpine.$data(el);

    let stub = {
        isDisabled: false,
        isSelected: false,
        isActive: false,
        ...stubCallback(data),
    };

    if (! data.__ready) {
        return stub;
    }

    let optionEl = Alpine.findClosest(el, i => i.__optionKey);

    if (! optionEl) {
        return stub;
    }

    let context = data.__context;

    return {
        get isActive() {
            return context.isActiveEl(optionEl);
        },
        get isSelected() {
            return context.isSelectedEl(optionEl);
        },
        get isDisabled() {
            return context.isDisabledEl(optionEl);
        },

        ...callback(data, context, optionEl),
    };
};
