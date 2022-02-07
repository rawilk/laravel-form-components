import { findClosest } from '../util/findElement';
import selectOptionMixin from '../mixins/select-option';

export default options => ({
    ...selectOptionMixin,
    children: [],
    expanded: false,
    hasChildren: false,
    level: 0,
    ...options,
    _optionComponentName: 'tree-select-option',
    _optionSelector: '.tree-select-option__container',

    init() {
        this._init();

        this.$watch('expanded', () => {
            // reset parent component value
            this.focusableElements = null;
        });

        if (this.searchable) {
            // Watch parent select `search` value.
            this.$watch('search', search => {
                if (search && this.hasChildren) {
                    this.expanded = true;
                }
            });
        }
    },

    collapse({ parent = null }) {
        if (this.optionDisabled) {
            return;
        }

        if (! this.hasChildren && this.level > 0) {
            this.focusNearestParent({ parentMenu: parent });

            // Return true to let our menu know to prevent the default arrow
            // left event from bubbling up.
            return true;
        }

        const wasCollapsed = this.expanded === true;

        this.expanded = false;

        return wasCollapsed;
    },

    expand() {
        if (! this.hasChildren || this.optionDisabled) {
            return;
        }

        const wasExpanded = this.expanded === false;

        this.expanded = true;

        return wasExpanded;
    },

    focusNearestParent({ parentMenu = null }) {
        parentMenu = parentMenu || this;

        const parent = findClosest(this.$root, el => {
            try {
                const data = el._x_dataStack[0];

                if (! data) {
                    return false;
                }

                return data.level === (this.level - 1);
            } catch (e) {
                return false;
            }
        });

        if (! parent) {
            return;
        }

        try {
            parent._x_dataStack[0].focus({ updateParentIndex: true, parent: parentMenu });
        } catch (e) {}
    },
});
