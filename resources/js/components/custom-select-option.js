import selectOptionMixin from '../mixins/select-option';

export default options => ({
    ...selectOptionMixin,
    ...options,
    _optionComponentName: 'custom-select-option',
    _optionSelector: '.custom-select-option__container',

    init() {
        this._init();
    },
});
