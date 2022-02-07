import customSelect from './custom-select';
import customSelectOption from './custom-select-option';
import treeSelect from './tree-select';
import treeSelectOption from './tree-select-option';

document.addEventListener('alpine:init', () => {
    Alpine.data('customSelect', customSelect);
    Alpine.data('customSelectOption', customSelectOption);
    Alpine.data('treeSelect', treeSelect);
    Alpine.data('treeSelectOption', treeSelectOption);
});
