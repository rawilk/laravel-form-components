import selectContext from '../mixins/selectContext';
import { keyByValue } from '../mixins/selectContext';

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
         * Tree select specific configuration.
         */

        expandableEls: {},
        expandedKeys: [],

        __itemBooted(el, value, disabled, key) {
            // We need to wait for the option to finish initializing before we can check
            // for the presence of children.
            queueMicrotask(() => {
                if (el.__children?.length) {
                    this.expandableEls[key] = el;
                }
            });
        },

        __itemDestroyed(el, key) {
            if (this.expandableEls[key]) {
                delete this.expandableEls[key];
            }

            if (this.expandedKeys.includes(key)) {
                this.expandedKeys.splice(this.expandedKeys.indexOf(key), 1);
            }
        },

        isExpandedEl(el) {
            const key = keyByValue(this.elsByKey, el);

            if (! key) {
                return;
            }

            return this.expandedKeys.includes(key);
        },

        toggleExpandedEl(el) {
            const key = keyByValue(this.elsByKey, el);

            if (! key) {
                return;
            }

            this.toggleExpanded(key);
        },

        toggleExpanded(key) {
            if (this.expandedKeys.includes(key)) {
                this.expandedKeys.splice(this.expandedKeys.indexOf(key), 1);
            } else {
                this.expandedKeys.push(key);
            }
        },

        expandChildren(key) {
            if (! this.expandedKeys.includes(key)) {
                this.expandedKeys.push(key);
            }
        },

        collapseChildren(key) {
            if (this.expandedKeys.includes(key)) {
                this.expandedKeys.splice(this.expandedKeys.indexOf(key), 1);
            }
        },

        __activateByKeyEvent(e) {
            if (! this.hasActive()) {
                return;
            }

            switch (e.key) {
                case ['ArrowRight', 'ArrowDown'][this.__orientation === 'vertical' ? 0 : 1]:
                    e.preventDefault();
                    e.stopPropagation();

                    if (this.expandableEls[this.activeKey]) {
                        this.expandChildren(this.activeKey);
                    }

                    return false;
                case ['ArrowLeft', 'ArrowUp'][this.__orientation === 'vertical' ? 0 : 1]:
                    e.preventDefault();
                    e.stopPropagation();

                    if (this.expandableEls[this.activeKey]) {
                        this.collapseChildren(this.activeKey);
                    }

                    return false;
            }
        },

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
