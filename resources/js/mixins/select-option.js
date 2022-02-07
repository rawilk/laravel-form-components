import { uniqueId } from '../util/id';
import { focusElementInParent } from '../util/focusElement';

export default {
    optionDisabled: false,
    optionValue: null,
    optionLabel: null,
    optionSelectedLabel: null,
    hasFocus: false,
    _id: null,
    _optionComponentName: 'select-option',
    _optionSelector: '',
    _optionIndex: -1,

    optionSelected() {
        return this._isValueSelected(this.optionValue);
    },

    _init() {
        this._id = uniqueId(this._optionComponentName);

        this.$watch('hasFocus', hasFocus => {
            if (hasFocus) {
                // `this.name` is a property that should come from the parent select component.
                this.$dispatch(`${this._componentName}-${this.name.toSlug()}-option-focused`, this._id);
            }
        });
    },

    onReceivedFocus(event) {
        const _id = event.detail;
        this.hasFocus = this._id === _id;

        if (this.hasFocus) {
            this._focusedOptionId = this._id;
        }
    },

    focus({ updateParentIndex = false, parent = null, scroll = true, block = 'end' }) {
        if (this.optionDisabled || this.hasFocus) {
            return;
        }

        parent = parent || this;

        this.hasFocus = true;

        if (scroll) {
            focusElementInParent(this.$root, parent.menu(), {
                threshold: (this.$root.querySelector(this._optionSelector) || this.$root).offsetHeight,
                block,
            });
        }

        if (updateParentIndex) {
            parent.updateFocusedOptionIndexFromElement(this.$root);
        }
    },

    toggle(options = { parentMenu: null }) {
        const parentMenu = options.parentMenu || this;

        if (this.optionDisabled || ! parentMenu.canToggleOption(this.optionValue)) {
            return;
        }

        parentMenu.toggleOption(this);
    },
};
