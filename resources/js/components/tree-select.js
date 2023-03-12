import { generateContext } from '../util/treeSelectContext';
import selectPopper from '../mixins/selectPopper';
import {
    buttonDirective,
    clearButtonDirective,
    labelDirective,
    optionsDirective,
    optionDirective,
    searchDirective,
    selectData,
    tokenDirective,
} from '../mixins/select';
import { rootMagic, optionMagic } from '../mixins/selectMagic';

export default function (Alpine) {
    Alpine.data('treeSelect', config => {
        return {
            ...selectPopper,

            ...selectData(config.__el, Alpine, config),

            __type: 'tree',

            __generateContext(el, Alpine, config) {
                return generateContext({
                    multiple: this.__isMultiple,
                    orientation: this.__orientation,
                    __wire: config.__wire,
                    __wireSearch: Alpine.bound(el, 'livewire-search'),
                    __config: config.__config ?? {},
                    Alpine,
                });
            },
        };
    });

    Alpine.directive('tree-select', (el, directive, { cleanup }) => {
        switch (directive.value) {
            case 'button':
                handleButton(el, Alpine);
                break;
            case 'label':
                handleLabel(el, Alpine);
                break;
            case 'clear':
                handleClearButton(el, Alpine);
                break;
            case 'options':
                handleOptions(el, Alpine);
                break;
            case 'option':
                handleOption(el, Alpine);

                // We need to notify the context that the option has left the DOM.
                cleanup(() => {
                    const parent = el.closest('[x-data]');

                    parent && Alpine.$data(parent).__context.destroyItem(el);
                });

                break;
            case 'search':
                handleSearch(el, Alpine);
                break;
            case 'token':
                handleToken(el, Alpine);
                break;
            case 'child-toggle':
                handleChildToggle(el, Alpine);
                break;
            case 'children':
                handleChildren(el, Alpine);
                break;

            default:
                throw new Error(`Unknown tree-select directive: ${directive.value}`);
        }
    });

    Alpine.magic('treeSelect', el => {
        return rootMagic(
            el,
            Alpine,
            data => {
                return {
                    get hasExpandableOptions() {
                        return Object.keys(data.__context.expandableEls).length > 0;
                    },
                };
            },
        );
    });

    Alpine.magic('treeSelectOption', el => {
        return optionMagic(
            el,
            Alpine,
            (data, context, optionEl) => {
                return {
                    get hasChildren() {
                        return optionEl.__children && optionEl.__children.length > 0;
                    },
                    get isExpanded() {
                        return context.isExpandedEl(optionEl);
                    },
                };
            },
            () => {
                return {
                    hasChildren: false,
                };
            },
        );
    });
}

function handleButton(el, Alpine) {
    Alpine.bind(el, {
        ...buttonDirective(el, Alpine),
    });
}

function handleLabel(el, Alpine) {
    Alpine.bind(el, {
        ...labelDirective(el, Alpine),
    });
}

function handleClearButton(el, Alpine) {
    Alpine.bind(el, {
        ...clearButtonDirective(el, Alpine, 'tree'),
    });
}

function handleOptions(el, Alpine) {
    Alpine.bind(el, {
        ...optionsDirective(el, Alpine),
    });
}

function handleOption(el, Alpine) {
    Alpine.bind(el, {
        ...optionDirective(el, Alpine, 'tree'),

        'data-tree-select-option': 'true',
        ':role'() { return 'option' },

        'x-init'() {
            const initCallback = () => {
                let value = Alpine.bound(el, 'value');
                let disabled = Alpine.bound(el, 'disabled');

                el.__level = Alpine.bound(el, 'level', 0);

                el.__optionKey = this.$data.__context.initItem(el, value, disabled);

                const childrenField = this.$data.__config.childrenField;
                if (value?.hasOwnProperty(childrenField)) {
                    el.__children = value[childrenField];
                }
            };

            // Our $customSelectOption magic only seems to work with queueMicrotask on initial page load,
            // so if our component says it's ready, we'll just run the code to initialize the option right away.
            if (this.$data.__ready) {
                initCallback();
            } else {
                queueMicrotask(initCallback);
            }
        },
    });
}

function handleSearch(el, Alpine) {
    Alpine.bind(el, {
        ...searchDirective(el, Alpine),
    });
}

function handleToken(el, Alpine) {
    Alpine.bind(el, {
        ...tokenDirective(el, Alpine),
    });
}

function handleChildToggle(el, Alpine) {
    Alpine.bind(el, {
        'x-init'() {
            if (el.tagName.toLowerCase() !== 'button') {
                el.setAttribute('role', 'button');
            }
        },
        '@click.stop.prevent'() {
            let optionEl = Alpine.findClosest(el, i => i.__optionKey);

            optionEl && this.$data.__context.toggleExpandedEl(optionEl);
        },
    });
}

// We are using this directive to hide/show the children of an option because it is out of the scope
// of where the $treeSelectOption magic will pick up on the state of the option.
function handleChildren(el, Alpine) {
    Alpine.bind(el, {
        'data-tree-select-children': 'true',
        'x-data'() {
            return {
                __optionEl: undefined,
                init() {
                    try {
                        this.__optionEl = el.parentNode.querySelector('[data-tree-select-option="true"]');
                    } catch (e) {}
                },
                get __isExpanded() {
                    return this.__optionEl && this.$data.__context.isExpandedEl(this.__optionEl);
                }
            };
        },
        'x-show'() { return this.$data.__isExpanded },
    });
}
