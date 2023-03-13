import customSelect from './custom-select';
import datePicker from './date-picker';
import switchToggle from './switch-toggle';
import treeSelect from './tree-select';

document.addEventListener('alpine:init', () => {
    customSelect(Alpine);
    datePicker(Alpine);
    treeSelect(Alpine);
    Alpine.data('switchToggle', switchToggle);
});
