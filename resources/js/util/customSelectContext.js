import selectContext from '../mixins/selectContext';

export const generateContext = ({ multiple, orientation, __wire, __wireSearch, __config, Alpine }) => {
    return {
        ...selectContext(Alpine),

        /**
         * Select configuration.
         */
        __multiple: multiple,
        __orientation: orientation,
        __wire,
        __wireSearch,
        __config,

        /**
         * Getters that don't work in the mixin for some reason...
         */

        get isScrollingTo() {
            return this.scrollingCount > 0;
        },

        get nonDisabledOrderedKeys() {
            return this.orderedKeys.filter(i => ! this.isDisabled(i));
        },
    };
};
