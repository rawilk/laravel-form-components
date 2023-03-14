import customSelect from './custom-select';
import datePicker from './date-picker';
import filepond from './filepond';
import quill from './quill';
import switchToggle from './switch-toggle';
import treeSelect from './tree-select';

document.addEventListener('alpine:init', () => {
    customSelect(Alpine);
    datePicker(Alpine);
    filepond(Alpine);
    quill(Alpine);
    treeSelect(Alpine);
    Alpine.data('switchToggle', switchToggle);
});
