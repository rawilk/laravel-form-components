import customSelect from './custom-select';

document.addEventListener('alpine:init', () => {
    Alpine.data('customSelect', customSelect);
});
