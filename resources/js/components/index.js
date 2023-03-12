import customSelect from './custom-select';
import switchToggle from './switch-toggle';
import treeSelect from './tree-select';

document.addEventListener('alpine:init', () => {
    customSelect(Alpine);
    treeSelect(Alpine);
    Alpine.data('switchToggle', switchToggle);
});
