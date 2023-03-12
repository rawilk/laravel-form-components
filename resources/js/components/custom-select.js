import { generateContext } from '../util/customSelectContext';
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
    Alpine.data('customSelect', config => {
        return {
            ...selectPopper,

            ...selectData(config.__el, Alpine, config),

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
        }
    });

    Alpine.directive('custom-select', (el, directive, { cleanup }) => {
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

            default:
                throw new Error(`Unknown custom-select directive value: ${directive.value}`);
        }
    });

    Alpine.magic('customSelect', el => {
        return rootMagic(el, Alpine);
    });

    Alpine.magic('customSelectOption', el => {
        return optionMagic(
            el,
            Alpine,
            (data, context, optionEl) => {
                return {
                    get isOptGroup() {
                        return Alpine.bound(optionEl, 'is-opt-group');
                    },
                };
            },
            () => {
                return {
                    isOptGroup: false,
                };
            },
        );
    });
}

function handleLabel(el, Alpine) {
    Alpine.bind(el, {
        ...labelDirective(el, Alpine),
    });
}

function handleButton(el, Alpine) {
    Alpine.bind(el, {
        ...buttonDirective(el, Alpine),
    });
}

function handleSearch(el, Alpine) {
    Alpine.bind(el, {
        ...searchDirective(el, Alpine),
    });
}

function handleOptions(el, Alpine) {
    Alpine.bind(el, {
        ...optionsDirective(el, Alpine),
    });
}

function handleOption(el, Alpine) {
    Alpine.bind(el, {
        ...optionDirective(el, Alpine, 'custom'),
    });
}

function handleToken(el, Alpine) {
    Alpine.bind(el, {
        ...tokenDirective(el, Alpine),
    });
}

function handleClearButton(el, Alpine) {
    Alpine.bind(el, {
        ...clearButtonDirective(el, Alpine, 'custom'),
    });
}
