import customSelect from './custom-select';
import datePicker from './date-picker';
import filepond from './filepond';
import switchToggle from './switch-toggle';
import treeSelect from './tree-select';

document.addEventListener('alpine:init', () => {
    customSelect(Alpine);
    datePicker(Alpine);
    filepond(Alpine);
    treeSelect(Alpine);
    Alpine.data('switchToggle', switchToggle);
});
